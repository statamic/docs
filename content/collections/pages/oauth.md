---
id: 3dbb14fd-a762-4891-bce1-daf13b8c5981
blueprint: page
title: OAuth
template: page
pro: true
related_entries:
  - 6b691e04-8f28-4eb2-8288-b61433883fe4
  - f7676fe0-abb3-4a05-8530-6d23a9b5130d
  - 9c953755-175e-48c1-a196-b840f5620587
  - 5eab02e3-c76b-4f44-a304-6a78877d099f
---
## Overview

OAuth authentication is powered by [Laravel Socialite](https://github.com/laravel/socialite), with built-in support for Facebook, Twitter, Google, LinkedIn, GitHub, and Bitbucket.

Need something else? The [Socialite Providers][socialite-providers] GitHub org has over 100 more pre-built providers ready to go.

And if your provider isn't on either list — maybe it's a custom one for your own app — you can [roll your own](#custom-providers).

## Installing Socialite

Install Socialite with Composer:

``` shell
composer require laravel/socialite
```

Enable OAuth in `config/statamic/oauth.php` or your environment file:

``` env
STATAMIC_OAUTH_ENABLED=true
```

Add the provider to the [oauth config](#configuration) so login buttons show up on the CP login form:

``` php
'providers' => [
    'github',
    'apple',
    // etc
],
```

Drop your provider's credentials into `config/services.php` with a [callback URL](#routes), as covered in the Socialite docs:

``` php
'github' => [
    'client_id' => env('GITHUB_CLIENT_ID'),
    'client_secret' => env('GITHUB_CLIENT_SECRET'),
    'redirect' => 'http://your-site.com/oauth/github/callback',
],
```

Using a third-party provider? Jump to the steps [below](#third-party-providers).

## Usage

OAuth handles logging in _and_ creating accounts.

### Authenticating

Send users to the provider's login URL to kick off the OAuth flow. Configured providers get buttons on the Control Panel login page automatically — or wire it up on the front-end with the [`oauth` tag][tag]:

```
<a href="{{ oauth:github }}">Log in with GitHub</a>

{{# or with a loop... #}}

{{ oauth }}
  <a href="{{ url }}">Log in with {{ label }}</a>
{{ /oauth }}
```

See the [tag docs][tag] for more.

### Creating accounts

If someone's logged out and no existing user matches the provider account, a new user gets created on first login. Turn that off with the `create_user` [config option](#user-flow).

Only a subset of data is copied onto the new account — customize that under [customizing user data](#customizing-user-data).

### Connecting accounts

Users can connect their account to any configured providers from their Control Panel account area.

On the front-end, build your own connect/disconnect UI with the [`oauth` tags][tag].

## Configuration

Everything lives in `config/statamic/oauth.php`.

### Providers

List the providers you want so login buttons appear on the CP login page.

You can pass just the provider name, or a name/label pair if you want to customize the display:

``` php
'providers' => [
    'facebook',
    'github' => 'GitHub',
    'twitter',
],
```

If a provider needs ["stateless authentication"](https://laravel.com/docs/socialite#stateless-authentication), pass an array with the `stateless` option:

``` php
'providers' => [
    'saml2' => ['stateless' => true, 'label' => 'Okta'],
],
```

One catch: existing accounts can't connect to a stateless OAuth provider. Those are for creating fresh accounts only.

### Routes

Three routes make up the OAuth workflow:

- A **login** redirect — sends users to the provider's login page
- A **callback** — where the provider sends them after a successful login
- A **disconnect** — unlinks a provider from the current user's account

Customize them in `config/statamic/oauth.php`:

``` php
'routes' => [
    'login' => 'oauth/{provider}',
    'callback' => 'oauth/{provider}/callback',
    'disconnect' => 'oauth/{provider}/disconnect',
],
```

When you create the OAuth app with your provider, you'll need to give them that callback URL.

### User flow

Here's the full flow, plus the config options that steer it:

```mermaid
flowchart TD
    Start(["User clicks Log in button"]) --> Provider[Redirected to provider<br/>to authenticate]
    Provider --> Callback[Redirected back<br/>to your site]
    Callback --> UserConnected{Connected<br/>previously?}
    UserConnected -->|Yes| MergeEnabled{Merge user data?}
    MergeEnabled -->|Yes| Merge[Update user with<br/>latest data from provider]
    MergeEnabled -->|No| LoggedIn
    UserConnected -->|No| CreateEnabled{Create new users?}
    CreateEnabled -->|Yes| Create[Create a new user]
    CreateEnabled -->|No| Denied[Redirect to<br/>unauthorized page]
    Create --> LoggedIn
    Merge --> LoggedIn([User is logged in])

    class LoggedIn ok
    class Denied nope
```

You can customize this flow:

| Option | Description |
|--------|-------------|
| `create_user` | Whether a new user account should be created when no matching user is found. If `false`, they'll be redirected to the unauthorized page instead. |
| `merge_user_data` | Whether an existing user's data should be updated with the latest data from the provider each time they log in. |
| `unauthorized_redirect` | Where to send someone who's denied access (for example, when `create_user` is `false` and no matching user exists). Leave it `null` to use the Control Panel's unauthorized page when applicable, or fall back to the home page. |

## Third party providers

If Socialite doesn't support your provider natively, use [SocialiteProviders][socialite-providers].

1. Require the provider with Composer:
    ```
    composer require socialiteproviders/dropbox
    ```

2. Register an event listener in your `AppServiceProvider`'s `boot` method:
    ```php
    // app/Providers/AppServiceProvider.php

    Event::listen(function (\SocialiteProviders\Manager\SocialiteWasCalled $event) {
        $event->extendSocialite('dropbox', \SocialiteProviders\Dropbox\Provider::class);
    });
    ```

    Or, if you've got an `EventServiceProvider.php`, register it there instead:

    ```php
    protected $listen = [
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            'SocialiteProviders\\Dropbox\\DropboxExtendSocialite@handle',
        ],
    ];
    ```

3. Add the credentials to `config/services.php`:
    ``` php
    'dropbox' => [
        'client_id' => env('DROPBOX_CLIENT_ID'),
        'client_secret' => env('DROPBOX_CLIENT_SECRET'),
        'redirect' => 'http://your-site.com/oauth/dropbox/callback',
    ],
    ```

4. Add the provider to `config/statamic/oauth.php`:
    ``` php
    'providers' => [
        'dropbox',
    ],
    ```

## Custom providers

Provider not in Socialite or [SocialiteProviders][socialite-providers]? Build your own.

You'll need a SocialiteProviders-ready provider — just the event handler (e.g. `DropboxExtendSocialite.php`) and the provider class (e.g. `Dropbox.php`).

Follow the [third party installation steps](#third-party-providers), but skip the Composer bits. Keep the classes somewhere in your project and you're good.

## Customizing user data

After authenticating with the provider, the matching user is retrieved — or created if one doesn't exist. Customize that behavior with a callback in your `AppServiceProvider`.

### User data

Only `name` is added to the user out of the box. Want more? Return an array from the provider's `withUserData` callback.

The closure gets:
- an instance of `Laravel\Socialite\Contracts\User`
- the existing `Statamic\Contracts\Auth\User`, if there is one

``` php
use Statamic\Facades\OAuth;

OAuth::provider('github')
     ->withUserData(fn ($socialiteUser, $statamicUser) => [
        'name' => $socialiteUser->getName(),
        'created_at' => optional($statamicUser)->created_at
                        ?? now()->format('Y-m-d'),
    ]);
```

:::warning
This data gets merged into the user _every_ time they log in with OAuth — including if they already had a non-OAuth account.
:::

### Customize entire user creation

Want full control over the user object being created? Return a user from the provider's `withUser` callback. The closure gets an instance of `Laravel\Socialite\Contracts\User`.

``` php
use Statamic\Facades\User;
use Statamic\Facades\OAuth;

OAuth::provider('github')->withUser(function ($user) {
    return User::make()
        ->email($user->getEmail())
        ->set('name', $user->getName());
});
```

:::warning
This only runs when the user is first created. To also update data on every login, pair it with `withUserData`:

```php
public function boot()
{
    OAuth::provider('github')
        ->withUserData(fn ($user) => $this->userData($user))
        ->withUser(function ($user) {
            return User::make()
                ->email($user->getEmail())
                ->data($this->userData($user));
        });
}

private function userData($user)
{
    return [
        'name' => $user->getName(),
    ];
}
```
:::

[socialite-providers]: https://socialiteproviders.com/
[tag]: /tags/oauth

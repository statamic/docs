---
title: OAuth
template: page
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1568645300
id: 3dbb14fd-a762-4891-bce1-daf13b8c5981
blueprint: page
stage: 1
---
Statamic lets your users authenticate with OAuth using [Laravel Socialite](https://github.com/laravel/socialite).

Out of the box, Statamic supports the bundled with Socialite providers (Facebook, Twitter, Google, LinkedIn, GitHub, and Bitbucket).

The [Socialite Providers][socialite-providers] Github organization contains over 100 additional providers requiring minimal effort to install.

Finally, if you require a provider not on the list, you may write your own.

## Installation

Install Laravel Socialite:

``` bash
composer require laravel/socialite
```

Enable OAuth in `config/statamic/oauth.php` or in your environment file:

``` .env
STATAMIC_OAUTH_ENABLED=true
```

Add the provider to the [oauth config](#configuration). This will allow Statamic to add buttons to the CP login form.

``` php
'providers' => [
    'github',
],
```

Add your provider's credentials to `config/services.php` and [callback URL](#routes) as per the Socialite documentation:

``` php
'github' => [
    'client_id' => env('GITHUB_CLIENT_ID'),
    'client_secret' => env('GITHUB_CLIENT_SECRET'),
    'redirect' => 'http://your-site.com/oauth/github/callback',
],
```

If you plan to use a third party provider, follow the steps [below](#third-party-providers).

## Usage

Send your users to the provider’s login URL to begin the OAuth workflow. You may do this with the `oauth` tag:

```
<a href="{{ oauth:github }}">Log in with Github</a>
```

Once they've logged in at their provider's site, they will be redirected back to your site where a Statamic user account will either be retrieved or created.
They will then be automatically logged into your site with the Statamic account.

You may [customize how the user is created](#customizing-user-data).


## Configuration

OAuth behavior may be configured in `config/statamic/oauth.php`.

### Providers

You should add your intended OAuth providers to the config so Statamic can provide your users with buttons on the login page.

You can specify just the name of the provider, or use a name/label pair if you would like to customize how it's displayed.

``` php
'providers' => [
    'facebook',
    'github' => 'GitHub',
    'twitter',
],
```

### Routes

There are 2 required routes in order for the OAuth workflow to function:
  - A login redirect route, which sends users to the provider's login page.
  - A callback route, which the provider will redirect to after a successful login.

You may customize these in `config/statamic/oauth.php`:

``` php
'routes' => [
    'login' => 'oauth/{provider}',
    'callback' => 'oauth/{provider}/callback'
],
```

When you create your OAuth application, you will need to provide the callback URL.

## Third Party Providers

If you would like to use a provider not natively supported by Socialite, you should use the [SocialiteProviders][socialite-providers] method.

Require the appropriate provider using Composer:

```
composer require socialiteproviders/dropbox
```

Ensure the `SocialiteProviders\Manager\ServiceProvider` is present in `config/app.php`:

```php
'providers' => [
    // (...)
    SocialiteProviders\Manager\ServiceProvider::class,
    // (...)
];
```

Add the event listener to your EventServiceProvider:

``` php
protected $listen = [
    \SocialiteProviders\Manager\SocialiteWasCalled::class => [
        'SocialiteProviders\\Dropbox\\DropboxExtendSocialite@handle',
    ],
];
```

Add the service credentials to `config/services.php` config:

``` php
'dropbox' => [
    'client_id' => env('DROPBOX_CLIENT_ID'),
    'client_secret' => env('DROPBOX_CLIENT_SECRET'),
    'redirect' => 'http://your-site.com/oauth/dropbox/callback',
],
```

Add the provider to the `config/statamic/oauth.php` config:

``` php
'providers' => [
    'dropbox',
],
```

## Custom Providers

If your OAuth provider isn’t already available, you may create your own.

Before you dive into creating your own, you should check the [SocialiteProviders][socialite-providers] site, there’s already over 100 of them, ready for you to drop in.

To create your own OAuth provider, you should make your own SocialiteProvider-ready provider. All that's needed is the event handler (eg. `DropboxExtendSocialite.php`) and the provider (eg. `Dropbox.php`).

Follow the [third party installation steps](#third-party-providers), but skip the Composer bits. You can just keep the classes somewhere in your project.

## Customizing User Data

After authenticating with the provider, Statamic will try to retrieve the corresponding user, or create one if it doesn't exist.

You may customize how it's done by adding a callback to your `AppServiceProvider`.

### User data

The only data added to the user will be their `name`. If you would like to customize what gets created, you can return an array from the provider's `withUser` callback. The closure will be given an instance of `Laravel\Socialite\Contracts\User`.

``` php
use Statamic\Facades\OAuth;

OAuth::provider('github')->withUserData(function ($user) {
    return [
        'name' => $user->getName(),
        'created_at' => now()->format('Y-m-d'),
    ];
});
```

### Customize entire user creation

If you want more control over the actual user object being created, you can return a user from the provider's `withUser` callback. The closure will be given an instance of `Laravel\Socialite\Contracts\User`.

``` php
use Statamic\Facades\User;
use Statamic\Facades\OAuth;

OAuth::provider('github')->withUser(function ($user) {
    return User::make()
        ->email($user->getEmail())
        ->set('name', $user->getName());
});
```

[socialite-providers]: https://socialiteproviders.netlify.com/

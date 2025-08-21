---
title: Configuration
intro: Statamic uses standard Laravel config files and environment variables for application-level settings.
template: page
blueprint: page
id: 10d236ff-a80b-4d88-afa8-fe882b0f37a2
---
## Config files

Statamic's config files are located in `config/statamic/`. They are PHP files named by area of responsibility.

``` files theme:serendipity-light
config/statamic/
    antlers.php
    api.php
    assets.php
    autosave.php
    cp.php
    editions.php
    forms.php
    git.php
    graphql.php
    live_preview.php
    markdown.php
    oauth.php
    protect.php
    revisions.php
    routes.php
    search.php
    stache.php
    static_caching.php
    system.php
    users.php
```

## Environment variables

It is often helpful to have different configuration settings based on the environment where the site is running. For example, you may wish to enable debug mode on your local server but not your production server

:::warning
**Never enable Debug Mode or DebugBar on production.** The error messages — as beautiful as they are — will reveal much about the way your site is configured, where important files are, and possibly even leak data from your `.env` file depending on how you use those variables.
:::

In a fresh Statamic installation you'll find an `.env.example` file in the root directory of your site. Rename or copy it to `.env` to enable it. If you install Statamic via Composer or the [CLI tool](https://github.com/statamic/cli), this will be done automatically for you.

### Environment variable types

Variables in your `.env` files are parsed as strings. In order to handle a wider range of types, some specific values are reserved.

| `.env` &nbsp; Value | Parsed Value |
|--------------|--------------|
| `true` | `(bool) true` |
| `(true)` | `(bool) true` |
| `false` | `(bool) false` |
| `(false)` | `(bool) false` |
| `empty` | `(string) ''` |
| `(empty)` | `(string) ''` |
| `null` | `(null) null` |
| `(null)` | `(null) null` |

If you need to define an environment variable with a value containing a space, you may do so by enclosing the value in double quotes.

``` env
APP_NAME="Gluten Free Potato Canons"
```

### Retrieving environment variables

All environment variables are available in your config files by using the `env()` helper function. An optional second argument allows you to pass a default value.

``` php
// config/app.php
'awesome' => env('ENABLE_AWESOME', true),
```

::tabs

::tab antlers

Once passed into a config file, the variable can be used in your views with the `{{ config }}` tag.

``` antlers
// To retrieve the above 'awesome' value...
{{ config:app:awesome }}
```

::tab blade

Once passed into a config file, the variable can be used in your views with the `config()` helper function.

```blade
// To retrieve the above 'awesome' value...
{{ config('app.awesome') }}
```
::

:::warning
**Your `.env` file should never be committed to version control**.

Each developer or server running your application may require a different configuration, not to mention it can be a security risk in the event your version control repository is ever made public. Any sensitive credentials — like API keys and secret tokens — would be visible.
:::

### Hiding environment variables from debug pages

When an exception is uncaught and the `APP_DEBUG` environment variable is `true`, the debug page will show all environment variables and their contents. You may obscure variables by updating the `debug_blacklist` option in your `config/app.php` config file.

``` php
return [

    // ...

    'debug_blacklist' => [
        '_ENV' => [
            'APP_KEY',
            'MAILCHIMP_API_KEY',
            'BITCOIN_WALLET_PW',
        ],

        '_SERVER' => [
            'APP_KEY',
            'DB_PASSWORD',
        ],

        '_POST' => [
            'password',
        ],
    ],
];
```


Learn more about [environment configuration](https://laravel.com/docs/configuration#environment-configuration) in the Laravel docs.

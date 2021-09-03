---
title: Configuration
intro: Statamic uses standard Laravel config files and environment variables for application-level settings.
template: page
blueprint: page
stage: 4
id: 10d236ff-a80b-4d88-afa8-fe882b0f37a2
---
## Config Files

Statamic's config files are located in `config/statamic/`. They are PHP files named by area of responsibility.

``` files
├── config/statamic/
│   ├── amp.php
│   ├── api.php
│   ├── assets.php
│   ├── cp.php
│   ├── forms.php
│   ├── live_preview.php
│   ├── oauth.php
│   ├── protect.php
│   ├── revisions.php
│   ├── routes.php
│   ├── search.php
│   ├── sites.php
│   ├── stache.php
│   ├── static_caching.php
│   ├── system.php
│   ├── theming.php
│   └── users.php
```

## Environment Variables

It is often helpful to have different configuration setting based on the environment where the site is running. For example, you may wish to enable debug mode on your local server but not your production server (**hint: you should do this**).

In a fresh Statamic installation you'll find an `.env.example` file in the root directory of your site. Rename or copy it to `.env` to enable it. If you install Statamic via Composer, this file will be renamed automatically.

### Environment Variable Types

Variables in your `.env` files are parsed as strings. In order to handle a wider range of types, some specific values are reserved.

| `.env` Value | Parsed Value |
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
APP_NAME="Gluten Free Surgical Masks For Llamas"
```

### Retrieving Environment Variables

All of the variables listed in this file are available in your config files by using the `env()` helper function. An optional second argument allows you to pass a default value.

``` php
// config/app.php
'awesome' => env('ENABLE_AWESOME', true),
```

Once passed into a config file, the variable can be used in your views with the `{{ config }}` tag.

``` antlers
// To retrieve the above 'awesome' value...
{{ config:app:awesome }}
```

### Don't version your `.env` file

Your `.env` file **should not be committed to version control** because each developer or server running your application may require a different environment configuration. Not only that, but it could be a security risk in the event an intruder gains access to your version control repository because any sensitive credentials (API keys, for example) would be visible.

### Hiding Environment Variables from Debug Pages

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

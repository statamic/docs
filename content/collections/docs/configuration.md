---
title: Configuration
intro: Statamic utilizes standard Laravel config files and `.env` variables for most application-level configuration settings.
template: page
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1568748076
blueprint: page
stage: 2
id: 10d236ff-a80b-4d88-afa8-fe882b0f37a2
---
## Config Files

Statamic's main config files can be found in `config/statamic/`. They are primarily PHP files, organized by area of responsibility.

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

It is often helpful to have different configuration values based on the environment where the site is running. For example, you may wish to enable debug mode on your local server but not your production server (a good idea indeed).

In a fresh Statamic installation you'll find an `.env.example` file in the root directory of your site. If you install Statamic via Composer, this file will automatically be renamed to .env. Otherwise, you should rename the file manually.

### Environment Variable Types

All variables in your `.env` files are parsed as strings, so some reserved values have been created to allow you to return a wider range of types from the `env()` function:

| `.env` Value | `env()` Value |
|--------------|--------------|
| `true` | `(bool) true` |
| `(true)` | `(bool) true` |
| `false` | `(bool) false` |
| `(false)` | `(bool) false` |
| `empty` | `(string) ''` |
| `(empty)` | `(string) ''` |
| `null` | `(null) null` |
| `(null)` | `(null) null` |

If you need to define an environment variable with a value that contains space, you may do so by enclosing the value in double quotes.

``` env
APP_NAME="New Statamic Site"
```

### Retrieving Environment Variables

All of the variables listed in this file are available in your config files by using the `env()` helper. The optional second argument lets pass a default value in case you don't have the environment variable set.

``` php
'awesome' => env('ENABLE_AWESOME', true),
```

### Don't version your `.env` file

Your `.env` file **should not be committed to version control** because each developer or server running your application may require a different environment configuration. Not only that, but it could be security risk in the event an intruder gains access to your version control repository, since any sensitive credentials would get exposed.

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


Learn more about [environment configuration](https://laravel.com/docs/6.x/configuration#environment-configuration) in the Laravel docs.

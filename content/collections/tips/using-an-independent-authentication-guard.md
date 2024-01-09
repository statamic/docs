---
id: d42da120-03f9-4eaf-bdfe-420736ca55e7
title: 'Using an Independent Authentication Guard'
template: page
categories:
  - development
  - laravel
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1622821437
---
By default, Statamic comes configured to use the default auth guard. This means that your application's users will also be considered Statamic users.

If your application's users won't be interacting with Statamic and only a few users will actually be using the Control Panel, it might make sense for you to store your application's users in a database and your Statamic users in YAML files.

To separate Statamic's users from those of your Laravel application, you'll need to setup two user guards & two user providers in your `config/auth.php` config file.

You'll need one user guard & user provider for your Eloquent users and another for your Statamic users:

```php
// config/auth.php

'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],

    'statamic' => [
        'driver' => 'session',
        'provider' => 'statamic',
    ]
],

'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => \App\User::class,
    ],

    'statamic' => [
        'driver' => 'statamic',
    ],
],
```

In the above example, the  `statamic`  guard is used to authenticate users using Statamic's flat-file driver and the `web` guard is used to authenticate users using Laravel's built-in Eloquent driver.

While you're in the `config/auth.php` file, ensure you have separate reset & activation brokers for each of the providers (two for the Statamic driver & two for the Eloquent driver):

```php
'passwords' => [
	'resets' => [
		'provider' => 'users',
		'table' => 'password_reset_tokens',
		'expire' => 60,
		'throttle' => 60,
	],

	'activations' => [
		'provider' => 'users',
		'table' => 'password_activation_tokens',
		'expire' => 4320,
		'throttle' => 60,
	],

	'statamic_resets' => [
		'provider' => 'statamic',
		'table' => 'password_resets',
		'expire' => 60,
		'throttle' => 60,
	],

	'statamic_activations' => [
		'provider' => 'statamic',
		'table' => 'password_activations',
		'expire' => 4320,
		'throttle' => 60,
	],
],
```

Next, in Statamic's `users.php` configuration file, you'll want to configure which user guard should be used on the frontend and which should be used for the Control Panel:

In the example below, we're using the `statamic` driver for Control Panel users and the `web` driver for frontend users.

```php
// config/statamic/users.php

'guards' => [
    'cp' => 'statamic',
    'web' => 'web',
],
```

You should also ensure the `passwords` is setup to point to the correct reset & activation configs:

```php
'passwords' => [
	'resets' => 'statamic_resets',
	'activations' => 'statamic_activations',
],
```

## Non-Statamic routes

It's worth noting that any non-Statamic routes (eg. any you've manually added in your `routes/web.php` file) will be unaffected by the config changes

These routes will use whichever guard you have set to as the "default" in your `config/auth.php` file:

```php
'defaults' => [
  'guard' => 'web',
  'passwords' => 'users',
],
```

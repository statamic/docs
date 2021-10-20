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
By default, Statamic comes configured to use the default auth guard.

This means that any users will be considered Statamic's users.

An example wanting to change this could be if your application's users would not be interacting with Statamic, and only one or a few users would be using the Control Panel. It would be possible to keep your Statamic users in yaml files, and your app's users in a database.

If you'd like Statamic to use its own guards, you can configure it that way in your config files.

```php
// config/statamic/users.php

'guards' => [
    'cp' => 'statamic', // the guard when using the cp
    'web' => 'statamic', // the guard when using Statamic frontend routes
],
```

Any non-Statamic routes (e.g. any routes you've manually added to routes/web.php) will be unaffected by the above config. They'll be using whatever your "default" guard is.

```php
// config/auth.php

'defaults' => [
  'guard' => 'web',
  'passwords' => 'users',
],

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
In this example we'll use the custom `statamic` auth guard to authenticate users using the statamic driver. Following the steps in [Storing Laravel Users in Files](https://statamic.dev/tips/storing-laravel-users-in-files) we can have some users stored in the database and Statamic users stored in files.

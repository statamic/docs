---
id: 4f480db2-f80b-4b97-905c-b946f94c544d
title: 'Excluding the Control Panel from Maintenance Mode'
intro: '[Laravel''s maintenance mode](https://laravel.com/docs/configuration#maintenance-mode) is a great way to notify visitors that your site is down but will be back up shortly. But what if you still want to get into the control panel? Here''s how.'
template: page
stage: 4
categories:
  - development
  - cli
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1622821104
---
## Overview

When your site is in Laravel's [maintenance mode](https://laravel.com/docs/configuration#maintenance-mode), a custom view will be displayed for all requests into your site. This makes it easy to "disable" your site while it is updating or when you are performing maintenance. The logic for this mode is handled in the default middleware.

To enable maintenance mode, run the `down` Artisan command:

``` shell
php artisan down
```

And to disable maintenance mode, run the reverse `up` Artisan command:

``` shell
php artisan up
```

## Excluding URLs

It's possible to specify URLs which should remain "up" while your application is in maintenance mode. The steps for doing so differs depending on the version of Laravel you're using...

### Laravel 10

You can define exclusions in your `app/Http/Middleware/PreventRequestsDuringMaintenance.php` file:

```php
protected $except = [
    '/cp*'
];
```

In this example, the Control Panel will be available while the rest of your application is "down".


### Laravel 11

You can define exclusions in your app's `bootstrap/app.php` file:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->preventRequestsDuringMaintenance(except: [
        '/cp*'
    ]);
})
```

In this example, the Control Panel will be available while the rest of your application is "down".

---
id: 9af8c58e-7a9f-4f9c-89cd-97dfb3de33e6
title: 'Using Statamic Alongside Laravel Nova'
intro: 'Nova is an admin panel designed to manage your Eloquent models and other things. It can work hand in hand with Statamic.'
template: page
categories:
  - development
  - laravel
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1622821126
---
We've heard users saying they'd like to manage the front-end with Statamic and the back-end with [Laravel Nova](https://nova.laravel.com/). That's fine! It's possible to run both Statamic and Nova together.

:::tip
If you'd like to manage Eloquent models within Statamic, [you're able to do that, too](/extending/publish-forms).
:::

1. Install Nova as per their documentation
2. Disable Statamic's front-end routing. It conflicts with Nova.
   ```php
   // config/statamic/routes.php
   'enabled' => false,
   ```
3. Add Statamic's routes that you just disabled, to your own routes file.
   ```php
   // routes/web.php
   Statamic::additionalWebRoutes();
   Route::any('/{segments?}', '\Statamic\Http\Controllers\FrontendController@index')
      ->where('segments', '(?!nova|cp).*')
      ->name('statamic.site');
   ```
4. Create a [dedicated auth guard](/knowledge-base/using-an-independent-authentication-guard) and provider for Statamic.
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
        ],
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
5. Configure Statamic to use that guard.
   ```php
   // config/statamic/users.php
   'guards' => [
        'cp' => 'statamic',
        'web' => 'statamic',
   ],
   ```

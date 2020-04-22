---
title: Lifecycle
stage: 1
id: fd34ca35-57d1-4d28-97f9-ba6801656b39
---

## Laravel boots

Request comes in to the server, and is handled by Laravel.

Laravel will spin through all service provider classes and run each one's `register` method. You should put any container bindings in here.

``` php
public function register()
{
    $this->app->bind(SomeInterface::class, function () {
        return new SomeClass;
    })
}
```

It'll then loop through them again, this time calling the `boot` method. Here's where you can run any bootstrapping logic.

``` php
public function boot()
{
    //
}
```

## Auth service provider boots

As part of the boot process, Statamic will set up its permissions. If you'd like to do anything permission or auth
related, (like adding custom [permissions](/extending/permissions)) you should wrap your provider code in a booted
callback to ensure it happens _after_ Statamic has done its thing.

``` php
public function boot()
{
    $this->app->booted(function () {
        Permission::register(...);
    });
}
```

## View loads

If you're using any JavaScript in the Control Panel, you can pass configuration variables to it.
You can do this in a service provider or a view composer.

``` php
View::composer('statamic::layout', function ($view) {
    Statamic::provideToScript(['foo' => 'bar']);
});
```

``` js
Statamic.$config.get('foo'); // 'bar'
```

## Vue boots

If you've ever built a Vue application, you'll know that any global components need to be registered _before_ the root Vue instance is created. Statamic provides a `booting` callback for that.

``` js
Statamic.booting(() => {
    Statamic.$components.register(...);
})
```

Then, the Vue app will boot and you'll have a chance to do other JavaScript work within a `booted` callback. This is almost equivalent to putting things in a `created` hook of a Vue component.

This is where you'd do things like adding [Bard extensions](/extending/bard) and wiring up [Hooks](/extending/hooks) or [events](/extending/js-events).

``` js
Statamic.booted(() => {
    Statamic.$bard.extend(...);
    Statamic.$hooks.on(...);
});
```

> The Vue part of the lifecycle only applies to Control Panel requests. Since you have 100% control over the front-end of your site, you can do whatever you want.

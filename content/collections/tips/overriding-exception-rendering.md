---
id: 839eac3b-c4d9-4686-9e7e-f90c4515d405
title: 'Overriding Exception Rendering'
intro: 'Statamic''s HTTP exceptions (404, 403, 401) implement their own `render` method, which means Laravel''s usual `bootstrap/app.php` render callbacks never fire. Each exception exposes a `renderUsing` method so you can provide your own callback instead.'
template: page
categories:
  - development
  - laravel
---
## The Problem

If you try to customize how a `NotFoundHttpException` is rendered using Laravel's [standard approach](https://laravel.com/docs/errors#rendering-exceptions)...

```php
->withExceptions(function (Exceptions $exceptions) {
    $exceptions->render(function (NotFoundHttpException $e, Request $request) {
        return response()->redirectTo('/somewhere');
    });
})
```

...nothing happens. That's because Statamic swaps Symfony's exception for its own subclass that implements a `render` method directly on the exception, which Laravel calls before your callback ever gets a chance.

## The Solution

The following Statamic exceptions expose a static `renderUsing` method you can use to register a callback:

- `Statamic\Exceptions\NotFoundHttpException` (404)
- `Statamic\Exceptions\ForbiddenHttpException` (403)
- `Statamic\Exceptions\UnauthorizedHttpException` (401)

Register your callback from a service provider's `boot` method – `AppServiceProvider` is a fine place.

```php
// app/Providers/AppServiceProvider.php

use Illuminate\Http\Request;
use Statamic\Exceptions\NotFoundHttpException;
use Statamic\Facades\Collection;
use Statamic\Statamic;
use Illuminate\Support\Str;

public function boot()
{
    NotFoundHttpException::renderUsing(function (Request $request) {
        if (Statamic::isCpRoute() || Statamic::isApiRoute() || $this->getStatusCode() !== 404) {
            return;
        }

        $eventsMount = Collection::findByHandle('events')->mount();

        if (Str::before($request->path(), '/') === $eventsMount->slug()) {
            return response()->redirectTo($eventsMount->url());
        }
    });
}
```

A few things to know about the callback:

- `$this` is bound to the exception instance, so you can call things like `$this->getStatusCode()` or `$this->getMessage()`.
- Return a response to take over rendering entirely. Return nothing (or `null`) to fall through to Statamic's default behavior.
- Your callback runs **before** the CP and API checks, so if you don't want to hijack those requests you need to bail out yourself using `Statamic::isCpRoute()` and `Statamic::isApiRoute()`.

## When You'd Want This

- Redirecting legacy URLs to a new collection mount.
- Falling back to a search page when a page isn't found.
- Returning a custom 403 view for forbidden routes without touching the standard `errors/403.antlers.html` template.
- Logging 404s to an external service before rendering the default view.

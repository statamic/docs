---
id: a3fab450-3ce1-451c-b51d-cfc79bafd317
blueprint: tips
title: 'Content Security Policy'
template: page
intro: Content Security Policy (CSP) is an added layer of security that helps to detect and mitigate certain types of attacks, including Cross-Site Scripting (XSS) and data injection attacks. These attacks are used for everything from data theft, to site defacement, to malware distribution.
---

## What is a Content Security Policy (CSP)?

That intro is straight out of the [MDN documentation][mdn]. If you don't know about CSP, that's a great resource to check out!

In a nutshell, it prevents against malicious JavaScript. On a content managed website, especially on one where you may accept input from untrusted users, you may want to consider implementing a CSP to prevent unwanted JavaScript being executed.

## How to use it in Statamic

Statamic doesn't come with any CSP out of the box, but since it's a Laravel application, it's quite simple to add your own.

The simplest way to do this is to add a `meta` tag to your `head`.

```html
<meta http-equiv="Content-Security-Policy" content="..." />
```

(Replace the `...` with the appropriate value - more on that [below](#what-values-to-use))

You may also opt to use a middleware to add a header. If you do this, you'll want to prevent applying it to Control Panel routes, since Statamic needs to be able to run inline JavaScript. You can add it to the `web` middleware group, which your front-end will use but the Control Panel won't.

```php
// app/Http/Kernel.php [tl! focus]

protected $middlewareGroups = [ // [tl! focus]
    'web' => [ // [tl! focus]
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \App\Http\Middleware\ContentSecurityPolicy::class, // [tl! ++ focus]
    ], // [tl! focus]
]; // [tl! focus]
```
```php
<?php // app/Http/Middleware/ContentSecurityPolicy.php

namespace App\Http\Middleware;

class ContentSecurityPolicy
{
    public function handle($request, Closure $next)
    {
        return $next($request)
            ->header('Content-Security-Policy', "...");
    }
}
```

You may even use a package such as [Laravel CSP by Spatie](https://github.com/spatie/laravel-csp).

## An example of what it protects against

We all know that you shouldn't trust user input. That's why we say that you should use the [sanitize modifier](/modifiers/sanitize) whenever outputting something from the user.

Sanitizing works well to protect you from user's popping `<script>` tags and other HTML in blocks of text. But let's take a look at a situation where you are populating a link with a user-provided URL:

```yaml
my_link: http://example.com
```
```html
<a href="{{ my_link | sanitize }}">My Link</a>
```

This is fine if they provide a real URL, but what about something sneakier:

```yaml
my_link: 'javascript:sneakyStuff()'
```

Now they've put JavaScript into your template. Even if you sanitize the `my_link` variable, it won't matter since there's no HTML to escape. That's where CSP comes in handy.

If you click that link without a CSP, it will run `sneakyStuff()`. Oh no!

If you have it enabled, you'll get an error message like `Refused to run the JavaScript URL because it violates the following Content Security Policy`. You've just protected yourself.


## What values to use

In the examples above, you'll see `...` as a placeholder value, and you'll want to use the appropriate policy for your use case. You can find out exactly what works for you by consulting the [MDN documentation][mdn].

But, you can start with these:

- Only allow `<script src="">` tags with URLs on your own site:
  ```
  script-src 'self'
  ```
- Only allow `<script src="">` tags with URLs from your own site, or from `unpkg.com`:
  ```
  script-src 'self' unpkg.com
  ```
- Only allow `<script src="">` tags with URLs from your own site, or from `unpkg.com`, and `unsafe-eval` [which is required for Alpine.js to work](https://alpinejs.dev/advanced/csp).
  ```
  script-src 'self' unpkg.com 'unsafe-eval'
  ```



[mdn]: https://developer.mozilla.org/en-US/docs/Web/HTTP/CSP

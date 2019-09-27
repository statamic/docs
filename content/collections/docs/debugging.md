---
title: Debugging
intro: Debugging is the secret art of the experienced developer. The ability to pop the hood, inspect stack traces, or paw through response objects is important for getting yourself unstuck and on track quickly. Here are some tools Statamic provides to make your job easier.
template: page
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1568645126
id: 7fb5f2df-de3e-480f-a613-f38a9109e8d8
blueprint: page
stage: Major Editing
---
## Ignition Debug Screens

[Ignition][ignition] is an elegant Laravel package for debugging exceptions. It provides you with a clean and well organized stack trace, code snippets, information about the request, and more.

To enable Ignition you need only set `APP_DEBUG=true` in your [.env](/env) file.

<figure>
    <img src="/img/ignition-collection.png" alt="Ignition error screen showing a typo in a collection tag.">
    <figcaption>This is Ignition. Isn't it pretty for an error screen?</figcaption>
</figure>

Statamic will try to detect exactly why you're receiving an exception and provide a **solution** for the problem, often times along with a link to the most relevant documentation. How's that for service?

## Debug Bar

The debug bar is a convenient way to explore many of the things that are happening in any given page request. You can see data Statamic is fetching, which views are being rendered, information on the current route, available variables, user's session, request data, and more.

<figure>
    <img src="/img/debug-bar.png" alt="Debug bar showing available variables">
    <figcaption>The debug bar is like X-Ray vision into Statamic's inner workings.</figcaption>
</figure>

### Exploring variables

Any variables that are defined in a [blueprint](/blueprints) will be shown as a `Value` object in the Variables tab. They can be expanded to see their "raw" original data, as well what fieldtype they're managed by, and their augmented value.

- Learn more about [augmentation](/fields#augmentation).

### How to enable the debug bar

You need to require the package with [Composer][composer].

``` bash
composer require dev barryvdh/laravel-debugbar
```

It'll be enabled when `APP_DEBUG` is `true` in your env file.

> The debug bar injects javascript into the page and adds significant overhead to each request. Make sure to turn it off when you're testing your site's performance!

## Dump Modifier

When working in [Antlers](/antlers) templates, you can smack the [dump modifier](/modifiers/dump) onto any variable to explore its contents. Here's an example.

``` yaml
bands:
  good:
    - Goo Goo Dolls
    - Oasis
    - Third Eye Blind
  bad:
    - Creed
    - Hanson
    - The Offspring
```

```
{{ bands | dump }}
```

``` php
// Dumped output
array:6 [▼
  "good" => array:3 [▶],
  "bad" => array:3 [▶]
]
```

## Laravel Telescope

Statamic supports [Laravel Telescope][telescope], an elegant debug assistant for the Laravel framework. It's most useful when you're building addons or doing custom Laravel things outside the normal Statamic site scope.

Follow along with Laravel's documentation and you'll be up and running in no time.

<figure>
    <img src="/img/laravel-telescope.png" alt="Laravel Telescope showing nothing particularly interesting">
    <figcaption>Laravel Telescope in action. Barely.</figcaption>
</figure>

[composer]: https://getcomposer.org/
[ignition]: https://flareapp.io/docs/ignition-for-laravel/introduction
[telescope]: https://laravel.com/docs/6.x/telescope

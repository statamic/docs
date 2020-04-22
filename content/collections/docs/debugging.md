---
title: Debugging
intro: Debugging is the secret art of the experienced developer. The ability to inspect stack traces, rifle through response objects, and dump data to the screen is often the quickest way to get yourself unstuck and back on track. Here are some weapons Statamic provides to make your job easier.
template: page
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1568645126
id: 7fb5f2df-de3e-480f-a613-f38a9109e8d8
blueprint: page
stage: 2
---
## Ignition Debug Screens

[Ignition][ignition] is an included Laravel package for debugging exceptions. It provides a clean and organized stack trace, code snippets, information about the request, and even the ability the share the error message others.

To enable Ignition, set `APP_DEBUG=true` in your [.env](/configuration#environment-variables) file.

<figure>
    <img src="/img/ignition-collection.png" alt="Ignition error screen showing a typo in a collection tag.">
    <figcaption>This is Ignition. Isn't it pretty for an error screen?</figcaption>
</figure>

Statamic will try to detect why you're receiving a specific exception and provide a **solution** for the problem along with a link to the most relevant documentation if possible. It's like <a href="" x-on:click.prevent="showEasterEgg = true">Clippy</a>, but 80% less annoying.

<img src="/img/clippy-docs.gif" class="fixed z-10 cursor-pointer bottom-0 right-0 m-8" x-show.transition="showEasterEgg" x-on:click="showEasterEgg = false">

## Debug Bar

The debug bar is a convenient way to explore many of the things happening in any given page request. You can see data Statamic is fetching, which views are being rendered, information on the current route, available variables, user's session, request data, and more.

<figure>
    <img src="/img/debug-bar.png" alt="Debug bar showing available variables">
    <figcaption>The debug bar is like X-Ray vision into Statamic's inner workings.</figcaption>
</figure>

### Exploring variables

Any variables defined in a [blueprint](/blueprints) will be shown as a `Value` object in the Variables tab. They can be expanded to see their "raw" original data, as well what fieldtype they're managed by, and their augmented value.

- Learn more about [augmentation](/fields#augmentation).

### How to enable the debug bar

You need to require the package with [Composer][composer].

``` bash
composer require --dev barryvdh/laravel-debugbar
```

It'll be enabled when `APP_DEBUG` and `DEBUGBAR_ENABLED` are both `true` in your env file.

> The debug bar injects javascript into the page and adds significant overhead to each request. **Make sure to turn it off when you're testing your site's performance!**

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

## Logs

Statamic uses Laravel's logging handling system to log messages and errors to file, debug service, or even Slack. The default behavior logs these messages to files stored in `storage/logs`. Each day gets its own separate file so it can feel special.

Learn more about [configuring other logging channels](https://laravel.com/docs/logging#configuration) on the Laravel docs.

## Laravel Telescope

Statamic supports [Laravel Telescope][telescope], an elegant debug assistant for the Laravel framework. It's most useful when you're building addons or doing custom Laravel things outside the normal Statamic site scope.

Follow along with Laravel's documentation and you'll (probably) be up and running in no time.

<figure>
    <img src="/img/laravel-telescope.png" alt="Laravel Telescope showing nothing particularly interesting">
    <figcaption>Laravel Telescope in action. But just barely.</figcaption>
</figure>

[composer]: https://getcomposer.org/
[ignition]: https://flareapp.io/docs/ignition-for-laravel/introduction
[telescope]: https://laravel.com/docs/6.x/telescope

---
title: Mix
description: Returns the path to a versioned Mix file
intro: The Mix tag is used in tandem with Laravel Mix to return the path to versioned CSS and JavaScript files.
parameters:
  -
    name: src
    type: string
    description: >
        The path to the versioned file, relative to your `public/` directory.
  -
    name: in
    type: string
    description: The location of your mix manifest file relative to the `public/` directory.
id: b8936f37-a237-4fad-bf70-a6421ab413ae
---
## Overview

:::tip
Laravel Mix is a **legacy** build tool — new Statamic projects use [Vite](https://laravel.com/docs/vite) and the [vite tag](/tags/vite) instead. This tag is here for older sites that still compile their assets with Mix.
:::

[Laravel Mix][mix] is a Webpack API wrapper for compiling and building CSS and JavaScript files. The mix tag returns the path to a versioned [Mix][mix] file. Don't worry, if you're not using versioning it will return the path to the _non_-versioned file.

::tabs

::tab antlers
```antlers
// CSS
<link href="{{ mix src='/css/tailwind.css' }}" rel="stylesheet">

// JavaScript
<script src="{{ mix src='/js/app.js' }}"></script>
```
::tab blade
```blade
// CSS
<link href="{{ Statamic::tag('mix')->src('/css/tailwind.css') }}" rel="stylesheet">

// JavaScript
<script src="{{ Statamic::tag('mix')->src('/js/app.js') }}"></script>
```
::

## Default Directory

By default Mix will assume that the `mix-manifest.json` file that points to the proper file locations is in your `public/` directory. If your file is configured to build elsewhere you can point to it with the `in` parameter.

::tabs

::tab antlers
```antlers
<link href="{{ mix src='/css/tailwind.css' in='assets' }}" rel="stylesheet">
```
::tab blade
```blade
<link href="{{ Statamic::tag('mix')->src('/css/tailwind.css')->in('assets') }}" rel="stylesheet">
```
::

## Related Reading

- [Laravel Mix docs][mix]
- [The vite tag](/tags/vite) — the modern replacement
- [Webpack][webpack]

[mix]: https://laravel-mix.com
[webpack]: https://webpack.js.org/

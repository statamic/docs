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
stage: 4
id: b8936f37-a237-4fad-bf70-a6421ab413ae
---
## Overview
[Laravel Mix][mix] is an Webpack API wrapper for compiling and building CSS and JavaScript files. The mix tag returns the path to a versioned [Mix][mix] file. Don't worry, if you're not using versioning it will return the path to the _non_-versioned file.

[Webpack][webpack] and asset compilation can be a pretty complicated task and Laravel Mix does a really good job of simplifying it as far as it can possibly go.

```
// CSS
<link href="{{ mix src='/css/tailwind.css' }}" rel="stylesheet">

// JavaScript
<script src="{{ mix src='/js/app.js' }}"></script>
```

## Default Directory

By default Mix will assume that the `mix-manifest.json` file that points to the proper file locations is in your `public/` directory. If your file is configured to build elsewhere you can point to it with the `in` parameter.

```
<link href="{{ mix src='/css/tailwind.css' in='assets' }}" rel="stylesheet">
```

## Related Reading

- [Laravel Mix docs][mix]
- [Laravel Mix FAQs](https://laravel-mix.com/docs/4.0/faq)
- [Using TailwindCSS with Laravel Mix](https://tailwindcss.com/docs/installation/#laravel-mix)
- [Webpack][webpack]

[mix]: https://laravel.com/docs/mix
[webpack]: https://webpack.js.org/

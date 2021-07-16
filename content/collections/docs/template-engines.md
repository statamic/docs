---
title: 'Other Template Engines'
intro: Antlers is not always the best tool for the job. If you're using Statamic as a headless CMS or want to share views with a Laravel application, Blade or another engine might be a better fit.
blueprint: page
stage: 4
id: c7816387-ebc4-4204-b5f2-8e7073a4db8b
---
## Overview

While Statamic's [Antlers](/antlers) template language is powerful, tightly integrated, and simple to learn, it's not the only way to build your frontend.

You can use [Blade](https://laravel.com/docs/blade) or other template engines by using their respective file extensions.

Instead of naming your views `myview.antlers.html` use `.blade.php` extension (or whatever other engine's extensions you may have installed).


## View Data

You will have access to the same top level data as you would in Antlers views.

``` yaml
---
title: My First Breakdance Competition
moves:
  - Toprock
  - 6-step
  - Windmill
  - L-kick
  - Headspin
---
I did not win but I did have good timez.
```

``` blade
<h1>{{ $title }}</h1>

<p>First I did
@foreach ($moves as $move)
    {{ $move }}, then I did
@endforeach
and it was sick.</p>

{{ $content }}
```
> It is important to note that Antlers outputs unescaped values by default, while `{{ $content }}` in Blade will be escaped, if you need to output unescaped HTML then you may do so with `{!! $content !!}`

## Modifiers + Blade

You can use [Modifiers](/modifiers) in Blade templates with a Laravel-style fluent syntax.

Wrap your value with the `Statamic\Modifiers\Modify::value()` method and chain modifiers as you wish. The value will get passed along in sequence like it does in Antlers. Any parameters should be specified like regular PHP parameters.

``` blade
{{ Statamic\Modifiers\Modify::value($content)->striptags()->backspace(1)->ensureRight('!!!') }}
```

``` output
THIS IS THE FIRST POST, HOW EXCITING!!!
```

You can use [service injection](https://laravel.com/docs/blade#service-injection) to make your templates read a little nicer, and pass the value straight into
it, rather than using a `value` method.

``` blade
@inject('modify', 'Statamic\Modifiers\Modify')

{!! $modify($title)->wrap('h1') !!}
{{ $modify($content)->striptags()->backspace(1)->ensureRight('!!!') }}
```

You could also opt to create a global helper in your project.

```php
use Statamic\Modifiers\Modify;

function modify($value): Modify
{
    return Modify::value($value);
}
```

``` blade
{!! modify($title)->wrap('h1') !!}
{{ modify($content)->striptags()->backspace(1)->ensureRight('!!!') }}
```

> Note that when using multi-word modifiers, like `ensure_right`, you should use the camelCased version (`ensureRight`).


## Layouts

When Statamic attempts to render a URL (eg. an entry), two views are combined. A template gets injected into a layout's `template_content` variable.

When the _template_ is **not** an Antlers view, this rule doesn't apply. The layout is ignored, allowing you to use `@extends` the way you would expect.

``` blade
{{-- mytemplate.blade.php --}}

@extends('layout')

@section('body')
  The body content
@endsection
```

``` blade
{{-- mylayout.blade.php --}}

<html>
<body>
  @yield('body')
</body>
</html>
```

``` output
<html>
<body>
  The body content
</body>
</html>
```

This rule only applies to the _template_. You're free to use a `.antlers.html` template and a `.blade.php` layout.
If you want to do this, instead of a `yield`, the contents of the template will be available as in the `template_content` variable.

```
{{# mytemplate.antlers.html #}}

The template content
```

``` blade
{{-- mylayout.blade.php --}}

{!! $template_content !!}
```

``` output
<html>
<body>
The template contents
</body>
</html>
```

## Blade starting point

Statamic comes preloaded with:
* `layout.antlers.html`
* `home.antlers.html`
* `default.antlers.html`
* `errors/404.antlers.html`

If Blade happens to be your strawberry jam, then Blade versions of the listed Antlers files would look a little something like this.

`layout.blade.php`
``` blade
<!doctype html>
<html lang="{{ $site->shortLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? $site->name() }}</title>
        <link rel="stylesheet" href="{{ mix('css/tailwind.css') }}">
    </head>
    <body class="bg-gray-100 font-sans leading-normal text-grey-800">
        <div class="mx-auto px-2 h-screen flex items-center justify-center">
            @yield('template_content')
        </div>
        <script src="{{ mix('/js/site.js') }}"></script>
    </body>
</html>
```

`home.blade.php`
``` blade
@extends('layout')

@section('template_content')
    <div class="pb-16 text-center">
        <a href="https://statamic.com">
            <svg id="statamic-logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 272.1" width="400">
                <linearGradient id="a" gradientUnits="userSpaceOnUse" x1="99.153" y1="65.596" x2="150.124" y2="205.639">
                    <stop offset="0" stop-color="#da2fb6" />
                    <stop offset="1" stop-color="#fe1876" />
                </linearGradient>
                <path
                    d="M172.9 195.7c10.9 0 14.9-4.7 14.9-16.2v-22.4c0-10.7 5.2-16.8 10.2-19.7 1.5-.9 1.5-3 0-4-5.2-3.3-10.2-10.2-10.2-19.4V92c0-12.4-3.4-16-14.3-16H75.6c-10.9 0-14.3 3.6-14.3 16v22c0 9.2-5 16.1-10.2 19.4-1.5.9-1.5 3.1 0 4 5 2.8 10.2 8.9 10.2 19.7v22.4c0 11.5 4 16.2 14.9 16.2h96.7zm-48.6-20.5c-11.7 0-20.2-3.5-28.1-10.4-1.3-1.2-1.8-2.7-1.8-4.2 0-1.2.3-2.5 1.2-3.5L98 154c1.2-1.5 2.5-2.2 4-2.2 1.7 0 3.3.7 5 1.8 5.4 3.5 11.4 5.5 18.6 5.5 5.5 0 9.9-2.3 9.9-7 0-12.2-40.6-5.5-40.6-32.9 0-14.7 12-22.9 27.6-22.9 11 0 19.1 3.2 25.1 7 1.5 1 2.5 3 2.5 5 0 1.2-.3 2.3-1 3.3l-1.8 2.7c-1.3 1.8-2.8 2.7-4.7 2.7-1.3 0-2.7-.5-4.2-1.2-4.5-2.3-9.2-3.5-14.9-3.5-5.9 0-9.4 3.2-9.4 6.5 0 12.5 40.6 5.7 40.6 32.3 0 14.9-12 24.1-30.4 24.1z"
                    fill="url(#a)" />
                <path
                    d="M242.2 157.4c1-1.3 2.1-1.8 3.4-1.8s2.9.6 4.2 1.6c4.5 3 9.6 4.7 15.7 4.7 4.7 0 8.4-1.9 8.4-6 0-10.3-34.3-4.7-34.3-27.7 0-12.4 10.2-19.4 23.3-19.4 9.3 0 16.1 2.6 21.2 6 1.3.8 2.1 2.5 2.1 4.2 0 1-.2 1.9-.8 2.9l-1.6 2.3c-1.1 1.6-2.4 2.3-3.9 2.3-1.1 0-2.3-.5-3.6-1-3.8-1.9-7.8-3-12.5-3-4.9 0-7.9 2.6-7.9 5.5 0 10.5 34.3 4.8 34.3 27.2 0 12.5-10.2 20.3-25.7 20.3-9.9 0-17.1-3-23.7-8.7-1.1-1-1.6-2.3-1.6-3.6 0-1 .2-2.1 1-3l2-2.8zm98.2 6.6c.5.7.7 1.6.7 2.4 0 1.8-.8 3.7-2.4 4.5-4.8 2.9-9.6 4.2-15.9 4.2-14.3 0-19.7-9.3-19.7-25.6V97.9c0-2.9 2.4-5.3 5.3-5.3h5.7c2.9 0 5.3 2.4 5.3 5.3v12.4h15.3c2.9 0 5.3 2.4 5.3 5.3v4.8c0 2.9-2.4 5.3-5.3 5.3h-15.3v23.2c0 6.9 2.3 11.5 7.6 11.5 1.7 0 3.2-.2 4.5-.7 1.3-.5 2.3-.7 3.2-.7 1.8 0 3.2.8 4.4 2.9l1.3 2.1zm9.9-8.8c0-14 10.3-20.6 23.2-20.6 5.6 0 11.2 1.8 14.3 4.1v-1.9c0-9.3-3-14.3-11.8-14.3-4.8 0-7.9.7-10.9 1.7-.8.2-1.7.5-2.5.5-2.1 0-3.8-1-4.8-3l-.8-1.7c-.2-.7-.6-1.4-.6-2.3 0-1.8 1.3-3.7 3-4.5 5.5-2.5 11.8-4.2 18.3-4.2 18.8 0 25.3 9.6 25.3 26.4v33.4c0 2.9-2.4 5.3-5.3 5.3H394c-2.9 0-5.3-2.4-5.3-5.3v-2.1c-3.4 4.8-10.2 8.1-18.8 8.1-11.3-.1-19.6-7.3-19.6-19.6zm37.5-6.6c-2.9-2.1-6.5-3.1-11.1-3.1-5.4 0-10.2 2.5-10.2 7.9 0 4.8 3.9 7.5 9.1 7.5 6.8 0 10.3-3 12.3-5.7v-6.6zm67.8 15.4c.5.7.7 1.6.7 2.4 0 1.8-.8 3.7-2.4 4.5-4.8 2.9-9.6 4.2-15.9 4.2-14.3 0-19.7-9.3-19.7-25.6V97.9c0-2.9 2.4-5.3 5.3-5.3h5.7c2.9 0 5.3 2.4 5.3 5.3v12.4h15.3c2.9 0 5.3 2.4 5.3 5.3v4.8c0 2.9-2.4 5.3-5.3 5.3h-15.3v23.2c0 6.9 2.3 11.5 7.6 11.5 1.7 0 3.2-.2 4.5-.7 1.3-.5 2.3-.7 3.2-.7 1.8 0 3.2.8 4.4 2.9l1.3 2.1zm9.9-8.8c0-14 10.3-20.6 23.2-20.6 5.6 0 11.2 1.8 14.3 4.1v-1.9c0-9.3-3-14.3-11.8-14.3-4.8 0-7.9.7-10.9 1.7-.8.2-1.7.5-2.5.5-2.1 0-3.8-1-4.8-3l-.8-1.7c-.2-.7-.6-1.4-.6-2.3 0-1.8 1.3-3.7 3-4.5 5.5-2.5 11.8-4.2 18.3-4.2 18.8 0 25.3 9.6 25.3 26.4v33.4c0 2.9-2.4 5.3-5.3 5.3h-3.7c-2.9 0-5.3-2.4-5.3-5.3v-2.1c-3.4 4.8-10.2 8.1-18.8 8.1-11.2-.1-19.6-7.3-19.6-19.6zm37.5-6.6c-2.9-2.1-6.5-3.1-11.1-3.1-5.4 0-10.2 2.5-10.2 7.9 0 4.8 3.9 7.5 9.1 7.5 6.8 0 10.3-3 12.3-5.7v-6.6zm48.2-31.3c4.5-5 12-8.1 19.8-8.1 9.7 0 16.2 4.4 18.5 10.2 4.5-6 11.6-10.2 21.4-10.2 11.6 0 20.3 5.7 20.3 23.2v36.2c0 2.9-2.4 5.3-5.3 5.3h-5.7c-2.9 0-5.3-2.4-5.3-5.3v-32.1c0-7.9-3.2-12.2-10.9-12.2-6.1 0-10.9 3-13.1 7.3 0 1 .1 3.2.1 4.7v32.1c0 2.9-2.4 5.3-5.3 5.3H580c-2.9 0-5.3-2.4-5.3-5.3v-33c0-6.7-3.7-11-10.5-11-5.7 0-10.4 2.5-13.3 6.8v37.4c0 2.9-2.4 5.3-5.3 5.3h-5.7c-2.9 0-5.3-2.4-5.3-5.3v-53.1c0-2.9 2.4-5.3 5.3-5.3h5.7c2.9 0 5.3 2.4 5.3 5.3v1.8h.3zm116.7-29.9c0 6.5-4.7 10.2-9.3 10.2-5.5 0-10.2-3.7-10.2-10.2 0-5.7 4.7-9.4 10.2-9.4 4.6 0 9.3 3.7 9.3 9.4zm-6.8 22.9c2.9 0 5.3 2.4 5.3 5.3v53c0 2.9-2.4 5.3-5.3 5.3h-5.7c-2.9 0-5.3-2.4-5.3-5.3v-53.1c0-2.9 2.4-5.3 5.3-5.3h5.7v.1zm68 16.2c-3.8-1.8-7.1-2.5-11.2-2.5-9.1 0-17.7 6.9-17.7 18 0 11.2 8.7 18.2 18.3 18.2 5 0 8.6-1.3 12.3-3.7 1.1-.7 2.3-1.1 3.4-1.1 1.7 0 3.2.7 4.4 2.1l2.4 3c.7.7 1 1.8 1 2.9 0 1.7-.7 3.6-1.9 4.5-7.6 6.1-14.3 7.5-22.2 7.5-21 0-34.9-13.3-34.9-33.3 0-18.5 13.5-33.3 32.9-33.3 8.5 0 14.7 1.4 20.9 4.8 1.6.8 2.5 2.9 2.5 4.7 0 .8-.1 1.6-.6 2.3l-2.1 3.7c-1.1 1.8-2.9 3-4.8 3-.8-.2-1.8-.3-2.7-.8z"
                    fill="#ff269e" />
            </svg>
        </a>
        <div class="text-xs font-bold uppercase text-gray-500 space-x-3">
            <a class="hover:bg-gray-200 p-2 rounded" href="{{ $cp_url }}">Control Panel</a>
            <a class="hover:bg-gray-200 p-2 rounded" href="https://statamic.dev" target="_blank" rel="noopener noreferrer">Documentation</a>
            <a class="hover:bg-gray-200 p-2 rounded" href="https://statamic.com/support" rel="noopener noreferrer">Get Support</a>
        </div>
    </div>
@endsection
```

`default.blade.php`
``` blade
@extends('layout')

@section('template_content')
    {!! $content !!}
@endsection
```

`errors/404.blade.php`
``` blade
@extends('layout')

@section('template_content')
    <p>404 Page not found.</p>
@endsection
```

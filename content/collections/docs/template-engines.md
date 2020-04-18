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

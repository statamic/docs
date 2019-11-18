---
title: 'Other Template Engines'
template: page
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1568806150
blueprint: page
id: c7816387-ebc4-4204-b5f2-8e7073a4db8b
---
You can use Blade or any other template engines by using their respective file extensions.

Instead of naming your views `myview.antlers.html`, you can just use `.blade.php` extension (or whatever other engine's extensions you may have installed).

## Data

You will have access to the same top level data as you would in an Antlers file.

``` yaml
---
title: My First Post
favorite_things:
  - bacon
  - whisky
gamertags:
  swanson45: Ron Swanson
  npeppers: Niles Peppertrout
---
This is the first post, how exciting.
```

``` blade
@extends('site')

<h1>{{ $title }}</h1>

@foreach ($favorite_things as $thing)
    {{ $thing }}
@endforeach

@foreach ($gamertags as $tag => $name)
    {{ $name }} goes by {{ $tag }}
@endforeach

{{ $content }}
```

## Modifiers

You can use [Modifiers](/modifiers) in your Blade templates, but they will use a different syntax than what you’re used to with Antlers.

Wrap your value with the `Statamic\Modifiers\Modify::value()` method, then feel free to chain modifiers as you wish. The value will get passed along like normal. Any parameters should be specified like regular PHP parameters.
Blade

``` blade
{{ Statamic\Modifiers\Modify::value($content)->striptags()->backspace(1)->ensureRight('!!!') }}
```

``` output
THIS IS THE FIRST POST, HOW EXCITING!!!
```

You can use [service injection](https://laravel.com/docs/6.x/blade#service-injection) to make your templates read a little nicer, and pass the value straight into
it, rather than using a `value` method.

``` blade
@inject('modify', 'Statamic\Modifiers\Modify')

{!! $modify($title)->wrap('h1') !!}
{{ $modify($content)->striptags()->backspace(1)->ensureRight('!!!') }}
```

> Note that when using multi-word modifiers, like `ensure_right`, you should use the camelCased version (`ensureRight`).
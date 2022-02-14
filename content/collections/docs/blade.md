---
id: c7816387-ebc4-4204-b5f2-8e7073a4db8b
blueprint: page
title: 'Blade Templates'
intro: '[Antlers](/antlers) is not _always_ the best template engine for the job. If you''re using Statamic as a headless CMS or want to share views with a Laravel application already using [Blade](https://laravel.com/docs/blade) or another engine, you can do that. **Just know there are a few caveats before you do.**'
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1632748828
---
## Overview

While Statamic's [Antlers](/antlers) template language is powerful, tightly integrated, and simple to learn, it's not the only way to build your frontend.

Antlers handles the responsibilities of both Blade _and_ [Controllers](/controllers), all in your template. If you choose to **not** use Antlers, know that you'll have to do additional work in PHP somewhere to fetch and prep content another way.

You can use [Blade](https://laravel.com/docs/blade) or other template engines by using their respective file extensions.

## How to Render A Template with Blade

Instead of naming your views `myview.antlers.html` use `myview.blade.php` extension (or whatever other engine's extensions you may have installed).


## View Data

You will have access to the same data as you would in Antlers views.

### Current Page

The current page's data will be available in a `$page` variable, and you can access its values using a syntax similar to Eloquent models.

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
<h1>{{ $page->title }}</h1>

<p>First I did
@foreach ($page->moves as $move)
    {{ $move }}, then I did
@endforeach
and it was sick.</p>

{{ $page->content }}
```

:::tip
Antlers outputs **unescaped** values by default, while `{{ $content }}` in Blade will be escaped. If you need to output unescaped HTML, use `{!! $content !!}`
:::

### Globals

There will be a variable for each global set. You can access its fields using the same Eloquent model type syntax.

```yaml
# content/globals/settings.yaml
data:
  site_name: Rad City
```

```blade
{{ $settings->site_name }}
```

### System Variables

Top level [system variables](/variables#system-variables) like, `environment`, `logged_in`, etc will be available as dedicated variables.

```blade
{{ $environment }}
@if ($logged_in) ... @endif
```

### Relationships / Queries

Some fieldtypes (e.g. `entries`) will supply their data as query builders. These will work similar to Eloquent models, too.

If you use property access, it will resolve the query builder and get the items.

```blade
@foreach ($page->related_posts as $post)
  {{ $post->title }}
@endforeach
```

If you use a method, it will give you a query builder and allow you to chain clauses on it.

```blade
@foreach ($page->related_posts()->where('title', 'like', '%awesome%')->get() as $post)
  {{ $post->title }}
@endforeach
```


## Using Tags with Blade

You can use [Tags](/tags) in Blade templates with a Laravel-style fluent syntax. Instantiate your tag with the `Statamic::tag()` method and chain parameters as needed.

``` blade
@foreach(Statamic::tag('collection:pages')->limit(3) as $page)
    <li>{{ $page['title'] }}</li>
@endforeach
```

```
• Home
• Gallery
• Contact
```

:::tip
When using multi-word parameters, like `query_scope`, you must use the camelCased version (`queryScope`).
:::

### Passing Contextual Data

You can pass in contextual data to the tag using the `context($data)` method:

```blade
@foreach(Statamic::tag('collection:pages')->context($context) as $page)
	{{ $page['title'] }}<br>
@endforeach
```

### Disabling Augmentation

[Augmentation](/extending/augmentation) is enabled by default (as it is in antlers), but you can disable augmentation using the `withoutAugmentation()` method.

```blade
@foreach(Statamic::tag('collection:pages')->withoutAugmentation() as $page)
	{{ $page->title }}<br>
@endforeach
```


## Using Modifiers with Blade

You can also use [Modifiers](/modifiers) in Blade templates with a Laravel-style fluent syntax. Wrap your value with the `Statamic::modify()` method and chain modifiers as needed. The value will get passed along in sequence like it does in Antlers. Any parameters should be specified like regular PHP parameters.

``` blade
{{ Statamic::modify($content)->striptags()->backspace(1)->ensureRight('!!!') }}
```

```
THIS IS THE FIRST POST, HOW EXCITING!!!
```

:::tip
When using multi-word modifiers, like `ensure_right`, you must use the camelCased version (`ensureRight`).
:::


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

```html
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

```html
<html>
<body>
The template contents
</body>
</html>
```

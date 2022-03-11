---
id: c7816387-ebc4-4204-b5f2-8e7073a4db8b
blueprint: page
title: 'Blade Templates'
intro: '[Antlers](/antlers) is not _always_ the best template engine for the job. If you''re using Statamic as a headless CMS or want to share views with a Laravel application already using [Blade](https://laravel.com/docs/blade) or another engine, you can do that.'
---
## Overview

While Statamic's [Antlers](/antlers) template language is powerful, tightly integrated, and simple to learn, it's not the only way to build your frontend views.

Antlers combines the responsibilities of Blade Templates _and_ [Controllers](/controllers) all at once. If you choose to **not** use Antlers, you _may_ need to create controllers and routes to fetch content and map them to templates depending on what you're doing.

## How to Render a Template with Blade

Instead of naming your views `myview.antlers.html` use `myview.blade.php` extension.


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
I did not win but I did have a good time.
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

There is a variable for each global set, and its fields can be accessed using the same Eloquent style syntax.

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


## Using Tags with Blade 🆕

You can use [Tags](/tags) in Blade templates with a Laravel-style fluent syntax. Instantiate your tag with the `Statamic::tag()` method and chain parameters as needed.

``` blade
@foreach(Statamic::tag('collection:pages')->limit(3) as $page)
    <li>{{ $page->title }}</li>
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

### Using Explicit Parameter Setters

If you need to set a parameter containing a colon (ie. a [filter](/tags/collection#filtering) param), you can use the dedicated `param()` setter method:

```php
Statamic::tag('collection:pages')->param('title:contains', 'pizza')
```

Or even set multiple parameters at once using the plural `params()` method:

```php
Statamic::tag('collection:pages')->params([
    'title:contains' => 'pizza',
    'description:contains' => 'lasagna',
])
```

### Passing Contextual Data

You can pass in contextual data to the tag using the `context($data)` method:

```php
Statamic::tag('collection:pages')->context($context)
```

### Disabling Augmentation

[Augmentation](/extending/augmentation) is enabled by default (as it is in antlers), but you can disable augmentation using the `withoutAugmentation()` method.

```php
Statamic::tag('collection:pages')->withoutAugmentation()
```

### Fetching the output

When you loop over a tag or cast it to a string, it will automatically fetch the result for you. In some cases, you may want to explicitly fetch the output. You can do that with the `fetch` method.

```blade
@php($output = Statamic::tag('collection:pages')->fetch())
```

### Pagination

For tags that provide pagination, you can `fetch` the tag's output in a variable, then output the results and links separately:

```blade
@php($tag = Statamic::tag('collection:pages')->paginate(2)->as('pages')->fetch())

@foreach($tag->pages as $page)
    <li>{{ $page->title }}</li>
@endforeach

{{ $tag->paginate['auto_links'] }}
```


## Using Modifiers with Blade 🆕

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

This rule only applies to the _template_. You're free to use a `.antlers.html` template and a `.blade.php` layout. If you want to do this, the contents of the template will be available as in the `template_content` variable instead of `yield`.

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

## Routes and Controllers

If you choose to take a more "traditional" Laravel application approach to building your Statamic site, you can use routes and controllers much the same way you might with Eloquent models instead of Statamic's native collection routing and data cascade. Here's an example:

**The Routes**

```php
use App\Http\Controllers\BlogController;

Route::get('/blog', [BlogController::class, 'index']);
Route::get('/blog/{slug}', [BlogController::class, 'show']);
```

**The Controller**
```php
<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Statamic\Facades\Entry;

class BlogController extends Controller
{
    public function index()
    {
        $entries = Entry::query()
            ->where('collection', 'blog')
            ->take(10)
            ->get();

        return view('blog.index', ['entries' => $entries]);
    }

    public function show($slug)
    {
        $entry = Entry::query()
            ->where('collection', 'blog')
            ->where('slug', $slug)
            ->first();

        return view('blog.show', ['entry' => $entry]);
    }
}
```

**The Index View**
```blade
<h1>The Blog</h1>

<div class="grid md:grid-cols-3 gap-3">
    @foreach($entries as $entry)
    <a href="{!! $entry->url !!}" class="p-2 rounded shadow-sm">
        <img src="{!! $entry->featured_image !!}" class="w-full">
        <h2>{!! $entry->title !!}</h2>
        <div>{!! $entry->date->format('Y-m-d') !!}</div>
    </a>
    @endforeach
</div>
```

**The Show View**
```blade
<header>
    <h1>{!! $title !!}</h1>
    <div>{!! $entry->date->format('Y-m-d') !!}</div>
</header>
<div class="mt-8 prose">
    <img src="{!! $entry->featured_image !!}" class="w-full">
    {!! $entry->content !!}
</div>
```

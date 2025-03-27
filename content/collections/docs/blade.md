---
id: c7816387-ebc4-4204-b5f2-8e7073a4db8b
blueprint: page
title: 'Blade Templates'
intro: '[Antlers](/antlers) is not _always_ the best template engine for the job. If you''re using Statamic as a headless CMS or want to share views with a Laravel application already using [Blade](https://laravel.com/docs/blade) or another engine, you can do that.'
---
## Overview

While Statamic's [Antlers](/antlers) template language is powerful, tightly integrated, and simple to learn, it's not the only way to build your frontend views.

Antlers combines the responsibilities of Blade Templates _and_ [Controllers](/controllers) all at once. If you choose to **not** use Antlers, you _may_ need to create controllers and routes to fetch content and map them to templates depending on what you're doing. Want to write Antlers in your Blade templates? That's also possible by using the [@antlers](#writing-pure-antlers-in-blade) Blade directive.

## How to Render a Template with Blade

Instead of naming your views `myview.antlers.html`, use `myview.blade.php` extension.

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

:::tip
When on a custom route, the `$page` variable **won't** be available in your view. 
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

### Cascade Directive

When using blade components or rendering views loaded by non-Statamic routes/controllers, the cascade data will be not available by default. In these situations you can use the `@cascade` directive to populate the current scope with cascade data.

It works in exactly the same way as the `@props` directive used in blade components, with the ability to require certain values and provide default fallback values:

```blade
@cascade([
    'site', // Will throw an exception if missing from the cascade
    'my_global',
    'page' => null, // Will use fallback if missing from the cascade
    'live_preview' => false,
])

{{ $site->locale }}
{{ $page?->title }}
```

It is also possible to populate the current scope with all cascade data if needed:

```blade
@cascade
```

## Writing Pure Antlers in Blade 🆕

By using the `@antlers` and `@endantlers` Blade directive pair you can write pure Antlers in your Blade templates.

```antlers
@antlers
    {{ collection:articles }}
        {{ title }}
    {{ /collection:articles }}
@endantlers
```

Under the hood, this is syntactic sugar for creating an Antlers partial and does an on-the-fly `@include('antlers_file_name_here')` for you. This means that variables created _inside_ the Antlers will not be available _outside_ of the `@antlers` directive.

## Using Antlers Blade Components

Despite the name, Antlers Blade Components are a Blade-only feature that allows you to use existing tags inside your Blade templates using a custom tag syntax. For example, you can gather all entries from a "pages" collection using the [collection](/tags/collection) tag like so:

```blade
<s:collection:pages>
  {{ $title }}
</s:collection:pages>
```

In the previous example, you may have noticed the `s:` prefix. To use Antlers Blade Components we must prefix the tag name with either `s:` or `statamic:` (`s-` and `statamic-` also work).

We can pass multiple parameters to the tag like so:

```blade
<s:collection
  from="pages"
  limit="2"
  sort="title:desc"
>
  {{ $title }}
</s:collection>
```

We can also pass dynamic values to parameters:

```blade
@php
  $collection = 'pages';
@endphp

<s:collection
  :from="$collection"
  limit="2"
  sort="title:desc"
>
  {{ $title }}
</s:collection>
```

### Antlers Blade Components and Partials

Partials also work with Antlers Blade Components, and are intended to be used when you'd like to include an Antlers partial inside your Blade template:

```blade
<s:partial/the-partial-name>
  <s:slot:header>The header content.</s:slot:header>

  Default slot content.
</s:partial/the-partial-name>
```

:::tip
If you are going all-in on Blade for a new project, you should consider sticking to Blade features such as `@include` or Blade components instead of reaching for the `partial` tag.
:::

## Using Fluent Tags with Blade

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

### Fetching the output

When you loop over a tag or cast it to a string, it will automatically fetch the result for you. In some cases, you may want to explicitly fetch the output. You can do that with the `fetch` method.

```blade
@php($output = Statamic::tag('collection:pages')->fetch())
```

### Pagination

For tags that provide pagination, you can `fetch` the tag's output in a variable, then output the results and links separately:

```blade
@php($tag = Statamic::tag('collection:pages')->paginate(2)->as('pages')->fetch())

@foreach($tag['pages'] as $page)
    <li>{{ $page->title }}</li>
@endforeach

{{ $tag['paginate']['auto_links'] }}
```

### Directive {#tag-directive}

You may prefer to use an alternate syntax, available via a `@tags` Blade directive.

Passing a string will give you the camelCased version of the tag as a variable:

```blade
@tags('collection:blog')

@foreach($collectionBlog as $post) ... @endforeach
```

Passing an array of tags can provide multiple variables:

```blade
@tags(['collection:blog', 'collection:items'])

@foreach($collectionBlog as $post) ... @endforeach

@foreach($collectionItems as $item) ... @endforeach
```

You may also pass an array of tags, and parameters, with variable names as the keys:

```blade
@tags([
    'posts' => ['collection:blog' => ['limit' => 5]], 
    'items' => ['collection:items' => ['limit' => 5]],
])

@foreach($posts as $post) ... @endforeach

@foreach($items as $item) ... @endforeach
```

## Using Modifiers with Blade

You can also use [Modifiers](/modifiers) in Blade templates with a Laravel-style fluent syntax. Wrap your value with the `Statamic::modify()` method and chain modifiers as needed. The value will get passed along in sequence like it does in Antlers. Any parameters should be specified like regular PHP parameters. If you use a modifier that can take more than one parameter, pass those in as an array.

``` blade
{{ Statamic::modify($content)->striptags()->backspace(1)->ensureRight('!!!') }}
{{ Statamic::modify($content)->stripTags()->safeTruncate([42, '...']) }}
```

```
THIS IS THE FIRST POST, HOW EXCITING!!!
I wanted to say more but got cut off...
```

:::tip
When using multi-word modifiers, like `ensure_right`, you must use the camelCased version (`ensureRight`).
:::

If you're using a lot of modifiers in your Blade template, you can also include the `modify` helper function in your template:

```blade
@php
  use function Statamic\View\Blade\{modify};
@endphp

{{ modify('test')->stripTags()->backspace(1)->ensureRight('!!!') }}
{{ modify('test')->stripTags()->safeTruncate([42, '...']) }}
```

## Conditional Logic and Values

Depending on where you got a value from, it may be wrapped in a class like `Value`. These can lead to unexpected results in conditional logic if they are not handled correctly (i.e., calling `->value()` in the condition).

If you'd prefer to not think about that, you can include the `value` helper function into your template, which will take care of this for you:

```blade
@php
  use function Statamic\View\Blade\{value};
@endphp

@if (value($theVariableName))
  ...
@endif
```

The `value` helper function will handle the following scenarios for you:

* `Statamic\Fields\Value` objects (calls `->value()`)
* `Statamic\Fields\Values` objects (calls `->all()`)
* `Statamic\Tags\FluentTag` objects (calls `->fetch()`)
* `Statamic\Modifiers\Modify` objects (calls `->fetch()`)

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

### Passing Context into Components

If you are using Blade components for your layout rather than Blade directives, you might want to pass the view context into your layout for access by child components. You can do so with the special `$__data` variable in the layout root, and the `@aware` directive in the child. Here's how:

First, add a `context` prop to your layout component.

```blade
{{-- resources/views/components/layout.blade.php --}}
@props(['context'])
<html>
    {{-- whatever you want to put in here... --}}
</html>
```

Then, merge the `context` prop with the parent data in your Layout component's `data` method.

```php
<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Layout extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public $context)
    {
        $this->context = $context;
    }

    public function data()
    {
        return array_merge(parent::data(), $this->context);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.layout');
    }
}
```

Next, pass in the magic `$__data` variable from your template to your layout.

```blade
{{-- resources/views/default.blade.php --}}
<x-layout :context="$__data">
    <x-hero />
</x-layout>
```

Last, use the `@aware` directive in any child component of your layout to access the variables from the cascade within your component.

```blade
{{-- resources/views/components/blade.php --}}
@aware(['page'])
<div>
    {{ $page->hero_headline }}
</div>
```

## Routes and Controllers

If you choose to take a more "traditional" Laravel application approach to building your Statamic site, you can use routes and controllers much the same way you might with Eloquent models instead of Statamic's native collection routing and data cascade. Here's an example:

### The Routes

```php
use App\Http\Controllers\BlogController;

Route::get('/blog', [BlogController::class, 'index']);
Route::get('/blog/{slug}', [BlogController::class, 'show']);
```

### The Controller

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

### The Index View

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

### The Show View

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

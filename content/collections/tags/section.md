---
title: Section
description: Extracts markup to be rendered elsewhere with yield.
intro: 'The section tag is a useful way to abstract and reuse your views by extracting a section of markup that can then be rendered elsewhere with a [yield tag](/tags/yield).'
stage: 4
id: 21481d1a-ee1b-4acd-b5ad-65dc7fcec976
---
## Overview

Most commonly this section/yield approach is used to create a global area in your layout that can be changed by your templates. This eliminates the need for any brittle and messy logic.

**Cheatsheet:**

- <span class="text-red font-bold">No thank you:</span> `{{ if template == "news" }} hardcode something {{ /if }}`
- <span class="text-green font-bold">Yes please:</span> `{{ section:something }}` + `{{ yield:something }}`

## Example

In the example below, everything within the `section:sidebar` tag will _not_ be rendered in the template, but rather in the layout.

::tabs

::tab antlers
```antlers
// The Template

<h1>{{ title }}</h1>
{{ content }}

{{ section:sidebar }}
  <h2>About the Author</h2>
  <div>
    {{ author:name }}
  </div>
  {{ author:bio }}
{{ /section:sidebar }}
```

```antlers
// The Layout
<html>
  <head>
    <title>{{ title }} | {{ site_name }}</title>
  </head>
  <body>
    <article>
      {{ template_content }}
    </article>
    <aside>
      {{ yield:sidebar }}
    </aside>
  </body>
</html>
```

::tab blade
```blade
// The Template
@extends('layout')

<h1>{{ $title }}</h1>
{!! $content !!}

@section('sidebar')
  <h2>About the Author</h2>
  <div>
    {{ $author['name'] }}
  </div>
  {{ $author['bio'] }}
@endsection
```

```blade
// The Layout
<html>
  <head>
    <title>{{ $title }} | {{ $site_name }}</title>
  </head>
  <body>
    <article>
      {!! $template_content !!}
    </article>
    <aside>
      @yield('sidebar')
    </aside>
  </body>
</html>
```
::

## Related Reading

If you haven't read up on [templates and layouts](/views), you should. It's relevant.


[yield_tag]: /tags/yield

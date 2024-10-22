---
title: Parent
description: Fetches data from a parent entry
intro: The Parent tag fetches data from the "parent" page — the URL one level above the current one. For example, the parent of this very URL (`/tags/parent`) is `/tags`, and the parent title is "Tags".
stage: 3
id: 932ae2b5-0ff0-40e3-b8a4-1c71784917e4
---
## Overview

This is a simple utility tag that makes it easy to fetch data from the entry one page above the current entry. It's useful for creating section headers, simple breadcrumbs, and so on.

## Parent URL
By itself the tag returns the parent's URL.

::tabs

::tab antlers
```antlers
{{ parent }}
// Would return "/tags"
```
::tab blade
```blade
<s:parent />
```
::

## Single Variables
You can fetch single variables from the parent entry by passing them as the second tag argument.

::tabs

::tab antlers
```antlers
{{ parent:title }}
// Would return "Tags"
```
::tab blade

```blade
{{-- Using Antlers Blade Components --}}
<s:parent:title />

{{-- Using Fluent Tags --}}
{{ Statamic::tag('parent:title') }}
```

::

## Tag Pair

As a tag pair, it will have access to all the parent's data:

::tabs

::tab antlers
```antlers
{{ parent }}
  Go back to <a href="{{ url }}">{{ title }}</a>.
{{ /parent }}
```
::tab blade
```blade
<s:parent>
    Go back to <a href="{{ $url }}">{{ $title }}</a>.
</s:parent>

{{-- You also use "as" to alias the parent variable. --}}
<s:parent as="parent">
    Go back to <a href="{{ $parent['url'] }}">{{ $parent['title'] }}</a>.
</s:parent>
```
::

```html
Go back to <a href="/tags">Tags</a>.
```

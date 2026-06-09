---
id: 4e3ca511-fe21-497f-9166-3c7624607a91
blueprint: page
title: 'Tags Overview'
nav_title: Overview
intro: 'Tags are Antlers expressions that give you the ability to fetch, filter, and display content, enhance and simplify your markup, build forms, and add dynamic functionality to your templates.'
---

A their most basic level, Tags are PHP methods you call from your Antlers or Blade templates. They let you work with content, manipulate data, and build dynamic features without writing PHP directly in your templates.

Many of them serve the same role as Controllers in a traditional MVC (Model-View-Controller) style application.

## Basic Usage

Tags come in two flavors: single tags and tag pairs.

Single tags are self-contained and return a value:

::tabs

::tab antlers
```antlers
{{ collection:blog }}
  <h1>{{ title }}</h1>
{{ /collection:blog }}
```
::tab blade
```blade
<s:collection:blog>
  <h1>{{ $title }}</h1>
</s:collection:blog>
```
::

Tag pairs wrap content and can structure and  manipulate what's inside:

::tabs

::tab antlers
```antlers
{{ entries:listing folder="blog" }}
  <article>
    <h2>{{ title }}</h2>
    <p>{{ excerpt }}</p>
  </article>
{{ /entries:listing }}
```
::tab blade
```blade
<s:entries:listing folder="blog">
  <article>
    <h2>{{ $title }}</h2>
    <p>{{ $excerpt }}</p>
  </article>
</s:entries:listing>
```
::

## What Tags Can Do

Tags handle the heavy lifting in your templates:

- **Fetch content** — Get entries from collections, taxonomies, globals, and more
- **Filter and sort** — Narrow down results with powerful query parameters
- **Manipulate data** — Transform strings, arrays, dates, and other values
- **Build forms** — Create and handle form submissions
- **Control logic and flow** — Conditionally show content, loop through data, and more
- **Work with assets** — Resize images, generate responsive srcsets, and manage files

## Common Tags

Some tags you'll use frequently:

- `{{ collection:* }}` — Fetch entries from collections
- `{{ entries:listing }}` — List and filter entries
- `{{ taxonomy:* }}` — Work with taxonomy terms
- `{{ assets:* }}` — Handle images and files
- `{{ form:* }}` — Build and process forms
- `{{ if }}` / `{{ unless }}` — Conditional logic
- `{{ partial }}` — Include reusable template snippets

Browse the [full tag reference](/tags/all-tags) to see everything available, or [build your own custom tags](/tags/building-a-tag) when you need something specific.

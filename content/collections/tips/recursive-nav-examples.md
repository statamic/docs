---
id: 1e22effb-69e4-46cf-9bad-6500d7347362
title: 'Recursive Nav Examples'
intro: 'Statamic''s [nav tag](/tags/nav) is capable of some pretty rad stuff, but recursion can be a little bit hard on the old brain (on the old brain).'
template: page
categories:
  - development
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1622821220
---
Let's say we have the following pages:

<figure>
    <img src="/img/tips/recursive-nav-pages.png" alt="Pages hierarchy example">
</figure>

## Footer Nav Example

Maybe you would like to render a footer hierarchy, with top level pages as `<h3>`'s, direct sub-items as `<li>` items, while ignoring anything deeper than level 2 in the nav structure:

<figure>
    <img src="/img/tips/recursive-nav-footer-example.png" alt="Footer nav example">
</figure>

We can do this by performing a `depth` check to decide how to render the current item based on it's depth in the nav structure:

```antlers
<div class="flex">
    {{ nav }}
        {{ if depth == 1 }}
            <div class="mx-10">
                <h3 class="mb-2">{{ title }}</h3>
                {{ if children }}
                    <ul>{{ *recursive children* }}</ul>
                {{ /if }}
            </div>
        {{ elseif depth == 2 }}
            <li class="my-1">
                <a href="{{ url }}">{{ title }}</a>
            </li>
        {{ /if }}
    {{ /nav }}
</div>
```

## Sidebar Nav Example

Or maybe you would like to render a sidebar style nav as a `<ul>`, while applying a different css class based on the page's depth in the nav structure:

<figure>
    <img src="/img/tips/recursive-nav-sidebar-example.png" alt="Sidebar nav example">
</figure>

Here we dynamically insert a CSS class based on the current item's `depth` in the nav structure:

```antlers
---
nav_classes:
  1: 'text-gray-900 font-bold'
  2: 'text-gray-800 ml-3'
  3: 'text-gray-500 ml-6 text-sm'
---

<ul class="nav">
    {{ nav }}
        <li>
            <span class="{{ view:nav_classes[depth] }}">
                {{ title }}
            </span>
            {{ if children }}
                <ul class="{{ depth == 1 ?= 'mb-4' }}">
                    {{ *recursive children* }}
                </ul>
            {{ /if }}
        </li>
    {{ /nav }}
</ul>
```

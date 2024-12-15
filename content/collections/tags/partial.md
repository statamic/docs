---
title: Partial
description: Renders a partial view
intro: Partials are reusable [views](/views) that may find themselves in any number of other layouts, templates, and other partials.
video: https://youtu.be/Ddz6mD-jT7E
parameters:
  -
    name: src
    type: string
    description: |
      You can pass the name of the partial with a parameter instead of tag argument. Example: `src="cards/author_bio"` or `:src="var_name"`.
  -
    name: when
    type: string
    description: |
      Render a partial only if a condition is met.
  -
    name: unless
    type: string
    description: |
      The converse of `when`.
  -
    name: "*"
    type: mixed
    description: |
      Any parameter you create will be passed through to the partial as a variable.
stage: 5
id: 1f683992-401e-44f6-8506-7967005778a5
---
## Overview

You can use any view as a partial by using this here partial tag.

::tabs

::tab antlers
```antlers
// This will import /resources/views/blog/_card.antlers.html
{{ partial:blog/card }}
```
::tab blade
```blade
// This will import /resources/views/blog/_card.antlers.html
<s:partial:blog/card />
```
::

:::best-practice
We recommend prefixing any views intended to be _only_ used as partials with an underscore, `_like-this.antlers.html` and reference them `{{ partial:like-this }}. The underscore is not necessary in the partial tag definition.
:::

## Passing Data

You can pass additional data into a partial via on-the-fly parameters. The parameter name will become a variable inside the partial. The only reserved parameter is `src`, so you can name your variables just about anything.

::tabs

::tab antlers
```antlers
{{ partial:list header="favorite ice cream flavors" :items="flavors" }}

// Inside `list.antlers.html`
<h2>These are my {{ header }}</h2>
{{ items | ul }}
```
::tab blade
```blade
<s:partial:list
  header="favorite ice cream flavors"
  :items="$flavors"
/>
```

```blade
{{-- Inside `list.blade.php` --}}

<h2>These are my {{ $header }}</h2>
{!! Statamic::modify($items)->ul() !!}
```
::

```html
<h2>These are my favorite ice cream flavors</h2>
<ul>
  <li>Chocolate Chip Cookie Dough</li>
  <li>Mint Chocolate Chip</li>
  <li>Neon Mind Melter</li>
</ul>
```

Note that the `:items` parameter is prefixed by a colon, meaning it will pass the _value_ of a `flavors` variable, if it exists.


:::best-practice
To set default values for parameters inside your partials, you can [add YAML front-matter](/variables/#view-frontmatter) to the top of your Antlers partials.

In the example below, the partial has two front-matter variables (`author` and `image`). When the partial is called, the `author` parameter is provided. When the partial is outputted, the `author` parameter is used, and the value for the `image` variable falls back to the partial's front-matter.

::tabs

::tab antlers
```antlers
{{ partial:card author="David Hasselhoff" }}
```

```antlers
---
author: Jack McDade
image: https://example.com/placeholder.png
---

<img src="{{ view:image }}">
<p>Written by {{ view:author }}</p>
```
::tab blade
```blade
<s:partial:card author="David Hasselhoff" />
```

```blade
@frontmatter([
  'author' => 'Jack McDade',
  'image'  => 'https://example.com/placeholder.png',
])

<img src="{{ $view['image'] }}">
<p>Written by {{ $view['author'] }}</p>
```
::

```html
<img src="https://example.com/placeholder.png"> <!-- No image was provided, so falling back to the front-matter. -->
<p>Written by David Hasselhoff</p> <!-- Author parameter provided, so using that. -->
```

This technique is preferrable over defining custom variables inside your partial.

:::


## Slots

Sometimes you might need to pass a large chunk of content into a partial. Jamming a bunch of HTML through a parameter would be like trying to shove a pizza through a donut. A hilarious YouTube video but a bad idea on a Friday night.

The solution is to use the partial tag as a pair. Everything inside will be passed into the partial in the `{{ slot }}` variable.

::tabs
::tab antlers
```antlers
// Your main view
{{ partial:modal title="Confirmation" }}
  <div class="flex items-center">
    <img src="/img/warning.svg" />
    <p>Are you sure you want to delete your entire collection of WWE wrestling figures?</p>
  </div>
{{ /partial:modal }}

// _modal.antlers.html
<div class="bg-white rounded shadow">
  <h2 class="p-2 border-b">{{ title }}</h2>
  {{ slot }}
  <button @click="confirm" class="button">Do it</button>
</div>
```
::tab blade
```blade
// Your main view
<s:partial:modal title="Confirmation">
  <div class="flex items-center">
    <img src="/img/warning.svg" />
    <p>Are you sure you want to delete your entire collection of WWE wrestling figures?</p>
  </div>
</s:partial:modal>

// _modal.blade.php
<div class="bg-white rounded shadow">
  <h2 class="p-2 border-b">{{ $title }}</h2>
  {!! $slot !!}
  <button @click="confirm" class="button">Do it</button>
</div>
```
::

```output
<div class="bg-white rounded shadow">
  <h2 class="p-2 border-b">Confirmation</h2>
    <div class="flex items-center">
      <img src="/img/warning.svg" />
      <p>Are you sure you want to delete your entire collection of WWE wrestling figures?</p>
  </div>
  <button @click="confirm" class="button">Do it</button>
</div>
```

You could also name your slots by appending `:name`.

## Conditional Rendering

You can render a partial only if a condition is met.

::tabs
::tab antlers
```antlers
{{ partial:components/subtitle :when="subtitle" }}
    {{ subtitle }}
{{ /partial:components/subtitle }}
```
::tab blade
```blade
<s:partial:components/subtitle :when="isset($subtitle)">
  {{ $subtitle }}
</s:partial:components/subtitle>
```
::

Also supports the converse using `:unless`.

## Related Reading

If you haven't read up on [views](/views) yet, you should. It's considered fundamental knowledge, like knowing that seals are just dog mermaids. 🐕 🧜‍♀️

You may also be interested in the [`partial:exists`](/tags/partial-exists) or [`partial:if_exists`](/tags/partial-if-exists) tags.

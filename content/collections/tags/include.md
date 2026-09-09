---
title: Include
description: Renders another view with strict, predictable scoping
intro: The include tag renders another [view](/views), like the [partial](/tags/partial) tag, but with stricter variable scope rules and support for scoped slots.
parameters:
  -
    name: src
    type: string
    description: |
      You can pass the name of the view with a parameter instead of the tag argument. Example: `src="cards/author_bio"` or `:src="var_name"`.
  -
    name: when
    type: string
    description: |
      Render the view only if a condition is met.
  -
    name: unless
    type: string
    description: |
      The converse of `when`.
  -
    name: cascade
    type: boolean
    description: |
      When `true`, the [Cascade](/content-modeling/data-inheritance) is made available inside the view. Defaults to `false`.
  -
    name: params
    type: array
    description: |
      An associative array whose entries become variables in the view. Any parameter you set directly on the tag overrides a matching key.
  -
    name: handle_prefix
    type: string|array
    description: |
      A prefix, or array of prefixes, to strip from the keys in `params`. With `handle_prefix="hero_"`, a `hero_title` entry is also available as `{{ title }}`.
  -
    name: "*"
    type: mixed
    description: |
      Any other parameter you create will be passed through to the view as a variable.
id: d2bb11fc-5acf-44f4-b134-7a27b9f0dc78
---
## Overview

The `include` tag renders another [view](/views), just like the [partial](/tags/partial) tag, but the two differ in how variables are passed in and general scoping rules. A `partial` inherits your template's data automatically. An `include` sees only what you pass it, its own front-matter, and the Cascade if you opt in.

::tabs

::tab antlers
```antlers
{{# Import /resources/views/blog/_card.antlers.html #}}
{{ include:blog/card }}
```
::tab blade
```blade
{{-- This will import /resources/views/blog/_card.antlers.html --}}
<s:include:blog/card />
```
::

## Scope Isolation

The `include` tag has stricter scope than `partial`. Below, _your template_ is the file calling the tag, and _the view_ is the file being included:

1. Views receive no data from your template. Only tag parameters, [`params`](#passing-lots-of-data) entries, and the view's own front-matter are available.
2. Variables assigned _inside_ a view don't leak back to your template, even when both use the same name.
3. Reassigning a variable you passed in won't leak the new value back to your template.
4. The [Cascade](/content-modeling/data-inheritance) is unavailable unless you opt in with `cascade="true"`.
5. Nested includes do not inherit the variables of their parent includes.
6. Slot content uses the variables of your template.

The difference between the two tags is easiest to see side by side:

::tabs
::tab include
```antlers
{{ title = "Dashboard" }}

{{ include:widget }}

Result: {{ title }}
```

```antlers
{{# _widget.antlers.html #}}
<h2>{{ title }}</h2>
{{ title = "Widget" }}
```

```output
<h2></h2>

Result: Dashboard
```
::tab partial
```antlers
{{ title = "Dashboard" }}

{{ partial:widget }}

Result: {{ title }}
```

```antlers
{{# _widget.antlers.html #}}
<h2>{{ title }}</h2>
{{ title = "Widget" }}
```

```output
<h2>Dashboard</h2>

Result: Widget
```
::

:::tip
Scope isolation applies to your data, not to cross-template features. Stacks, [sections](/tags/section), and the [scope](/tags/scope) tag all still work from inside an included view, and are the intended way to send something back out.
:::

### The Cascade

The [Cascade](/content-modeling/data-inheritance) is not available inside an included view by default, including globals, `current_user`, and URL segments. You may opt in with `cascade="true"`:

::tabs
::tab antlers
```antlers
{{ include:header cascade="true" }}

{{# Inside `header.antlers.html` #}}
Welcome back, {{ current_user:name }}
```
::tab blade
```blade
<s:include:header cascade="true" />

{{-- Inside `header.blade.php` --}}
Welcome back, {{ $current_user['name'] }}
```
::

The Cascade is opt-in per include, and nested includes don't inherit it.

### Front-Matter Defaults

Included views can define default values with [YAML front-matter](/variables/overview#view-front-matter), just like partials. Parameters you pass override the defaults.

::tabs

::tab antlers
```antlers
{{ include:card author="David Hasselhoff" }}
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
<s:include:card author="David Hasselhoff" />
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
<img src="https://example.com/placeholder.png"> <!-- No image provided, so falling back to the front-matter. -->
<p>Written by David Hasselhoff</p> <!-- Author provided, so using that. -->
```

Unlike partials, each include's `view` data is not merged into other nested includes.

## Passing Data

You must pass data into an included view explicitly:

::tabs

::tab antlers
```antlers
{{ include:list header="favorite ice cream flavors" :items="flavors" }}

{{# Inside `list.antlers.html` #}}
<h2>These are my {{ header }}</h2>
{{ items | ul }}
```
::tab blade
```blade
<s:include:list
  header="favorite ice cream flavors"
  :items="$flavors"
/>

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

### Passing Lots of Data

Rather than listing out one parameter per variable, use `params`. It takes an associative array and spreads each entry into the view as its own variable, which is handy for something like a [Replicator](/fieldtypes/replicator) set.

::tabs

::tab antlers
```antlers
{{ include:card :params="author" }}

{{# Inside `card.antlers.html` #}}
<h2>{{ name }}</h2>
<img src="{{ avatar }}">
```
::tab blade
```blade
<s:include:card :params="$author" />

{{-- Inside `card.blade.php` --}}
<h2>{{ $name }}</h2>
<img src="{{ $avatar }}">
```
::

Parameters set directly on the tag override matching keys in the array:

::tabs
::tab antlers
```antlers
{{ include:card :params="author" name="A different name" }}
```
::tab blade
```blade
<s:include:card :params="$author" name="A different name" />
```
::

Passing anything other than an associative array to `params` will throw an exception.

:::tip
A `params` variable is also made available to you within the view. The `params` variable will contain _all_ parameters set on the `include` tag (not just those passed to `params`). This can be useful to check if something was actually explicitly set on the tag.
:::

::tabs
::tab antlers
```antlers
{{ include:card :params="author" role="Editor" }}

{{# Inside `card.antlers.html` #}}
{{ params:name }}  {{# From the params array #}}
{{ params:role }}  {{# From the parameter set on the tag #}}
```
::tab blade
```blade
<s:include:card :params="$author" role="Editor" />

{{-- Inside `card.blade.php` --}}
{{ $params['name'] }}  {{-- From the params array --}}
{{ $params['role'] }}  {{-- From the parameter set on the tag --}}
```
::

You may also use the `params` parameter to pass data that has the same name as a reserved parameter, such as `src`, `when`, `cascade`, etc.

### Variable Prefixing

When your data shares a common prefix, such as fields from an imported fieldset, use `handle_prefix` to remove the prefix from variables within the included view. With `handle_prefix="hero_"`, a `hero_title` entry becomes available as `{{ title }}`.

::tabs
::tab antlers
```antlers
{{ include:hero :params="entry" handle_prefix="hero_" }}

{{# Inside `hero.antlers.html` #}}
<h1>{{ title }}</h1>
<p>{{ subtitle }}</p>
```
::tab blade
```blade
<s:include:hero :params="$entry" handle_prefix="hero_" />

{{-- Inside `hero.blade.php` --}}
<h1>{{ $title }}</h1>
<p>{{ $subtitle }}</p>
```
::

Prefixed variables are _added_, not renamed. A `hero_title` entry is available as both `{{ title }}` and `{{ hero_title }}`.

You may also pass an array, such as `:handle_prefix="['hero_', 'banner_']"`. Prefixes are checked in order, and the first to produce a given name wins.

:::tip
When the same variable name comes from more than one place, this is the order of priority (highest first):

1. A prefixed parameter set directly on the tag (`hero_title`)
2. A plain parameter set directly on the tag (`title`)
3. A prefixed key from `params` (`hero_title`)
4. A plain key from `params` (`title`)
:::

## Slots

To pass a chunk of markup into a view, use the include tag as a pair. Everything between the tags becomes the `{{ slot }}` variable:

::tabs
::tab antlers
```antlers
{{# In your template #}}
{{ include:modal title="Confirmation" }}
  <div class="flex items-center">
    <img src="/img/warning.svg" />
    <p>Are you sure you want to delete your collection of WWE wrestling figures?</p>
  </div>
{{ /include:modal }}

{{# _modal.antlers.html #}}
<div class="bg-white rounded shadow">
  <h2 class="p-2 border-b">{{ title }}</h2>
  {{ slot }}
  <button class="button">Do it</button>
</div>
```
::tab blade
```blade
{{-- In your template --}}
<s:include:modal title="Confirmation">
  <div class="flex items-center">
    <img src="/img/warning.svg" />
    <p>Are you sure you want to delete your collection of WWE wrestling figures?</p>
  </div>
</s:include:modal>

{{-- _modal.blade.php --}}
<div class="bg-white rounded shadow">
  <h2 class="p-2 border-b">{{ $title }}</h2>
  {!! $slot !!}
  <button class="button">Do it</button>
</div>
```
::

Slots are _lazily_ evaluated when using the include tag. They render only when the view outputs them. Slot content uses your template's variables plus the include's [`params`](#passing-lots-of-data).

### Named Slots

A view can have more than one slot. Define them in your template with `slot:name` pairs, and output them in the view the same way as the default slot:

::tabs
::tab antlers
```antlers
{{ include:card }}
  {{ slot:header }}<h1>Welcome</h1>{{ /slot:header }}

  This is the default slot.
{{ /include:card }}

{{# _card.antlers.html #}}
<header>{{ slot:header }}</header>
<main>{{ slot }}</main>
```
::tab blade
```blade
<s:include:card>
  <s:slot:header><h1>Welcome</h1></s:slot:header>

  This is the default slot.
</s:include:card>

{{-- _card.blade.php --}}
<header><s:slot:header /></header>
<main>{{ $slot }}</main>
```
::

### Fallback Content

Render default content when a slot wasn't provided. Checking a slot tests for its presence without forcing a render:

::tabs
::tab antlers
```antlers
{{# Inside the view #}}
{{ if slot:header }}
  <header>{{ slot:header }}</header>
{{ else }}
  <header>Default heading</header>
{{ /if }}
```
::tab blade
```blade
{{-- Inside the view --}}
<header><s:slot:header>Default heading</s:slot:header></header>
```
::

### Scoped Slots

Add parameters to a slot's output tag and they become variables inside the slot's content. This is ideal for loops, where each iteration passes the slot its own values:

::tabs
::tab antlers
```antlers
{{# In your template #}}
{{ include:list :rows="people" }}
  {{ slot:row }}
    {{ name }} - #{{ index }}
  {{ /slot:row }}
{{ /include:list }}

{{# In _list.antlers.html #}}
{{ rows }}
  {{ slot:row :name="name" :index="count" }}
{{ /rows }}
```
::tab blade
```blade
{{-- In your template --}}
<s:include:list :rows="$people">
  <s:slot:row>{{ $name }} - #{{ $index }}</s:slot:row>
</s:include:list>

{{-- In _list.blade.php --}}
@foreach ($rows as $person)
  <s:slot:row :name="$person['name']" :index="$loop->iteration" />
@endforeach
```
::
```output
Alice - #1
Bob - #2
Carol - #3
```

This also works with the default slot:

::tabs
::tab antlers
```antlers
{{# In your template #}}
{{ include:list :rows="people" }}
  {{ name }} - #{{ index }}
{{ /include:list }}

{{# In _list.antlers.html #}}
{{ rows }}
  {{ slot :name="name" :index="count" /}}
{{ /rows }}
```
::tab blade
```blade
{{-- In your template --}}
<s:include:list :rows="$people">
  {{ $name }} - #{{ $index }}
</s:include:list>

{{-- In _list.blade.php --}}
@foreach ($rows as $person)
  <s:slot :name="$person['name']" :index="$loop->iteration" />
@endforeach
```
::
```output
Alice - #1
Bob - #2
Carol - #3
```

Inside the slot, these parameters take precedence over variables of the same name from your template.

### Forwarding Slots

A slot is just a value, so a view can pass one it received to another include, either as a parameter or wrapped in a new pair:

```antlers
{{# _card.antlers.html forwards its slot to _panel.antlers.html #}}
{{ include:panel :slot="slot" }}

{{# Or, wrap it with more content along the way #}}
{{ include:panel }}<h2>{{ title }}</h2>{{ slot }}{{ /include:panel }}
```

## Conditional Rendering

Render a view only if a condition is met with `when`, or its converse, `unless`.

::tabs
::tab antlers
```antlers
{{ include:components/subtitle :when="subtitle" }}
  {{ subtitle }}
{{ /include:components/subtitle }}
```
::tab blade
```blade
<s:include:components/subtitle :when="isset($subtitle)">
  {{ $subtitle }}
</s:include:components/subtitle>
```
::

## Using With Modifiers

Because `include` is a tag and not a variable, you can't pipe it through [modifiers](/modifiers) directly. Wrap it in a [sub-expression](/antlers#sub-expressions) using curly braces to apply modifiers to its output.

```antlers
{{ {include:component} | spaceless }}
```

In Blade, render the view and pass the result through `Statamic::modify()`:

```blade
{!! Statamic::modify(Statamic::tag('include:component')->fetch())->spaceless() !!}
```

## Related Reading

If you haven't read up on [views](/views) yet, you should. It's considered fundamental knowledge, like knowing that seals are just dog mermaids. 🐕 🧜‍♀️

The [partial](/tags/partial) tag covers the same ground with inherited scoping. Reach for it when you want the surrounding data to flow in automatically.

You may also be interested in the [`include:exists`](/tags/include-exists) or [`include:if_exists`](/tags/include-if-exists) tags.

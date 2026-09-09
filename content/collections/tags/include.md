---
title: Include
description: Renders a view without inheriting the surrounding scope
intro: 'A strictly-scoped alternative to the [partial](/tags/partial) tag. Where `partial` shares everything from the surrounding template, `include` only sees what you explicitly pass to it.'
parameters:
  -
    name: src
    type: string
    description: |
      You can pass the name of the view with a parameter instead of tag argument. Example: `src="cards/author"` or `:src="var_name"`.
  -
    name: params
    type: array
    description: |
      An array of data to spread into the include as variables. Example: `:params="author"`.
  -
    name: handle_prefix
    type: string
    description: |
      A prefix to strip from variable names when looking up data. For example, if you have a variable named `hero_title` and use `handle_prefix="hero_"`, you can reference it as `{{ title }}` inside the view.
  -
    name: cascade
    type: string
    description: |
      Pass `true` to make the [Cascade](/tags/cascade) (page, globals, site, etc.) available inside the view. Off by default.
  -
    name: when
    type: string
    description: |
      Render the include only if a condition is met.
  -
    name: unless
    type: string
    description: |
      The converse of `when`.
  -
    name: "*"
    type: mixed
    description: |
      Any parameter you create will be passed through to the view as a variable.
id: dc16f77a-2b02-40c9-9097-6e94f38edd94
---
## Overview

The [partial](/tags/partial) tag automatically shares every variable from the calling template with the view it renders. That's convenient, but it's also the source of a long line of scoping gotchas: variables set inside a partial leaking back out, parameters from one partial showing up in another rendered later on the page, and front matter hanging around longer than expected.

The `include` tag renders a view the same way, but doesn't automatically share anything. Only the data you explicitly pass in is available inside the view.

::tabs

::tab antlers
```antlers
{{ include:cards/author name="Jimothy" :bio="author_bio" }}
```
::tab blade
```blade
<s:include:cards/author name="Jimothy" :bio="$authorBio" />
```
::

### How It Differs From Partial

| | `partial` | `include` |
|---|---|---|
| Variables from the surrounding template | All of them | Only what you pass in |
| Variables set inside the view | Can leak back into the page | Stay inside the include |
| The Cascade (page, globals, etc.) | Automatically available | Requires `cascade="true"` |
| Front matter | Visible to other views rendered later | Stays with the include |
| Slots | Rendered up front, passed as strings | Rendered on demand, and can receive data back from the view |

## Passing Data

Unlike `partial`, any parameter you set on the tag becomes a variable inside the view, and nothing else does.

::tabs

::tab antlers
```antlers
{{ include:cards/author name="Jimothy" role="Editor" }}

// Inside cards/author.antlers.html
{{ name }} — {{ role }}
```
::tab blade
```blade
<s:include:cards/author name="Jimothy" role="Editor" />
```

```blade
{{-- Inside cards/author.blade.php --}}
{{ $name }} — {{ $role }}
```
::

You can spread an entire array of data using `:params`. Inside the view, use `params` to check what was actually passed in:

::tabs

::tab antlers
```antlers
{{ include:cards/author :params="author" role="Editor" }}

// Inside cards/author.antlers.html
{{ name }}, {{ params:role }}
```
::tab blade
```blade
<s:include:cards/author :params="$author" role="Editor" />
```
::

Use `handle_prefix` to make prefixed keys like `hero_title` available inside the view as both `hero_title` and `title`:

::tabs

::tab antlers
```antlers
{{ include:hero :params="entry" handle_prefix="hero_" }}
```
::tab blade
```blade
<s:include:hero :params="$entry" handle_prefix="hero_" />
```
::

:::best-practice
To set default values for parameters inside your includes, you can [add YAML front-matter](/variables/#view-frontmatter) to the top of your Antlers include, and reference it with the `view:` prefix. Just like `partial`, this is preferable over defining custom variables inside the view.
:::

## Slots

Content between the tag pair becomes the default slot, available inside the view as `{{ slot }}`.

::tabs

::tab antlers
```antlers
{{ include:modal title="Delete this entry?" }}
    <p>This action cannot be undone.</p>
{{ /include:modal }}

// Inside modal.antlers.html
<h2>{{ title }}</h2>
<main>{{ slot }}</main>
```
::tab blade
```blade
<s:include:modal title="Delete this entry?">
  <p>This action cannot be undone.</p>
</s:include:modal>
```

```blade
{{-- Inside modal.blade.php --}}
<h2>{{ $title }}</h2>
<main>{{ $slot }}</main>
```
::

### Named Slots

Define named slots with `slot:name` pairs. A view can give a named slot a fallback by wrapping its own content in a matching pair.

::tabs

::tab antlers
```antlers
{{ include:modal title="Delete this entry?" }}
    {{ slot:footer }}<button>Cancel</button>{{ /slot:footer }}
    <p>This action cannot be undone.</p>
{{ /include:modal }}

// Inside modal.antlers.html
<h2>{{ title }}</h2>
<main>{{ slot }}</main>
<footer>{{ slot:footer }}No footer provided{{ /slot:footer }}</footer>
```
::tab blade
```blade
<s:include:modal title="Delete this entry?">
  <s:slot:footer><button>Cancel</button></s:slot:footer>
  <p>This action cannot be undone.</p>
</s:include:modal>
```

```blade
{{-- Inside modal.blade.php --}}
<h2>{{ $title }}</h2>
<main>{{ $slot }}</main>
<footer><s:slot:footer>No footer provided</s:slot:footer></footer>
```
::

Slots only render when the view actually uses them, and a slot is re-rendered each time the view outputs it — which means a view can pass data back into a slot and render it once per iteration of a loop:

::tabs

::tab antlers
```antlers
{{ include:table :rows="rows" }}
    {{ slot:row }}<td>{{ cell }}</td>{{ /slot:row }}
{{ /include:table }}

// Inside table.antlers.html
<table>{{ rows }}<tr>{{ slot:row :cell="value" }}</tr>{{ /rows }}</table>
```
::tab blade
```blade
<s:include:table :rows="$rows">
  <s:slot:row><td>{{ $cell }}</td></s:slot:row>
</s:include:table>
```

```blade
{{-- Inside table.blade.php --}}
<table>@foreach($rows as $row)<tr><s:slot:row :cell="$row['value']" /></tr>@endforeach</table>
```
::

## The Cascade

Includes don't see the [Cascade](/tags/cascade) by default. Pass `cascade="true"` when you want it:

::tabs

::tab antlers
```antlers
{{ include:site_header cascade="true" }}
```
::tab blade
```blade
<s:include:site_header cascade="true" />
```
::

## Conditional Rendering

You can render an include only if a condition is met, using `when` and its converse, `unless`.

::tabs

::tab antlers
```antlers
{{ include:promo :when="show_promo" }}
```
::tab blade
```blade
<s:include:promo :when="$showPromo" />
```
::

## Using With Modifiers

Because the `include` tag is a tag and not a variable, you can't pipe it through [modifiers](/modifiers) directly. To apply modifiers to an include's rendered output, wrap it in a [sub-expression](/antlers#sub-expressions) using curly braces.

```antlers
{{ { include:component } | spaceless }}
```

## Related Reading

You may also be interested in the [`include:exists`](/tags/include-exists) or [`include:if_exists`](/tags/include-if-exists) tags.

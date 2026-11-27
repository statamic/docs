---
id: 083c717b-545c-45be-a65b-67faf1aa886f
blueprint: page
title: 'Antlers Components'
intro: 'Build reusable components with Antlers, render existing Laravel Blade components, and use HTML-style syntax for Statamic Tags.'
related_entries:
  - d37b2af2-f2bf-493a-9345-7087fb5929ce
  - 0c54fe7c-c87a-4812-b76e-48f16cf08e0d
  - c7816387-ebc4-4204-b5f2-8e7073a4db8b
---
## Overview

Components are reusable, self-contained chunks of interface, such as callouts, cards, buttons, layouts, or whatever else you keep copying and pasting around your site. Antlers can render [Laravel Blade components](https://laravel.com/docs/13.x/blade#components), and anonymous components can be written with Antlers itself.

That gives you two closely related flavors of angle-bracket syntax:

| Syntax | What it renders |
| --- | --- |
| `<x-callout />` | A Laravel component class or anonymous component view. The view may use Blade or Antlers. |
| `<s:collection:blog>...</s:collection:blog>` | A Statamic [Tag](/tags) using component-style syntax. |
| `{{ collection:blog }}...{{ /collection:blog }}` | The same Statamic Tag using classic Antlers syntax. |

:::tip
[Partials](/frontend/antlers#partials) inherit the current Antlers scope and are perfect for straightforward includes. Components have their own scope and explicitly receive data through props, the Cascade, and slots.
:::

## Creating a component

Anonymous components live in `resources/views/components`. Give the view an `.antlers.html` extension to build it with Antlers:

```antlers
{{# resources/views/components/callout.antlers.html #}}
@props([
    'type' => 'info',
    'title' => 'Heads up!' | upper,
])

<aside {{ attributes.merge([
    'class' => 'callout callout--' + type,
]) }}>
    <h2>{{ title }}</h2>

    {{ if slot | has_actual_content }}
        <div>{{ slot }}</div>
    {{ /if }}
</aside>
```

Render it from any Antlers template with an `x-` tag. Paired components receive everything between their tags as the default `slot`:

```antlers
<x-callout class="mt-8">
    Save your work before continuing.
</x-callout>
```

Components without slot content may self-close:

```antlers
<x-callout type="warning" title="Back up first" />
```

Components in subdirectories use dot notation. For example, `resources/views/components/menu/item.antlers.html` becomes `<x-menu.item />`.

:::tip
**[Blade components](https://laravel.com/docs/blade#components) work, too!** Use them from Antlers without rewriting anything. Blade and Antlers components may even nest inside each other like one big, happy template-language family.
:::

## Props

The `@props` directive defines the data your component expects. Values with named keys provide defaults, and those defaults are Antlers expressions, not PHP. That means variables, operators, and modifiers like `upper` are all fair game, if that's your style.

```antlers
@props([
    'type' => 'info',
    'title' => 'Heads up!' | upper,
])
```

Literal attributes pass strings. Prefix an attribute with `:` to resolve its value from the Antlers scope, or use `:$variable` when the prop and variable share a name:

```antlers
{{ page_title = 'Back up first' }}
{{ type = 'warning' }}

<x-callout :title="page_title" :$type />
```

These are Antlers' [usual parameter rules](/frontend/antlers#tag-parameters), even when the component itself is written in Blade.

## Attributes

Attributes not declared as props are collected in the `attributes` bag. Render the bag directly, or call its Laravel methods with Antlers' dot syntax:

```antlers
<aside {{ attributes.merge([
    'class' => 'callout callout--' + type,
]) }}>
    ...
</aside>
```

The `merge` method adds the component's default attributes while preserving those passed by the caller. Class names are combined, so our earlier `class="mt-8"` joins the callout classes instead of booting them out of the club.

## Slots

The `slot` variable contains the component's unnamed content. Use the `has_actual_content` modifier when whitespace and HTML comments alone should count as empty:

```antlers
{{ if slot | has_actual_content }}
    <div>{{ slot }}</div>
{{ /if }}
```

The closely related `is_string` modifier is available when you need to distinguish an ordinary string from a slot object or another value:

```antlers
{{ if value | is_string }}
    {{ value }}
{{ /if }}
```

### Named slots

Use `<x-slot:name>` to send content to a named slot:

```antlers
<x-panel>
    <x-slot:heading class="text-xl">
        Fresh from the blog
    </x-slot:heading>

    The latest dispatches from our crew.
</x-panel>
```

The component receives the slot as a variable. Any attributes on the slot are available through its own `attributes` bag:

```antlers
{{# resources/views/components/panel.antlers.html #}}
<section>
    <header {{ heading.attributes }}>{{ heading }}</header>
    <div>{{ slot }}</div>
</section>
```

## Scope

A component does not inherit the Antlers variables or Cascade data around it. Variables created inside the component do not leak out, either. Pass values as props when they are part of the component's public API.

Slot content is the intentional exception. It is evaluated in the caller's scope, so variables available where you invoke the component remain available inside its default and named slots.

### Cascade data

Use `@cascade` when a component needs data from Statamic's [Cascade](/data-inheritance). Pass a list to import only the values you need. Values listed without defaults are required; a named key may provide a fallback:

```antlers
@cascade([
    'title',
    'eyebrow' => 'Latest',
])

<h2>{{ title }}</h2>
<p>{{ eyebrow }}</p>
```

Omit the arguments to import the entire Cascade:

```antlers
@cascade
```

Pulling in everything is convenient, but selecting values keeps the component's dependencies much easier to spot six months from now.

### Sharing parent props

The `@aware` directive lets a nested component consume props explicitly passed to an ancestor component. Here, the menu item picks up the menu's `tone`:

```antlers
{{# resources/views/components/menu.antlers.html #}}
@props([
    'tone' => 'light'
])

<nav class="menu menu--{{ tone }}">
    {{ slot }}
</nav>
```

```antlers
{{# resources/views/components/menu/item.antlers.html #}}
@aware([
    'tone' => 'light'
])

<a class="menu__item menu__item--{{ tone }}">{{ slot }}</a>
```

```antlers
<x-menu tone="dark">
    <x-menu.item>Docs</x-menu.item>
</x-menu>
```

Like `@props`, the values passed to `@aware` are Antlers expressions. Providing a fallback keeps the nested component useful when it appears outside its usual parent.

### Escaping directives

If you need any of these directives to appear as literal text, add another `@`:

```antlers
@@props(['example'])
@@aware(['example'])
@@cascade
```

This renders `@props(['example'])`, `@aware(['example'])`, and `@cascade` without evaluating them.

## Component-style Statamic Tags

Statamic Tags may also use HTML-like syntax in Antlers. Prefix the Tag with either `s:` or `statamic:` and otherwise use it as normal:

```antlers
<s:collection:pages limit="3">
    <a href="{{ url }}">{{ title }}</a>
</s:collection:pages>
```

This is equivalent to classic Antlers syntax:

```antlers
{{ collection:pages limit="3" }}
    <a href="{{ url }}">{{ title }}</a>
{{ /collection:pages }}
```

Parameters still follow Antlers rules, including dynamic values and shorthand:

```antlers
<s:collection :from="collection_handle" :$limit>
    <a href="{{ url }}">{{ title }}</a>
</s:collection>
```

You may use `s-` and `statamic-` prefixes instead if dashes feel more HTML-ish, and Tags without enclosed content may self-close. This syntax still invokes a Statamic Tag; it does not look for a component view in `resources/views/components`.

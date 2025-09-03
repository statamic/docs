---
id: e781427c-52ba-4f2a-9ba5-1614db05dc56
blueprint: ui_component
title: Badge
template: ui-component
intro: Highlight contextual information, like status, count, or related data. You can pass text through a `text` prop or use it like an HTML tag pair.
---

```component
<ui-badge color="green" size="lg">New</ui-badge>
<ui-badge color="red" size="lg" text="Hot"></ui-badge>
<ui-badge color="amber" size="lg" text="Soup"></ui-badge>
```


## Sizes
Badges are available in two sizes via the <code>size</code> prop.

```component
<ui-badge size="sm">Small</ui-badge>
<ui-badge>Default</ui-badge>
<ui-badge size="lg">Large</ui-badge>
```


## Colors
<p>Use the <code>color</code> attribute to change the badge's color.</p>

```component
<ui-badge>Default</ui-badge>
<ui-badge color="white">White</ui-badge>
<ui-badge color="black">Black</ui-badge>
<ui-badge color="red">Red</ui-badge>
<ui-badge color="orange">Orange</ui-badge>
<ui-badge color="amber">Amber</ui-badge>
<ui-badge color="yellow">Yellow</ui-badge>
<ui-badge color="lime">Lime</ui-badge>
<ui-badge color="green">Green</ui-badge>
<ui-badge color="emerald">Emerald</ui-badge>
<ui-badge color="teal">Teal</ui-badge>
<ui-badge color="cyan">Cyan</ui-badge>
<ui-badge color="sky">Sky</ui-badge>
<ui-badge color="blue">Blue</ui-badge>
<ui-badge color="indigo">Indigo</ui-badge>
<ui-badge color="violet">Violet</ui-badge>
<ui-badge color="purple">Purple</ui-badge>
<ui-badge color="fuchsia">Fuchsia</ui-badge>
<ui-badge color="pink">Pink</ui-badge>
<ui-badge color="rose">Rose</ui-badge>
```


## Variants

Use the <code>variant</code> prop to change the badge's style and shape. Flat badges are in slightly taller than default ones to account for the optical perception of borders and shadows.

```component
<ui-badge size="lg">Default</ui-badge>
<ui-badge variant="flat" size="lg">Flat</ui-badge>
```


## Append & Prepend

Use the `append` and `prepend` props to add smaller supporting text before or after the main text, perfect for counts, numbers, and other small details.

```component
<ui-badge color="black" append="42">Events</ui-badge>
<ui-badge color="purple" prepend="Updates">31</ui-badge>
```


## Icons

Automatically sized and styled icons are available for your badges using the `icon` or `icon-append` props to pass the name of an icon.

```component
<ui-badge icon="mail">david@hasselhoff.com</ui-badge>
<ui-badge icon-append="x" color="red" as="button">Delete</ui-badge>
```


## Pills

Use the <code>pill</code> prop to round out the badge.

```component
<ui-badge pill>Pill</ui-badge>
```


## As a link

Badges can be used as links by passing an <code>href</code> prop.

```component
<ui-badge pill variant="flat" size="lg" href="https://statamic.dev/">
<p>Go read the <b>docs</b></p>
</ui-badge>
```


## As a button

Badges can be used as buttons by setting the `as="button"` prop.

```component
<ui-badge as="button">Click Me</ui-badge>
```

---
id: 327f4a3b-04d4-4069-881a-fe50ddb9be23
blueprint: modifiers
modifier_types:
  - array
  - markup
title: OL
related_entries:
  - fbdb7bf5-ac19-444c-9536-57332ffff388
  - 85910466-876b-4fc7-9dd1-c9baa7f7870a
---
Turn an array into an HTML ordered list element.

:::hot tip
`ol` accepts colon delimited key:value pairs to pass HTML attributes to the `<ol>` element; you cannot pass attributes to individual `<li>` elements.

```antlers
{{ food | ol('class:dessert', 'disabled:') }}
```
:::

```yaml
food:
  - sushi
  - broccoli
  - kale
```

::tabs

::tab antlers
```antlers
{{ food | ol }}
```
::tab blade
```blade
{!! Statamic::modify($food)->ol() !!}
```
::

```html
<ol>
  <li>sushi</li>
  <li>broccoli</li>
  <li>kale</li>
</ol>
```
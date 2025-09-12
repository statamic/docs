---
id: 85910466-876b-4fc7-9dd1-c9baa7f7870a
blueprint: modifiers
modifier_types:
  - array
  - markup
title: UL
related_entries:
  - fbdb7bf5-ac19-444c-9536-57332ffff388
  - 327f4a3b-04d4-4069-881a-fe50ddb9be23
---
Turn an array into an HTML unordered list element.

:::hot tip
`ul` accepts colon delimited key:value pairs to pass HTML attributes to the `<ul>` element; you cannot pass attributes to individual `<li>` elements.

```antlers
{{ food | ul('class:style-circle', 'disabled:') }}
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
{{ food | ul }}
```
::tab blade
```blade
{!! Statamic::modify($food)->ul() !!}
```
::

```html
<ul>
  <li>sushi</li>
  <li>broccoli</li>
  <li>kale</li>
</ul>
```
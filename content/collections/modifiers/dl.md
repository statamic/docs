---
id: fbdb7bf5-ac19-444c-9536-57332ffff388
blueprint: modifiers
modifier_types:
  - array
  - markup
title: DL
related_entries:
  - 327f4a3b-04d4-4069-881a-fe50ddb9be23
  - 85910466-876b-4fc7-9dd1-c9baa7f7870a
---
Turn a key/value array, otherwise known as a YAML mapping, into an HTML definition list.

:::hot tip
`dl` accepts colon delimited key:value pairs to pass attributes to the `<dl>` element; you cannot pass attributes to the `<dt>`or `<dd>`> elements.

```antlers
{{ food | dl('class:green', 'disabled:') }}
```
:::

```yaml
food:
  Delicious:
    - bacon
    - sushi
  Green:
    - broccoli
    - kale
```

::tabs

::tab antlers
```antlers
{{ food | dl }}
```
::tab blade
```blade
{!! Statamic::modify($food)->dl() !!}
```
::

```html
<dl>
  <dt>Delicious</dt>
  <dd>bacon</dd>
  <dd>sushi</dd>

  <dt>Green</dt>
  <dd>broccoli</dd>
  <dd>kale</dd>
</dl>
```
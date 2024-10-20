---
id: 85910466-876b-4fc7-9dd1-c9baa7f7870a
blueprint: modifiers
modifier_types:
  - array
  - markup
title: UL
---
Turn an array into an HTML unordered list element.

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

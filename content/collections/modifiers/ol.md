---
id: 327f4a3b-04d4-4069-881a-fe50ddb9be23
blueprint: modifiers
modifier_types:
  - array
  - markup
title: OL
---
Turn an array into an HTML ordered list element.

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

---
id: fe6dbf39-7870-4aa4-9acb-23b4cbf4bf87
blueprint: modifiers
modifier_types:
  - string
title: Camelize
---
Returns a camelCase version of a string. Trims surrounding spaces, capitalizes letters following digits, spaces, dashes and underscores, and removes spaces, dashes and underscores. It's a programmer-type thing, great for converting between code styles.

```yaml
method: make_everything_better
```

::tabs

::tab antlers
```antlers
{{ method | camelize }}
```
::tab blade
```blade
{{ Statamic::modify($method)->camelize() }}
```
::

```html
makeEverythingBetter
```

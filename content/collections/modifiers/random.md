---
id: 48178377-da99-4754-ae9e-d294720cff33
blueprint: modifiers
modifier_types:
  - array
  - utility
title: Random
related_entries:
  - 63acdaa6-9724-4179-b210-ea5d507672e9
---
## Overview
Picks a _single_ random item from an array or collection.

If you are trying to get _multiple_ random items, consider the [shuffle modifier](/modifiers/shuffle).

## Example

### The YAML
```yaml
arr:
  - Soda
  - Pop
  - Coke
```

### The Template

::tabs

::tab antlers
```antlers
{{ arr | random }}
```
::tab blade
```blade
{{ Statamic::modify($arr)->random() }}
```
::

### The Output
```
Soda (maybe)
```

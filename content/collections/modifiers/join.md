---
id: 9dfc5020-3d14-4774-a1f6-d82d051cb964
blueprint: modifiers
modifier_types:
  - string
  - array
  - utility
title: Join
---
Turn an array into a string by gluing together all the data with any specified delimiter. It uses a comma by default.

```yaml
tasks:
  - take a shower
  - brush hair
  - clip toenails
```

::tabs

::tab antlers
```antlers
{{ tasks | join }}
{{ tasks | join(" + ") }} = ready
```
::tab blade
```blade
{{ Statamic::modify($tasks)->join() }}
{{ Statamic::modify($tasks)->join(' + ') }} = ready
```
::

```html
take a shower, brush hair, clip toenails
take a shower + brush hair + clip toenails = ready
```

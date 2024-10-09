---
id: 12de1a6c-e8be-4703-81a3-fc270311bc84
blueprint: modifiers
modifier_types:
  - utility
title: Dump
---
Dump a variable to the browser and see under the hood with data types and array exportation. Definitely just for debugging when in development.

```yaml
food:
  delicious:
    - bacon
    - sushi
```

::tabs

::tab antlers
```antlers
{{ food | dump }}
```
::tab blade
```blade
@dd($food)
```
::

```html
array:2 [▼
  "delicious" => array:2 [▶]
]
```

:::tip
You can also use the [dump tag](/tags/dump) to achieve a similar effect.
:::

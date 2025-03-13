---
id: 985dc29c-fe71-464e-bb83-4f3f2aa455c0
blueprint: modifiers
modifier_types:
  - utility
title: 'Console Log'
---
Debug a variable by dumping its contents to your browser's JavaScript's console via `console.log`.

```yaml
fruit:
  - apples
  - bananas
  - bacon
```

::tabs

::tab antlers
```antlers
{{ fruit | console_log }}
```
::tab blade
```blade
@php(Statamic::modify($fruit)->consoleLog())
```
::

```js
["apples", "banana", "jerky"]
```



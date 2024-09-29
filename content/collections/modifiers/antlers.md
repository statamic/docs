---
id: e3b58c77-0bfc-40da-918f-51a7f65950b8
blueprint: modifiers
modifier_types:
  - string
  - utility
title: Antlers
---
Parses the given value as an Antlers template.

```yaml
title: 'Hello {{ audience }}!'
audience: world
```

::tabs

::tab antlers
```antlers
{{ title | antlers }}
```

::tab blade
```blade
{{ Statamic::modify($title)->antlers() }}
```
::

```
Hello world!
```

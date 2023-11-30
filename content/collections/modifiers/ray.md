---
id: 1bb00dc7-f4b2-4bba-aaf9-45e3a2a19518
blueprint: modifiers
modifier_types:
  - utility
title: Ray
related_entries:
    - 12de1a6c-e8be-4703-81a3-fc270311bc84
    - 985dc29c-fe71-464e-bb83-4f3f2aa455c0
---
Send variable to Spatie's [Ray](https://github.com/spatie/laravel-ray). You can pass a string with a color name as parameter to get it colored in Ray. Note, you need to have the Laravel Ray package installed.

```antlers
{{ your_field | ray }}
{{ your_field | ray('red'} }
```

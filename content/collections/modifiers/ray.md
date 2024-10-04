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
Send a variable to Spatie's [Ray](https://myray.app) app.

You can pass a string with a color name as parameter to get it colored in Ray. Note that you need to have the [spatie/laravel-ray](https://github.com/spatie/laravel-ray) package installed.

::tabs

::tab antlers
```antlers
{{ your_field | ray }}
{{ your_field | ray('red'} }
```
::tab blade
```blade
@php(Statamic::modify($your_field)->ray())
@php(Statamic::modify($your_field)->ray('red'))
```
::

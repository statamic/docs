---
id: d61d8f8c-4e7e-4933-8f34-0cdba2a3ee82
blueprint: variables
types:
  - asset
title: Focus
---
The focal point of the asset, defaulting to center (`50-50`).

::tabs

::tab antlers
```antlers
{{ focus }}
```
::tab blade
```blade
{{ $focus }}
```
::

```html
50-30
```

You may want to use this in CSS with either the [background_position](/modifiers/background_position) modifier, or just by using the [focus_css](/variables/focus_css) variable.

::tabs

::tab antlers
```antlers
background-position: {{ focus | background_position }};
background-position: {{ focus_css }};
```
::tab blade
```blade

background-position: {{ Statamic::modify($focus)->backgroundPosition() }};
background-position: {{ $focus_css }};
```
::

```html
background-position: 50% 30%;
background-position: 50% 30%;
```

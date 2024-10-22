---
id: 9433b8cd-b2e0-4fbf-85bd-85edf317efa4
blueprint: modifiers
modifier_types:
  - array
  - utility
title: Offset
---
Offsets the items returned in an array.

```yaml
playlist:
  - Emancipator
  - Gong Gong
  - Possom Posse
  - Justin Bieber
```

Use with the pipe syntax to continue chaining in a single tag like so:

::tabs

::tab antlers
```antlers
{{ playlist | offset(1) | join }}
```
::tab blade
```blade
{{ Statamic::modify($playlist)->offset(1)->join() }}
```
::

```html
Gong Gong, Possom Posse, Justin Bieber
```

Or using the parameter syntax:

::tabs

::tab antlers
```antlers
{{ playlist | offset(1) }}
    <li>{{ value }}</li>
{{ /playlist }}
```

::tab blade

```blade
@foreach (Statamic::modify($playlist)->offset(1)->fetch() as $value)
    <li>{{ $valuie }}</li>
@endforeach
```
::

```html
<li>Gong Gong</li>
<li>Possom Posse</li>
<li>Justin Bieber</li>
```

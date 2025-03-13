---
id: a3c9e1c5-10ec-44da-b8d8-fdc603fce5a3
blueprint: modifiers
modifier_types:
  - array
  - utility
title: Limit
---
Limits the number of items returned in an array.

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
{{ playlist | limit(2) | join }}
```
::tab blade
```blade
{{ Statamic::modify($playlist)->limit(2)->join() }}
```
::

```html
Emancipator, Gong Gong
```

Or using the parameter syntax:

::tabs

::tab antlers
```antlers
{{ playlist | limit(2) }}
    <li>{{ value }}</li>
{{ /playlist }}
```
::tab blade
```blade
<?php
  $limitedPlaylist = Statamic::modify($playlist)->limit(2);
?>

@foreach ($limitedPlaylist as $item)
  <li>{{ $item }}</li>
@endforeach
```
::

```html
<li>Emancipator</li>
<li>Gong Gong</li>
```

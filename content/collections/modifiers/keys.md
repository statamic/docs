---
id: 9197be05-5e2d-400f-a0f0-c52a4d460e60
blueprint: modifiers
title: Keys
modifier_types:
  - array
  - utility
---
Retrieves just the keys from the given array.

```yaml
the_team:
    jack: Jack McDade
    jason: Jason Varga
    jesse: Jesse Leite
    joshua: Joshua Blum
    duncan: Duncan McClean
```

::tabs

::tab antlers
```antlers
{{ the_team | keys }}
```
::tab blade
```blade
<?php
    $keys = Statamic::modify($the_team)->keys()->fetch();
?>
```
::

```yaml
- jack
- jason
- jesse
- joshua
- duncan
```

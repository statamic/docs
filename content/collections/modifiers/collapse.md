---
id: ea17da24-79b9-4ac7-84ba-660b29f95899
blueprint: modifiers
modifier_types:
  - array
  - utility
title: Collapse
---
Collapses an array of arrays into a flat array. Duplicate string keys are overwritten; numeric keys are reindexed.

```yaml
numbers:
  - [one, two, three]
  - [four, five, six]
```

::tabs

::tab antlers
```antlers
{{ numbers | collapse }}
```
::tab blade
```blade
<?php
  $collapsed = Statamic::modify($numbers)->collapse()->fetch();
?>
```
::

```yaml
numbers:
  - one
  - two
  - three
  - four
  - five
  - six
```

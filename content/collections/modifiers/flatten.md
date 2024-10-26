---
id: e893345c-03f7-466b-a400-bbd2545bd780
blueprint: modifiers
modifier_types:
  - array
  - utility
title: Flatten
---
Flattens a multi-dimensional array (a Grid or Replicator field for example) into a single dimension.

```yaml
ingredients:
  spices: [garlic, cumin, ginger, turmeric, paprika, curry powder]
  vegetables: [tomatoes, onion]
  meat: [chicken]
```

::tabs

::tab antlers
```antlers
{{ ingredients | flatten }}
```
::tab blade
```blade
<?php
  $flattened = Statamic::modify($ingredients)
    ->flatten()
    ->fetch();
?>
```
::

```yaml
ingredients:
  - garlic
  - cumin
  - ginger
  - turmeric
  - paprika
  - curry powder
  - tomatoes
  - onion
  - chicken
```

You can optionally pass a `depth` parameter to the `flatten` modifier, allowing you to specify how deeply nested arrays should be flattened.

```yaml
-
  - garlic
  - cumin
  - ginger
  - turmeric
  - paprika
  - curry powder
-
  - tomatoes
  - onion
-
  - chicken
```

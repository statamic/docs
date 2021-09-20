---
id: fbdb7bf5-ac19-444c-9536-57332ffff388
blueprint: modifiers
modifier_types:
  - array
  - markup
title: DL
---
Turn a key/value array, otherwise known as a YAML mapping, into an HTML definition list.

```.language-yaml
food:
  Delicious:
    - bacon
    - sushi
  Green:
    - broccoli
    - kale
```

```
{{ food | dl }}
```

```.language-output
<dl>
  <dt>Delicious</dt>
  <dd>bacon</dd>
  <dd>sushi</dd>

  <dt>Green</dt>
  <dd>broccoli</dd>
  <dd>kale</dd>
</dl>
```

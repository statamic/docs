---
id: 26bf98af-5bc1-4ec9-b533-815872606e3b
blueprint: modifiers
modifier_types:
  - date
  - conditions
title: 'Is Future'
---
Returns `true` if date is in the future.

```.language-yaml
date: October 21 2015
another_date: November 2019
```

```
{{ if date | is_future }}
{{ if another_date | is_future }}
```

```.language-output
false
true
```

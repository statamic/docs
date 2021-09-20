---
id: 985dc29c-fe71-464e-bb83-4f3f2aa455c0
blueprint: modifiers
modifier_types:
  - utility
title: 'Console Log'
---
Debug a variable by dumping its contents to your browser's JavaScript's console via `console.log`.

```.language-yaml
fruit:
  - apples
  - bananas
  - bacon
```

```
{{ fruit | console_log }}
```

```.language-javascript
["apples", "banana", "jerky"]
```



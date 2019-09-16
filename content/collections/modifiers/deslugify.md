---
types:
  - string
id: 826517cc-7273-4045-bca2-fe5825fd9bda
---
Replaces all hyphens and underscores in a string with spaces. The opposite of [dashify](#dashify).

```.language-yaml
title: Just-Because-I-Can
```

```
{{ title | deslugify }}
```

```.language-output
Just Because I Can
```

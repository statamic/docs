---
id: 826517cc-7273-4045-bca2-fe5825fd9bda
blueprint: modifiers
modifier_types:
  - string
title: Deslugify
---
Replaces all hyphens and underscores in a string with spaces. The opposite of [dashify](dashify).

```yaml
title: Just-Because-I-Can
```

```
{{ title | deslugify }}
```

```html
Just Because I Can
```

---
id: 71feed11-dcb7-4405-8f50-a17cb4c021ef
blueprint: modifiers
modifier_types:
  - string
  - utility
title: 'Remove Left'
---
Ensures that the string never begins with a specified string.

```yaml
twitter: @statamic
```

```
<a href="http://twitter.com/{{ twitter | remove_left('@') }}">Twitter</a>
```

```html
<a href="http://twitter.com/statamic">Twitter</a>
```

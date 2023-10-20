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

```
{{ playlist | limit(2) | join }}
```

```html
Emancipator, Gong Gong
```

Or using the parameter syntax:

```
{{ playlist | limit(2) }}
    <li>{{ value }}</li>
{{ /playlist }}
```

```html
<li>Emancipator</li>
<li>Gong Gong</li>
```

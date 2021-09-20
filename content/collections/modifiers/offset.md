---
id: 9433b8cd-b2e0-4fbf-85bd-85edf317efa4
blueprint: modifiers
modifier_types:
  - array
  - utility
title: Offset
---
Offsets the items returned in an array.

```.language-yaml
playlist:
  - Emancipator
  - Gong Gong
  - Possom Posse
  - Justin Bieber
```

Use with the pipe syntax to continue chaining in a single tag like so:

```
{{ playlist | offset:1 | join }}
```

```.language-output
Gong Gong, Possom Posse, Justin Bieber
```

Or using the parameter syntax:

```
{{ playlist offset="1" }}
    <li>{{ value }}</li>
{{ /playlist }}
```

```.language-output
<li>Gong Gong</li>
<li>Possom Posse</li>
<li>Justin Bieber</li>
```

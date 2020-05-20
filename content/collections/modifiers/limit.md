---
modifier_types:
  - array
  - utility
id: a3c9e1c5-10ec-44da-b8d8-fdc603fce5a3
---
Limits the number of items returned in an array.

```.language-yaml
playlist:
  - Emancipator
  - Gong Gong
  - Possom Posse
  - Justin Bieber
```

Use with the pipe syntax to continue chaining in a single tag like so:

```
{{ playlist | limit:2 | join }}
```

```.language-output
Emancipator, Gong Gong
```

Or using the parameter syntax:

```
{{ playlist limit="2" }}
    <li>{{ value }}</li>
{{ /playlist }}
```

```.language-output
<li>Emancipator</li>
<li>Gong Gong</li>
```

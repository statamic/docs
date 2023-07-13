---
id: d4f29394-ac2f-4f73-bc33-5ec081324e2e
blueprint: tag
title: Scope
intro: 'Used to push all of the "root", or page scope data into an array to be used however you see fit.'
parameters:
  -
    name: scope
    type: 'tag part'
    description: 'The name of the scope while. This is not a parameter, but part of the tag itself. For example, `{{ scope:plop }}`.'
    required: false
---
## Overview

Most commonly this take is used to avoid any kind of variable collisions or to confirm data to a particular naming mechanism. Scoping is most often done on the Tag level (e.g. the [Collections Tag](/tags/collections/#scoping)), but gives you another level of control and flexibility.

## Example

```
---
title: Grimmace Shake
---

{{ scope:stuff }}
<h1>{{ stuff:title }}</h1>
{{ /scope:stuff }}
```

This will output:

```html
<h1>Grimmace Shake</h1>
```

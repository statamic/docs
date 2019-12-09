---
title: User:Can
description: Checks if a user has a specific permission
parameters:
  -
    name: permission|do
    type: string
    description: >
      The permission(s) to check against. You
      may specify multiple permissions by pipe
      separating them. eg. `{{ user:can permission="foo" }}` or `{{ user:can do="foo|bar" }}`
id: 649f1eb3-cd60-46ec-ba07-38e2a4747952
---
## Example {#example}

We want to show a link to the control panel if the user has the `cp:access` permission.

```
{{ user:can permission="cp:access" }}
    <a href="/cp">Control Panel</a>
{{ /user:can }}
```

If the user doesn't have the permission, the content between the tags simply won't be rendered.

A shorthand syntax is also available, however this only allows checking against a single permission:

```
{{ can:cp:access }}
    <a href="/cp">Control Panel</a>
{{ /can:cp:access }}
```

### Can’t

We also support the inverse using `{{ user:cant }}` tags.

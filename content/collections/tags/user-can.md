---
title: User:Can
description: Checks if a user has a specific permission
parameters:
  -
    name: permission|do
    type: string
    description: >
      The permission(s) to check against. You may specify multiple permissions by pipe separating them. eg. `{{ user:can permission="foo" }}` or `{{ user:can do="foo|bar" }}`
id: 649f1eb3-cd60-46ec-ba07-38e2a4747952
---
## Example

We want to show a link to the control panel if the user has the `access cp` permission.

```
{{ user:can do="access cp" }}
    <a href="{{ edit_url }}">Edit this Page</a>
{{ /user:can }}
```

Anything inside the tag will only be rendered if the user has the specified permission.

### Can’t

We also support the negative use case using `{{ user:cant }}` tags.

```
{{ user:cant do="anything" }}
  <p>Aww, I'm sure that's not true! 😊</p>
{{ /user:cant }}
```

## Permissions List

Go check out the the complete [list of user permissions](/users#permissions).

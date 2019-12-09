---
title: User:Is
description: Checks if a user has a specific role
parameters:
  -
    name: role|roles
    type: string
    description: 'The role(s) to check against. You may specify multiple roles by pipe separating them. eg. `{{ user:is role="foo" }}` or `{{ user:is roles="foo|bar" }}`.'
id: 8c7f38bb-ee6f-43ee-b775-4eeae0a87bf3
---
## Example {#example}

We want to show a picture of delicious bacon if the user is a `bacon_enthusiast`.

```
{{ user:is role="bacon_enthusiast" }}
    <img src="delicious-bacon.jpg" />
{{ /user:is }}
```

If the user isn't assigned to the `bacon_enthusiast` role, the content between the tags simply won't be rendered.

A shorthand syntax is also available, however this only allows checking against a single role:

```
{{ is:bacon_enthusiast }}
    <img src="delicious-bacon.jpg" />
{{ /is:bacon_enthusiast }}
```

### Isn't

We also support the inverse using `{{ user:isnt }}` tags.

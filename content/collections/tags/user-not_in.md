---
title: User:Not_In
description: Checks if a user is _not_ in a specific user group
parameters:
  -
    name: group|groups
    type: string
    description: 'The groups(s) to check against. You may specify multiple groups by pipe separating them. eg. `{{ user:not_in group="foo" }}` or `{{ user:not_in groups="foo|bar" }}`'
id: 4758a5ba-4b74-4031-8af7-6d165b1624d4
---
## Example {#example}

We want to show a picture of delicious bacon if the user is not in the `vegans` group.

```
{{ user:not_in group="vegans" }}
    <img src="delicious-bacon.jpg" />
{{ /user:not_in }}
```

If the user is in the `vegans` group, the content between the tags simply won't be rendered.

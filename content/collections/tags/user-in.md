---
title: In (Group)
description: Checks if a user is in a specific user group
parameters:
  -
    name: group|groups
    type: string
    description: 'The groups(s) to check against. You may specify multiple groups by pipe separating them. eg. `{{ user:in group="foo" }}` or `{{ user:in groups="foo|bar" }}`'
id: 57184c18-28d3-433f-b6ee-0e4539f6b504
---
## Example {#example}

We want to show a picture of delicious bacon if the user is in the `bacon_enthusiasts` group.

```
{{ user:in group="bacon_enthusiasts" }}
    <img src="delicious-bacon.jpg" />
{{ /user:in }}
```

If the user isn't in the `bacon_enthusiasts` group, the content between the tags simply won't be rendered.

A shorthand syntax is also available, however this only allows checking against a single group:

```
{{ in:bacon_enthusiasts }}
    <img src="delicious-bacon.jpg" />
{{ /in:bacon_enthusiasts }}
```

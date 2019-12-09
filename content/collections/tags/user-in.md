---
title: User:In
description: Checks if a user is in a specific user group
intro: Anything inside the `user:in` tag will only be rendered if the user is in the specified group.
parameters:
  -
    name: group|groups
    type: string
    description: |
      The groups or groups to check against. You may specify multiple groups by pipe separating them: `{{ user:in groups="jocks|geeks" }}`.
id: 57184c18-28d3-433f-b6ee-0e4539f6b504
---
## Overview
User tags are designed for sites that have areas or features behind a login. The `{{ user:in }}` tag is used to check if the currently logged in user is in a specific user group.

## Example


Let's say we want show a list of downloadable PDFs if the user is in a `coaches` group.

```
{{ user:in group="coaches" }}
<ul>
  {{ assets in="pdf" }}
    <li><a href="{{ url }}">{{ title }}</a></li>
  {{ /assets }}
</ul>
{{ /user:in }}
```

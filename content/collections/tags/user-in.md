---
title: User:In
description: Checks if a user is in a specific user group
intro: Anything inside the `user:in` tag will only be rendered if the user is in the specified group.
parameters:
  -
    name: group|groups
    type: string
    description: |
      The group or groups to filter by. You may specify multiple groups by pipe separating them: `{{ user:in groups="jocks|geeks" }}`.
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

## Not In

We also support the negative use case using the `{{ user:not_in }}` tag.

```
{{ user:not_in group="coaches" }}
  <p>Hello, sportsball players!</p>
{{ /user:not_in }}
```

## Super Users

While [super users](/users#super-users) have [permission](/users#permissions) to do everything, they are not automatically in all groups. Keep this in mind when testing your template logic.

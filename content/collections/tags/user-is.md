---
title: User:Is
description: Checks if a user has a specific role
intro: Anything inside the `user:is` tag will only be rendered if the user is has a specific role.
parameters:
  -
    name: role|roles
    type: string
    description: 'The role(s) to check against. You may specify multiple roles by pipe separating them: `{{ user:is roles="writer|editor" }}`.'
id: 8c7f38bb-ee6f-43ee-b775-4eeae0a87bf3
---
## Overview

User tags are designed for sites that have areas or features behind a login. The `{{ user:is }}` tag is used to check if the currently logged in user has a one or more specific [roles](/users#permissions).

## Example

We want to show some content on a page especially for `authors`.

```
{{ user:is role="author" }}
<div class="markdown">
    {{ content }}
</div>
{{ /user:is }}
```

### Isn't

We also support the negative use case using `{{ user:isnt }}` tags.

```
{{ user:isnt role="author" }}
    <a href="/apply">Apply to be an author!</a>
{{ /user:isnt }}
```

## Super Users

While [super users](/users#super-users) have [permission](/users#permissions) to do everything, they do not automatically inherit all roles. Keep this in mind when testing your template logic.

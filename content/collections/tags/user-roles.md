---
id: 878f0dd7-2d31-479c-b58d-bc60685fa7e3
blueprint: tag
title: User_Roles
description: 'Fetch, and iterate over Users Roled and their data.'
intro: 'The `user_roles` tag is used to return any roles you have added to collate the users on your site.'
parameters:
  -
    name: handle
    type: string
    description: 'The handle(s) of the roles you want to return. You may specify multiple roles by pipe separating them: `{{ user_roles handle="jocks|geeks" }}`.'
    required: false
variables:
  -
    name: handle
    type: string
    description: The role's unique identifier.
  -
    name: title
    type: string
    description: The role's display title.
---
## Overview

The User Roles tag fetches lists of the user roles on your site so you can do whatever you want with them.

A simple example is to loop through all the roles and list them by handle:

::tabs

::tab antlers
```antlers
<ul>
{{ user_roles }}
    <li>{{ handle }}</li>
{{ /user_roles }}
</ul>
```
::tab blade
```blade
<ul>
<s:user_roles>
  <li>{{ $handle }}</li>
</s:user_roles>
</ul>

{{-- Aliasing the roles. --}}
<s:user_roles
  as="roles"
>
  ...

  @foreach ($roles as $role)
    ...
  @endforeach

  ...
</s:user_roles>
```
::

## Filtering

If you only want a specific role or roles, you can pass their handle(s) using the `handle` parameter.

::tabs

::tab antlers
```antlers
{{ user_roles handle="group_1|group_2" }}
  // cool stuff goes here
{{ /user_roles }}
```
::tab blade
```blade
<s:user_roles
  handle="group_1|group_2"
>
  // cool stuff goes here
</s:user_roles>
```
::

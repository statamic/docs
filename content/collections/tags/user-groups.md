---
id: 878f0dd7-2d31-479c-b58d-bc60685fa7d3
blueprint: tag
title: User_Groups
description: 'Fetch and iterate over User Groups and their data.'
intro: 'The `user_groups` tag is used to return any groups you have added to collate the users on your site.'
parameters:
  -
    name: handle
    type: string
    description: 'The handle(s) of the groups you want to return. You may specify multiple groups by pipe separating them: `{{ user_groups handle="jocks|geeks" }}`.'
    required: false
variables:
  -
    name: handle
    type: string
    description: The group's unique identifier.
  -
    name: title
    type: string
    description: The group's display title.
---
## Overview

The User Groups tag fetches lists of the user groups on your site so you can do whatever you want with them.

A simple example is to loop through all the groups and list them by handle:


::tabs

::tab antlers
```antlers
<ul>
{{ user_groups }}
    <li>{{ handle }}</li>
{{ /user_groups }}
</ul>
```
::tab blade
```blade
<ul>
<s:user_groups>
  <li>{{ $handle }}</li>
</s:user_groups>
</ul>

{{-- Aliasing the groups. --}}
<s:user_groups
  as="groups"
>
  ...

  @foreach ($groups as $group)
    ...
  @endforeach

  ...
</s:user_groups>
```
::

## Filtering

If you only want a specific group or groups, you can pass their handle(s) using the `handle` parameter.

::tabs

::tab antlers
```antlers
{{ user_groups handle="group_1|group_2" }}
  // cool stuff goes here
{{ /user_groups }}
```
::tab blade
```blade
<s:user_groups
  handle="group_1|group_2"
>
  // cool stuff goes here
</s:user_groups>
```
::

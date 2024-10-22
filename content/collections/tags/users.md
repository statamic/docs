---
id: 878f0dd7-2d31-479c-b58d-bc60685fa7d2
blueprint: tag
title: Users
description: 'Fetch, filter, and iterate over Users and their data.'
intro: 'The users tag can be used to fetch, filter, and iterate over Users and their data.'
parameters:
  -
    name: group
    type: string
    description: 'The user group or groups to filter by. You may specify multiple groups by pipe separating them: `{{ users group="jocks|geeks" }}`.'
  -
    name: role
    type: string
    description: 'The role or roles to filter by. You may specify multiple roles by pipe separating them: `{{ users role="author|editor" }}`.'
  -
    name: sort
    type: string
    description: 'Sort users by field name (or `random`). You may pipe-separate multiple fields for sub-sorting and specify sort direction of each field using a colon. For example, `sort="title"` or `sort="date:asc|title:desc"` to sort by date then by title.'
    required: false
  -
    name: limit
    type: integer
    description: 'Limit the total results returned.'
    required: false
  -
    name: filter|query_scope
    type: string
    description: 'Apply a custom [query scope](/extending/query-scopes-and-filters)'
    required: false
  -
    name: offset
    type: integer
    description: 'Skip a specified number of results.'
    required: false
  -
    name: as
    type: string
    description: 'Alias your entries into a new variable loop.'
    required: false
  -
    name: scope
    type: string
    description: 'Scope your entries with a variable prefix.'
    required: false
variables:
  -
    name: first
    type: boolean
    description: 'Is this the first item in the loop?'
  -
    name: last
    type: boolean
    description: 'Is this the last item in the loop?'
  -
    name: count
    type: integer
    description: 'The number/index of current iteration in the loop, starting from 1'
  -
    name: index
    type: integer
    description: 'The number/index of current iteration in the loop, starting from 0'
  -
    name: no_results
    type: boolean
    description: 'Returns true if there are no results.'
  -
    name: total_results
    type: integer
    description: 'The total number of results in the loop when there are results. You should use `no_results` to check if any results exist.'
  -
    name: 'user data'
    type: mixed
    description: 'Each result has access to all the variables inside that entry (`name`, `email`, etc).'
---
## Overview

The Users tag works very much like the [Collection Tag](/tags/collection). It fetches, filters, sorts, groups, and manipulates lists of your users so you can do whatever you want with them.

A simple example is to loop through all the users and list them by name:


::tabs

::tab antlers
```antlers
<ul>
{{ users }}
    <li>{{ name }}</li>
{{ /users }}
</ul>
```
::tab blade
```blade
<ul>
<s:users>
  <li>{{ $name }}</li>
</s:users>
</ul>
```
::

## Filtering

You can filter you users by group, role, field, or even custom filter class if you need extra control.

### Conditions

Want to avoid listing users who have the words "hipster" and "coffee" in their bio?

::tabs

::tab antlers
```antlers
{{ users bio:doesnt_contain="hipster" bio:doesnt_contain="coffee" }}
```
::tab blade
```blade
<s:users
  bio:doesnt_contain="hipster"
  bio:doesnt_contain="coffee"
>
  ...
</s:users>
```
::

There are a whole pile of conditions available to you, like `:is`, `:isnt`, `:contains`, `:starts_with`, and `:is_before`. Check out this page [dedicated to conditions](/conditions).

### Custom Query Scopes

Doing something custom or complicated? You can create [query scopes](/extending/query-scopes-and-filters) to narrow down those results with the `query_scope` or `filter` parameter:

::tabs

::tab antlers
```antlers
{{ users query_scope="your_query_scope" }}
```
::tab blade
```blade
<s:users
  query_scope="your_query_scope"
>
  ...
</s:users>
```
::

### Examples

#### Only super users

::tabs

::tab antlers
```antlers
{{ users super:is="true" }}
  // these people are powerful
{{ /users }}
```
::tab blade
```blade
<s:users
  super:is="true"
>
  // these people are powerful
</s:users>
```
::

#### Exclude users with gmail email address

::tabs

::tab antlers
```antlers
{{ users email:doesnt_end_with="@gmail.com" }}
  // cool stuff goes here
{{ /users }}
```
::tab blade
```blade
<s:users
  email:doesnt_end_with="@gmail.com"
>
  // cool stuff goes here
</s:users>
```
::


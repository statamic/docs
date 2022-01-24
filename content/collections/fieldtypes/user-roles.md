---
id: 42baf054-f3d5-4317-b7dd-466882c47c06
blueprint: fieldtype
title: 'User Roles'
screenshot: fieldtypes/screenshots/user-roles.png
description: 'Create a relationship with a User Role'
overview: |
  Use this fieldtype to create a relationship with [User Roles](/users#user-roles).
pro: true
options:
  -
    name: max_items
    type: integer
    required: false
    description: 'The maximum number of user roles that may be selected.'
  -
    name: mode
    type: string
    description: |
      Set the UI style for this field. Can be one of `default` (Stack Selector), `select` (Select Dropdown) or `typeahead` (Typeahead Field).
related_entries:
  - 6b691e04-8f28-4eb2-8288-b61433883fe4
  - 8c7f38bb-ee6f-43ee-b775-4eeae0a87bf3
---
## Overview

The User Role fieldtype is gives your users a way to pick one or more User Groups to attach to the current entry. What you do with that relationship is up to you, but most likely you'll be either listing users or combining it with the [User:Is](/tags/user-is) tag to protect content or areas of the frontend.

## Data Storage

The User Role fieldtype stores the `handle` of a single group as a string, or an array of handles if `max_items` is greater than 1.

## Templating

The User Role fieldtype uses [augmentation](/augmentation) to return the `title` and `handle` of each Role. You can use pass these values into the `{{ user:is }}` tag to protect content.

```
{{ user:is :role="role_field:handle" }}
  You are a {{ role_field:title }}. Nice!
{{ /user:is }}
```

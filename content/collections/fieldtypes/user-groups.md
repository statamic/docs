---
id: 006ee3c1-607e-4d65-94ae-6862c18ac516
title: User Groups
screenshot: fieldtypes/screenshots/user-groups.png
description: Create a relationship with a User Group
overview: >
  Use this fieldtype to create a relationship with [User Groups](/users#user-groups).
pro: true
options:
  -
    name: max_items
    type: integer
    required: false
    description: 'The maximum number of user groups that may be selected.'
  -
    name: mode
    type: string
    description: |
        Set the UI style for this field. Can be one of `default` (Stack Selector), `select` (Select Dropdown) or `typeahead` (Typeahead Field).
related_entries:
  - 57184c18-28d3-433f-b6ee-0e4539f6b504
  - 6b691e04-8f28-4eb2-8288-b61433883fe4
---
## Overview

The User Group fieldtype is gives your users a way to pick one or more User Groups to attach to the current entry. What you do with that relationship is up to you, but most likely you'll be either listing users or combining it with the [User:In](/tags/user-in) tag to protect content or areas of the frontend.

## Data Storage

The User Group fieldtype stores the `handle` of a single group as a string, or an array of handles if `max_items` is greater than 1.

## Templating

The User Group fieldtype uses [augmentation](/augmentation) to return the `title` and `handle` of each Group. You can use pass these values into the `{{ user:in }}` tag to protect content.

```
{{ user:in :group="group_field:handle" }}
  You are in the {{ group_field:title }} group. Nice!
{{ /user:in }}
```

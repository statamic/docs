---
title: Users
description: Dynamically relate users with your content.
intro: >
  Allows you attach users to your content. This can be used to show authorship, list team members, or whatever other use you have for relating people with content.
screenshot: fieldtypes/users.png
options:
  -
    name: max_items
    type: integer
    description: >
      The maximum number of users than can be selected. By default (blank) there is no limit. Setting to `1` will save the value as a `string` instead of an `array` and will switch to a select dropdown UI.
  -
    name: mode
    type: string
    description: >
      Choose between `select`, `typeahead`, and the `default` stack selector UI modes.
stage: 4
id: 0f8102b9-c948-4264-8cb8-cbfbd0415a04
---
## Overview

The most common use for the Users fieldtype is to manage the "author" for entries, but it's hardly the only case. You could...

- List people who contributed to a project
- Link to related authors
- Manage an "Employee of the Weekend" section. Everyone wants to be the King or Queen of Inventory Saturday.
- Display team bios

## Data Structure

The Users fieldtype is a [relationship fieldtype](/fieldtypes/relationship) – which mean the data will store a reference to the users IDs to main a dynamic link.

``` .language-yaml
author: abc-123-cba-321
```

## Templating

All relationship fields use [augmentation](/augmentation) to fetch the actual data objects, allowing you to interact with the related data automatically and dynamically.

```
<div class="bg-white p-4 shadow flex items-center">
{{ author }}
  <img class="w-10 h-10 rounded-full" src="{{ avatar }}" alt="Avatar of {{ name }}">
    <div class="text-sm ml-4">
      <p class="text-gray-900 leading-none">{{ name }}</p>
      <p class="text-gray-600">{{ email }}</p>
    </div>
{{ /author }}
</div>
```

``` output
<div class="bg-white p-4 shadow flex items-center">
  <img class="w-10 h-10 rounded-full" src="/img/avatars/david.jpg" alt="Avatar of David Hasselhoff">
    <div class="text-sm ml-4">
      <p class="text-gray-900 leading-none">David Hasselhoff</p>
      <p class="text-gray-600">thehoff@statamic.com</p>
    </div>
</div>
```

## Config Options

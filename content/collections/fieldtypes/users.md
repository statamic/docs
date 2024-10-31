---
title: Users
description: Relate users with your content.
intro: >
  Attach users to your content to show authorship, list team members, assign the winners of a foot race, or even winners of an elbow race.
screenshot: fieldtypes/screenshots/users.png
options:
  -
    name: default
    type: string
    description: >
      Setting to `current` will default the field to the currently logged in user.
  -
    name: max_items
    type: integer
    description: >
      The maximum number of users than can be selected. Leave it empty for no limit (default). Setting to `1` will save the value as a `string` instead of an `array` and will switch to a select dropdown UI.
  -
    name: mode
    type: string
    description: >
      Choose between `select`, `typeahead`, and the `default` stack selector UI modes.
  -
    name: query_scopes
    type: string
    description: >
      Allows you to specify a [query scope](/extending/query-scopes-and-filters#scopes) which should be applied when retrieving selectable assets. You should specify the query scope's handle, which is usually the name of the class in snake case. For example: `MyAwesomeScope` would be `my_awesome_scope`.
stage: 4
id: 0f8102b9-c948-4264-8cb8-cbfbd0415a04
---
## Overview

The most common use for the Users fieldtype is to set the "author" for entries, but it's not the only use. You could...

- List people who contributed to a project
- Link to related authors
- Manage an "Employee of the Weekend" section. Everyone wants to be the King or Queen of Inventory Saturday, right?
- Display team bios
- Pull in customer's testimonials through their user account.

## Data Structure

The Users fieldtype is a [relationship fieldtype](/extending/relationship-fieldtypes) – which mean the data will store a reference to the users IDs to main a dynamic link.

```yaml
author: abc-123-cba-321
```

## Templating

All relationship fields use [augmentation](/augmentation) to fetch the actual data objects, allowing you to interact with the related data automatically and dynamically.

The following example assumes `max_items` has been set to `1`.

::tabs

::tab antlers
```antlers
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
::tab blade
```blade
<div class="bg-white p-4 shadow flex items-center">
	<img class="w-10 h-10 rounded-full" src="{{ $author->avatar }}" alt="Avatar of {{ $author->name }}">
	<div class="text-sm ml-4">
		<p class="text-gray-900 leading-none">{{ $author->name }}</p>
		<p class="text-gray-600">{{ $author->email }}</p>
	</div>
</div>
```

::

```html
<div class="bg-white p-4 shadow flex items-center">
  <img class="w-10 h-10 rounded-full" src="/img/avatars/david.jpg" alt="Avatar of David Hasselhoff">
    <div class="text-sm ml-4">
      <p class="text-gray-900 leading-none">David Hasselhoff</p>
      <p class="text-gray-600">thehoff@statamic.com</p>
    </div>
</div>
```

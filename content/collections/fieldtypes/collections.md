---
title: Collections
extends: 9dd58c40-6e33-49c8-83fa-61a69f6371be
description: Choose from one or more collections.
overview: Allows you to choose one or more collections.
options:
  -
    name: max_items
    type: integer
    description: >
      The maximum number of items that may be selected. Setting this to `1` will change the UI to a dropdown.
screenshot: /fieldtypes/screenshots/collections.png
id: 44c3da60-ef47-408e-afc4-a33026c86f5d
---
## Usage

This fieldtype is used to view and select from a list of Collections.

```yaml
fields:
  my_collections_field:
    type: collections
```

## Data Structure

The Collections fieldtype is a [Relationship fieldtype](/relationships#fieldtypes), and will save the collections as their handles (the folder name).

```yaml
listings:
  - blog
  - things
```

## Templating

You're more than likely using this field as a way to dynamically display a collection.

::tabs

::tab antlers

Since the collection tag accepts a pipe-delimited list of collection names, you can join them together like this:

```antlers
<ul>
  {{ collection from="{listings|piped}" }}
    <li>{{ title }}</li>
  {{ /collection }}
</ul>
```

::tab blade

You can pass the values from the collections fieldtype to the collection tag like so:

```blade
<ul>
	<statamic:collection
		:from="$listings ?? []"
	>
		<li>{{ $title }}</li>
	</statamic:collection>
</ul>

```

::

```html
<ul>
  <li>A blog entry</li>
  <li>A thing entry</li>
  <li>etc</li>
</ul>
```

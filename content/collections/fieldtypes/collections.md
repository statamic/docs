---
title: Collections
extends: 9dd58c40-6e33-49c8-83fa-61a69f6371be
description: Choose from one or more collections.
overview: Allows you to choose one or more collections.
options:
  -
    name: collection
    type: string/array
    description: >
      You can pass a single collection as a string or multiple collections as an array.
image: /assets/fieldtypes/collections.png
video: https://youtu.be/TkxvBIGzUr8
id: 44c3da60-ef47-408e-afc4-a33026c86f5d
---
## Usage

This fieldtype is used to view and select from a list of Collections.

```.language-yaml
fields:
  my_collections_field:
    type: collections
```

## Data Structure

The Collections fieldtype is a [Relate fieldtype](/fieldtypes/relate), and will save the collections as their handles (the folder name).

``` .language-yaml
listings:
  - blog
  - things
```

## Templating

You're more than likely using this field as a way to dynamically display a collection.

Since the collection tag accepts a pipe-delimited list of collection names, you can join them together like this:

```
<ul>
  {{ collection from="{listings|piped}" }}
    <li>{{ title }}</li>
  {{ /collection }}
</ul>
```

``` .language-output
<ul>
  <li>A blog entry</li>
  <li>A thing entry</li>
  <li>etc</li>
</ul>
```

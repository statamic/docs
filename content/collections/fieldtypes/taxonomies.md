---
id: 88c9909c-4134-40cd-b095-79ec7207b190
blueprint: fieldtype
title: Taxonomies
description: 'Choose from one or more taxonomies.'
overview: 'Allows you to choose one or more taxonomies.'
options:
  -
    name: max_items
    type: integer
    description: |
      The maximum number of items that may be selected. Setting this to `1` will change the UI to a select dropdwon.
  -
    name: mode
    type: string
    description: |
      Set the UI style for this field. Can be one of 'default' (Stack Selector), 'select' (Select Dropdown) or 'typeahead' (Typeahead Field).
screenshot: /fieldtypes/screenshots/taxonomies.png
related_entries:
  - ba832b71-a567-491c-b1a3-3b3fae214703
  - 6a18eac8-6139-419c-9d64-a2c960ccc3cd
  - 42d2d87c-5af6-4856-9ee0-9548439df772
---
## Usage

This fieldtype is used to view and select from a list of Taxonomies.

```yaml
fields:
  my_taxonomies_field:
    type: taxonomies
```

## Data Structure

The Taxonomies fieldtype is a [Relationship fieldtype](/relationships#fieldtypes), and will save the taxonomies as their handles.

```yaml
taxonomies:
  - genre
  - cool_factor
```

## Templating

You're more than likely using this field as a way to dynamically display Terms from one or more Taxonomies.

```
<ul>
  {{ taxonomy :from="my_taxonomy_field" }}
    <li>{{ title }}</li>
  {{ /taxonomy }}
</ul>
```

```html
<ul>
  <li>Comedy</li>
  <li>Drama</li>
  <li>Dramedy</li>
</ul>
```

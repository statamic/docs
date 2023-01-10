---
id: db0162b1-c58c-4093-841c-b386cc2e5c21
blueprint: fieldtype
title: Sites
screenshot: fieldtypes/screenshots/sites.png
intro: 'Allows you to select one or more sites when running a [multi site](/multi-site).'
options:
  -
    name: max_items
    type: integer
    description: >
      The maximum number of items that may be selected. Setting this to `1` will change the UI to a select dropdwon.
  -
    name: mode
    type: string
    description: |
        Set the UI style for this field. Can be one of 'default' (Stack Selector), 'select' (Select Dropdown) or 'typeahead' (Typeahead Field).
---
## Usage

```yaml
fields:
  my_sites_field:
    type: sites
```

The Sites fieldtype is a [Relationship fieldtype](/relationships#fieldtypes), and will save the site or sites as their handles (the config name).

```yaml
sites:
  - english
  - french
  - german
```

## Templating

You're more than likely using this field as a way to dynamically fetch content from a specific site other than the current one.

```
<ul>
  {{ collection:news :site="my_sites_field" }}
    <li>{{ title }}</li>
  {{ /collection:news }}
</ul>
```

```html
<ul>
  <li>Bonjour!</li>
  <li>Ton tonton tond ton thon</li>
  <li>etc</li>
</ul>
```

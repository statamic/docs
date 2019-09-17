---
title: Pages
overview: Allows you attach other Pages to your content.
image: /assets/fieldtypes/pages.png
options:
  -
    name: parent
    type: string
    description: The URL or ID of a page if you want to only show its children.
  -
    name: depth
    type: integer
    description: The level of child pages to traverse when using the `parent` option.
extends: 9dd58c40-6e33-49c8-83fa-61a69f6371be
video: https://youtu.be/TkxvBIGzUr8
id: db75755f-f1b8-4281-8995-2723dd92d967
---
## Usage

This fieldtype is used to view a list of Pages and select one or more of them. You can choose a parent to start from, listing only its child pages. You can also control the depth it will include in your list (e.g. subpage, sub-subpages, etc).

```.language-yaml
fields:
  my_pages_field:
    display: Link to Page
    type: pages
```

## Data Structure

The Pages fieldtype is a [Relate fieldtype](/fieldtypes/relate), which means the data will be saved as content IDs.

``` .language-yaml
pages:
  - 892jfsd9a90as
  - 134jk1h78dfas
```

## Templating {#templating}

Use the [Relate tag](/tags/relate) to loop through the IDs and fetch the content data.

```
<ul>
  {{ relate:pages }}
    <li>{{ title }}</li>
  {{ /relate:pages }}
</ul>
```

``` .language-output
<ul>
  <li>How to Basic</li>
  <li>How to Extreme</li>
</ul>
```

---
title: Link
description: 'Create links to URLs, entries, or child entries.'
intro: |
  A select box gives you the option to choose what type of link you'd like to create. When set to URL it gives you a text box to enter the hyperlink. When set to Entry it opens a stack with all your entries to choose from. And when set to First Child will redirect a visitor to the first child page in a structure.
screenshot: fieldtypes/link.png
id: 69975d6f-760e-4ce4-a92b-d98e122744a8
options:
  -
    name: collections
    type: array
    description: |
      Configure which collections you want to allow relationships with.
---
## Overview

For when you want to create a link to a URL or entry, this fieldtype is here for you. We often see it used in [Grids](/fieldtypes/grid) and [Replicators](/fieldtypes/replicator).

## Data Storage

``` yaml
---
url_link: 'https://statamic.com'
entry_link: 'entry::9d682ce3-a353-4fdd-af5e-c1d21b7a87f7'
first_child_link: '@child'
```

## First Child

Creating a "first child" link will dynamically return the URL to first entry nested below in a [Structure](/structures) or [Navigation](/navigation).

For example, if you set a First Child link on the Getting Started entry below, it will return the URL to the "Requirements" entry.

<figure>
    <img src="/img/structure.png" alt="A Statamic 3 structure tree" width="535">
</figure>

This option will only be provided when the field is in a collection. Globals and terms, by their nature, don't have children.

## Templating

Link fields will render a URL string you can use however you choose.

```
Check out <a href="{{ url_link }}">Statamic</a>!
```

```output
Check out <a href="https://statamic.com">Statamic</a>!
```

## Config Options

---
title: Navigation
intro: A nav (or navigation for long) is a hierarchy of links and text nodes that are used to build navs and menus on the frontend of your site.
id: 2af9fc45-66d0-4ca5-9761-00017076144f
stage: 4
---
## Overview

Each Nav is a [structure](/structures) giving you the ability to rearrange items through the delightful experience of dragging and dropping boxes.

<figure>
    <img src="/img/structure.png" alt="A Statamic 3 structure page tree" width="535">
</figure>


- You can **reference** entries, enter hardcoded URLs (internal or external), or enter simple text blocks (which can be used as section headers for dropdown navs, for example).
- You can **choose** which collections' entries will available to choose from.
- Any referenced entries will use the URLs **defined by the collection**, regardless of the position in the Structure.
- You can place the same entry **multiple** times. Two times, three times, four times, even six times are all possible numbers of times you can place something.

## Storage

Navs are stored in `content/navigation`. Each gets its own YAML file whose handle matches its filename.

``` files
content/
`-- navigation/
    |-- header.yaml
    `-- footer.yaml
```

``` yaml
title: Footer
max_depth: 3
collections:
  - pages
  - posts
  - documents
tree: [...] # details below
```


## Templating

You can work with the [nav](/tags/nav) to loop through and render your HTML with access to all the entries and nodes in the navigation.

```
<ul>
{{ nav:footer }}
    <li><a href="{{ url }}">{{ title }}</a></li>
{{ /nav:footer }}
</ul>
```

## Collections

Your navigation tree _may_ contain references to entries. The control panel's entry selector will show you entries across all collections by default. You may narrow down which collections will appear in the selector in the config area.

<figure>
    <img src="/img/navigation-collection-picker.png" alt="Configuring navigation collections" width="556" height="170">
    <figcaption>If you want to put pants in your navs, you can.</figcaption>
</figure>

## Localization

When running a [multi-site](/multi-site) installation, you can have a different tree for each nav. Learn more about [localizing navs](/knowledge-base/localizing-navigation).

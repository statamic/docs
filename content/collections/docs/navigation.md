---
title: Navigation
intro: A nav is a hierarchy of links and/or text items that are used to build navigation on the front-end of your site.
id: 2af9fc45-66d0-4ca5-9761-00017076144f
---

<figure>
    <img src="/img/structure.png" alt="A Statamic 3 structure page tree" width="535">
</figure>


Each Nav is a [Structure](/structures) that will allow you to drag and drop items to create a navigation on the front-end of your site.

- You can reference entries, enter hardcoded URLs (internal or external), or enter simple text blocks (that can be used as section headers for dropdown navs, for example).
- You can select which collections' entries will available to choose from.
- Any referenced entries will use the URLs defined by the collection, regardless of the position in the Structure.
- You can place the same entry multiple times.

## File Overview

Navs are stored in `content/navigation`. Each gets its own YAML file and its handle is its filename.

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

You can work with the [nav](/tags/nav) or [structure](/tags/structure) tags (they're the same) to loop through and render your HTML with its links.

```
<ul>
{{ nav:footer }}
    <li><a href="{{ url }}">{{ title }}</a></li>
{{ /nav:footer }}
</ul>
```

## Collections

Your navigation tree may contain references to entries. In the Control Panel, the entry selector will show you entries across 
all collections by default. You may narrow down which collections will appear in the selector by providing an array of collection
handles to the `collections` variable:

``` yaml
collections:
  - pages
  - posts
  - documents
```

## Localization

When running a [multi-site](/multi-site) installation, you can have a different tree for each nav.

For example, entries organized in a different order, or references to entirely different entries.

[Read about localizing navs](/knowledge-base/localizing-navigation)

---
title: Navigation
intro: A nav (or navigation for long) is a hierarchy of links and text nodes that are used to build navs and menus on the frontend of your site.
id: 2af9fc45-66d0-4ca5-9761-00017076144f
blueprint: page
---
## Overview

Each Nav is a [structure](/structures) giving you the ability to rearrange items through the delightful experience of dragging and dropping boxes.

<figure>
    <img src="/img/structure.png" alt="A Statamic 3 structure page tree" width="535">
</figure>


- You can **reference** entries, enter hardcoded URLs (internal or external), or enter simple text blocks (which can be used as section headers for dropdown navs, for example).
- You can **choose** which collections' entries will be available to choose from.
- Any referenced entries will use the URLs **defined by the collection**, regardless of the position in the Structure.
- You can place the same entry **multiple** times. Two times, three times, four times, even six times are all possible numbers of times you can place something.

## Storage

Navs are stored in `content/navigation`. Each gets its own YAML file whose handle matches its filename.

The actual contents of the structure - the "tree" - is stored separately in `content/trees/navigation`.

``` files
content/
|-- navigation/
|   |-- header.yaml
|   `-- footer.yaml
`-- trees/
    |-- header.yaml
    `-- footer.yaml
```

``` yaml
# content/navigation/footer.yaml
title: Footer
max_depth: 3
collections:
  - pages
  - posts
  - documents
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

Within the tag pair, you will have access to any fields defined on that particular nav item - the item itself or the entry. See [blueprints and data](#blueprints-and-data) below for more information.

## Collections

Your navigation tree _may_ contain references to entries. The control panel's entry selector will show you entries across all collections by default. You may narrow down which collections will appear in the selector in the config area.

<figure>
    <img src="/img/navigation-collection-picker.png" alt="Configuring navigation collections" width="556" height="170">
    <figcaption>If you want to put pants in your navs, you can.</figcaption>
</figure>

## Blueprints and Data

Out of the box, nav items are fairly light. If you create a standard nav item, you can type in the URL and title. For entry reference nav items, you can override the title.

If you'd like to add more data, you can add fields to the nav's blueprint.

Any fields you add will appear in the editor pane in the control panel.

<figure>
    <img src="/img/navigation-page-editor.png" alt="Navigation Page Editor" width="448" height="282">
    <figcaption>The excerpt and icon fields have been added</figcaption>
</figure>

The data will be saved in a `data` key on the tree branch.

``` yaml
-
  title: My page
  url: /my-page
  data:
    excerpt: This is my page
    icon: page.svg
```

In the case of entry reference nav items, any fields you add to the nav blueprint will override the fields for that entry. This is useful if you intentionally want to override an entry's value. If you want to do this, make sure that you use the same fieldtype as what's in the entry's blueprint. A good way to handle that is to make a [reusable field](/blueprints#reusable-fields).


## Localization

When running a [multi-site](/multi-site) installation, you can have a different tree for each nav. Learn more about [localizing navs](/knowledge-base/localizing-navigation).

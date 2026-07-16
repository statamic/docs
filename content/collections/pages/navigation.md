---
id: 2af9fc45-66d0-4ca5-9761-00017076144f
blueprint: page
title: Navigation
intro: 'A nav is a freestyle structure for menus — headers, footers, sidebars, the chrome. It composes links; it does not own your URLs.'
related_entries:
  - 3c34ef5c-781e-4a22-a09b-25f58bdb58a8
  - ed746608-87f9-448f-bf57-051da132fef7
  - 485f1703-fc6f-4d0f-94f2-e84ae625e1b7
  - 35c9cd07-f377-4fcb-b02c-72c1925e6fdf
---
## Overview

Need a header, footer, or mega-menu? That's a **nav**. Under the hood it's a [structure](/structures) — same tree UI — but the tree's job is composition, not URL ownership.

Referenced entries keep the URLs defined by their collection. You can mix entry links, hardcoded URLs, and text-only nodes, and you can place the same entry more than once.

Not sure whether you want a nav or a structured collection? Start with [Structures](/structures) — that's the decision page.

<figure>
    <img src="/img/structure.webp" alt="A Statamic navigation tree" class="u-hide-in-dark-mode">
    <img src="/img/structure-dark.webp" alt="A Statamic navigation tree" class="u-hide-in-light-mode">
</figure>

:::watch https://www.youtube.com/embed/POgIsLeWGGQ
Watch how to build a simple nav
:::

## Storage

Navs are stored in `content/navigation`. Each gets its own YAML file whose handle matches its filename.

The tree itself lives separately in `content/trees/navigation`.

``` files theme:serendipity-light
content/
    navigation/
        header.yaml
        footer.yaml
    trees/
        navigation/
            header.yaml
            footer.yaml
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

Loop a nav with the [nav tag](/tags/nav).

::tabs

::tab antlers
```antlers
<ul>
{{ nav:footer }}
    <li><a href="{{ url }}">{{ title }}</a></li>
{{ /nav:footer }}
</ul>
```
::tab blade
```blade
<ul>
  <statamic:nav:footer>
    <li><a href="{{ $url }}">{{ $title }}</a></li>
  </statamic:nav:footer>
</ul>
```
::

Within the tag pair you get fields from that nav item — the branch itself or the referenced entry. See [blueprints and data](#blueprints-and-data) below.

## Collections

Your navigation tree _may_ contain references to entries. The Control Panel's entry selector shows entries across all collections by default. Narrow which collections appear in the nav's config.

<figure>
    <img src="/img/navigation-collection-picker.webp" alt="Configuring navigation collections" class="u-hide-in-dark-mode">
    <img src="/img/navigation-collection-picker-dark.webp" alt="Configuring navigation collections" class="u-hide-in-light-mode">
    <figcaption>If you want to put pants in your navs, you can.</figcaption>
</figure>

## Blueprints and data

Out of the box, nav items are fairly light. Standard items get a URL and title; entry references can override the title.

Want more fields? Add them to the nav's blueprint. They show up in the editor pane.

<figure>
    <img src="/img/navigation-page-editor.png" alt="Navigation Page Editor" width="448" height="282">
    <figcaption>The excerpt and icon fields have been added</figcaption>
</figure>

Data saves under a `data` key on the tree branch.

``` yaml
-
  title: My page
  url: /my-page
  data:
    excerpt: This is my page
    icon: page.svg
```

For entry references, fields on the nav blueprint override the entry's fields for that branch. Useful when you intentionally want a different title/excerpt in the menu. Match the entry's fieldtype — a [reusable field](/blueprints#reusable-fields) is the clean way.

## Localization

On a [multi-site](/multi-site) install you can have a different tree per site. See [localizing navs](/tips/localizing-navigation).

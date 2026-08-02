---
id: 3c34ef5c-781e-4a22-a09b-25f58bdb58a8
blueprint: page
title: Structures
intro: 'A structure is a tree — nested items you rearrange in the Control Panel. That tree either owns a collection’s URLs or powers a freestyle nav. Same shape, two jobs.'
template: page
related_entries:
  - 2af9fc45-66d0-4ca5-9761-00017076144f
  - 7202c698-942a-4dc0-b006-b982784efb03
  - ed746608-87f9-448f-bf57-051da132fef7
  - 47f8c4c4-8268-4375-adc4-b8c4521fbfd9
---
## Overview

Statamic uses **trees** whenever order and nesting matter. A structure is the thing that holds that tree.

Every structure is a hierarchy of branches. What differs is *what the hierarchy is for*:

1. **Structured collections** — the tree *is* the content hierarchy. Nesting and order drive URLs (and sibling order). Your sitemap lives on the collection.
2. **Navigations** — the tree is a menu. Mix entry references, hard URLs, and text nodes. Position in the tree does **not** rewrite entry URLs.

Same drag-and-drop UI. Same YAML tree shape. Different jobs.

<figure>
    <img src="/img/collection-structure.webp" alt="A Statamic structure tree" class="u-hide-in-dark-mode">
    <img src="/img/collection-structure-dark.webp" alt="A Statamic structure tree" class="u-hide-in-light-mode">
    <figcaption>Lovely little tree we have there.</figcaption>
</figure>

## When to use which

**Use a structured collection when:**

- Nesting should mean something in the URL (`/about/team` lives under `/about`)
- An entry should appear only once in the hierarchy
- Rearranging items should change where people land
- You're building a classic pages area — home, about, children, the usual suspects

**Use a navigation when:**

- You're building a header, footer, sidebar, or mega-menu
- The same entry might show up more than once
- You need section labels, external links, or anchor links mixed in
- Menu order should be independent of URL structure

**Use both when** a pages collection owns the URLs and one or more navs compose what appears in chrome. That's normal — not overkill.

| | Structured collection | Navigation |
| --- | --- | --- |
| Owns URLs | Yes — position drives routes | No — entries keep their collection URLs |
| Entry once | Yes | No — can repeat |
| Freeform links / text | Entry-link redirects (via collection settings) | Yes — URLs and text nodes |
| Config lives in | The collection itself | `content/navigation` |
| Tree lives in | `content/trees/collections` | `content/trees/navigation` |

## Structured collections

Turn on **Orderable** on a collection and Statamic wires up a structure under the hood.

- You can only add entries from that collection
- Order and nesting dictate URLs (via `parent_uri` and `depth` on the collection's route)
- You can place an entry only once
- You can create internal and external redirects (when enabled on the collection)
- Max depth, root pages, mounting, and route patterns are collection concerns

Operational details — root page, constraining depth, redirects, mounting — live in [Collections → Ordering](/collections#ordering).

## Navigations

A nav is a freestyle structure for menus and other chrome. It does not own content URLs.

- Reference entries, hardcode URLs (internal or external), or use text-only nodes (section labels for dropdowns, etc.)
- Choose which collections' entries appear in the picker
- Referenced entries keep the URLs defined by their collection, regardless of position in the nav
- The same entry can appear multiple times
- Storage layout, blueprints, and localization are covered in [Navigation](/navigation)

## The tree

The tree is the array that defines the hierarchy. Each item is a "page" branch.

``` yaml
tree:
  -
    entry: id-of-about
    children:
      -
        entry: id-of-hobbies
  -
    entry: id-of-blog
  -
    title: Support
    children:
      -
        entry: id-of-contact
      -
        title: 'GitHub Repo'
        url: 'https://github.com/example/repo'
```

:::tip
You *can* edit a structure in the files. You *shouldn't*, unless you enjoy YAML indentation as a hobby. The Control Panel's drag-and-drop UI is the move.
:::

Each page may have an optional `children` array which is itself another tree. Nest as deep as you need — `max_depth` on the structure caps how far you can go in the Control Panel.

- An **entry** reference uses an `entry` key with the entry's ID (about, hobbies, blog, contact above)
- A **hardcoded link**\* uses a `url` (internal or external). `title` is optional (GitHub above)
- **Text**\* can be just a `title` (Support above)

_\* Text and link branches are only available in navs._

## Templating

Loop either kind of structure with the [nav tag](/tags/nav).

::tabs

::tab antlers
```antlers
<ul>
{{ nav:top_nav }}
    <li><a href="{{ url }}">{{ title }}</a></li>
{{ /nav:top_nav }}
</ul>
```
::tab blade
```blade
<ul>
  <s:nav:top_nav>
    <li><a href="{{ $url }}">{{ $title }}</a></li>
  </s:nav:top_nav>
</ul>
```
::

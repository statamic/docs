---
title: Structures
intro: A structure is a hierarchy of items that are used to build navigation on the front-end of your site and optionally dictate the URL structure for entire collections.
template: page
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1568558416
id: 3c34ef5c-781e-4a22-a09b-25f58bdb58a8
blueprint: page
stage: 1
---

## Overview

Structures are a flexible way to create hierarchies of different items. Statamic 2's "Pages" feature has been replaced by a "Structured Collection" (more on that in a bit).

Each structure is a hierarchy of links and/or titles. These links may be to entries in one or more [collections](/collections), external URLs, or even anchor links in your content.

<figure>
    <img src="/img/structure.png" alt="A Statamic 3 structure page tree" width="535">
    <figcaption>Part of the structure of this very site.</figcaption>
</figure>

## Two Flavors

Structures come in two flavors, unlike Pringles. They can control the discrete URL pattern and order for a collection (like v2's Pages), or manage ad hoc navigation trees. And _just like_ Pringles &mdash; once you pop the top, you can't stop.


## Structured Collections

The first type of structure is for defining the URL structure for a collection. This would be the equivalent of "Pages" in Statamic v2.

- An "orderable" collection will be using a Structure under the hood.
- You will only be able to add entries from that collection.
- The order and arrangement of the entries will dictate their URLs.
- This will make `parent_uri` and `depth` variables available to the Collection's route.
- You can only place an entry once.
- You can create internal and external redirects.
- The structure is stored on the collection itself.

[Read more about using Structures to manage your Collections](/collections#ordering)

## Navigation (or "Navs") {#navigation}

Freestyle navigation structures exist to manage a nav out of entries that already exist, as well as freeform links and text (non-link) elements.

- You can reference entries, enter hardcoded URLs (internal or external), or enter simple text blocks (that can be used as section headers for dropdown navs, for example).
- You can select which collections' entries will available to choose from.
- Any referenced entries will use the URLs defined by the collection, regardless of the position in the Structure.
- You can place the same entry multiple times.
- The structure is stored as a YAML file inside `content/navigation`.

[Read more about Navigation](/navigation)


## Templating

You can work with the [structure tag](/tags/structure) to loop through and render your HTML with its links. For backwards compatibility, the [nav tag](/tags/nav) will reference a default "Pages" collection structure, if there is one.

```
<ul>
{{ structure:top_nav }}
    <li><a href="{{ url }}">{{ title }}</a></li>
{{ /structure:top_nav }}
</ul>
```

## Tree

The tree is what defines the structure. It contains an array of items, each of which is considered a "page".

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
        url: 'https://github.com/example/repo
```

>  While you **can** edit a structure through the files, it's **much easier** to manage in Control Panel with its lovely drag and drop interface.

Each page may have an optional `children` array which is itself another tree. You can repeat this pattern and go as deep as necessary. The `max_depth` setting on the Structure will prevent you from placing pages any deeper when using the Control Panel.

- An entry reference should contain an `entry` key with a value of the entry's ID. The about, hobbies, blog, and contact pages in the snippet above are examples.
- A hardcoded link* should contain a `url` key with either an internal or external URL. The `title` is optional. The GitHub page in the snippet above is an example.
- Text* can just contain a `title`. The Support page above is an example.

_\* Text and link branches are only available in Navs._

---
title: Structures
intro:
template: page
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1568558416
id: 3c34ef5c-781e-4a22-a09b-25f58bdb58a8
blueprint: page
---
## Overview

Statamic 2's Pages feature has been replaced by Structures &mdash; a way more flexible (and reusable) feature.

Each structure is a hierarchy of links and/or titles. These links may be to entries in one or more [collections](/collections), external URLs, or even anchor links in your content.

<figure>
    <img src="/img/structure.png" alt="The Statamic 3 blueprint configuration screen" width="535">
    <figcaption>Part of the structure of this very site.</figcaption>
</figure>

## Two Flavors

Structures come in two flavors, unlike Pringles. They can control the discrete URL pattern and order for a collection (like v2's Pages), or manage ad hoc navigation trees. And _just like_ Pringles &mdash; once you pop the top, you can't stop.


## Collection Structures

The first case is for defining the URL structure for a collection. This would be the equivalent of "Pages" in Statamic v2.

- A Structure that has been linked from a collection will be using this method.
- You will only be able to add entries from that collection.
- The order and arrangement of the entries will dictate their URLs.
- This will make `parent_uri` and `depth` variables available to the Collection's route.
- You can only place an entry once.

## Navigation Structures

Freestyle navigation structures exist to manage a nav out of entries that already exist, as well as freeform links and text (non-link) elements.


- A structure that hasn't been linked from an entry will be using this method.
- You can reference entries, enter hardcoded URLs (internal or external), or enter simple text blocks (that can be used as section headers for dropdown navs, for example).
- You can select which collections' entries will available to choose from.
- Any referenced entries will use the URLs defined by the collection, regardless of the position in the Structure.
- You can place the same entry multiple times.

## Templating

You can work with the [structure tag](/tags/structure) to loop through and render your HTML with its links. For backwards compatibility, the [nav tag](/tags/nav) will reference a default "Pages" collection structure, if there is one.

```
<ul>
{{ structure:top }}
    <li><a href="{{ url }}">{{ title }}</a></li>
{{ /structure:top }}
</ul>
```


## File Overview

Structures are stored in `content/structures/`. Each gets its own YAML file and its handle is its filename.

```
content/
|-- structures/
    |-- pages.yaml
    |-- footer.yaml
```

``` yaml
title: Footer
route: '{parent_uri}/{slug}'
max_depth: 3
collections:
  - pages
  - posts
  - documents
tree: [] # details below
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
- A hardcoded link should contain a `url` key with either an internal or external URL. The `title` is optional. The GitHub page in the snippet above is an example.
- Text can just contain a `title`. The Support page above is an example.

### Root Page

When using a Structure to define a collection's URLs, you may also have a root page. Typically this would be the "home" page. You should reference an entry's ID here too. It's separate from the tree.

``` yaml
root: id-of-home
tree: []
```

## Localization

When using [multiple sites](/multi-site), you'll need to specify which sites a structure can be used in.

``` yaml
title: Pages
sites:
  - site-one
  - site-two
```

The `tree` and `root` values will also be relocated into separate files organized into sites. The meta level information will remain in the existing YAML file.

```
content/structures/
|-- pages.yaml
|
|-- site-one/
|   `-- pages.yaml
|
`-- site-two/
    `-- pages.yaml
```

A structure will be considered unavailable for a particular site if a file doesn't exist in its subdirectory.

Structures that aren't different per site can leave their trees defined in the root file.

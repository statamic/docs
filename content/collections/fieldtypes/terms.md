---
title: Terms
extends: 9dd58c40-6e33-49c8-83fa-61a69f6371be
description: Attach Taxonomy Terms to your content.
intro: >
  Allows you attach Taxonomy Terms to your content. They could be Tags, Categories, Colors, Flavors, you name it. We highly recommend [learning more about Taxonomies](/taxonomies) before going any further.
screenshot: fieldtypes/screenshots/terms.png
options:
  -
    name: max_items
    type: integer
    description: >
      The maximum number of items that may be selected. Setting this to `1` will change the UI to a dropdown.
  -
    name: taxonomy
    type: string
    description: >
      The handle of the Taxonomy from which to fetch Terms. Not needed when placed in the fieldset's `taxonomies` array.
      In that case, it'll get the taxonomy from the field name.
  -
    name: create
    type: boolean *true*
    description: >
      By default you may create new terms. Set to `false` to only allow selecting from existing terms.
  -
    name: query_scopes
    type: string
    description: >
      Allows you to specify a [query scope](/extending/query-scopes-and-filters#scopes) which should be applied when retrieving selectable terms. Make sure to specify the "handle" of the query scope, eg. `my_awesome_scope`.
stage: 2
id: 31adcc00-4fbb-4fe9-9b48-401061273096
---

## Overview

Taxonomies are usually relationships established on the collection-configuration level. Make sure to read the [Taxonomies documentation](/taxonomies) to understand how everything works.

## Data Structure

If the field is being used for taxonomizing your content (ie. the field name matches the taxonomy handle), the term's _slugs_ will be saved.

``` yaml
wildlife:
  - kangaroo
  - three-toed-sloth
  - panda
  - porg
```

However, if you just want to store references to taxonomy terms for other purposes, the term's IDs will be saved. See [below](#without-taxonomizing) for more detail.

A term ID is the taxonomy handle combined with the slug.
This way, you may reference terms from multiple taxonomies.

``` yaml
things_you_may_find_adorable:
  - wildlife/panda
  - people/the-elderly
```

## Templating

As outlined in the [Taxonomies Guide](/taxonomies#templating), term slugs will automatically be converted to Term objects which means
you will have all of the term's data available as variables.

```
<ul>
  {{ wildlife }}
    <li><a href="{{ url }}">{{ title }}</a></li>
  {{ /wildlife }}
</ul>
```

```html
<ul>
  <li><a href="/wildlife/kangaroo">Kangaroo</a></li>
  <li><a href="/wildlife/three-toed-sloth">Three Toed Sloth</a></li>
</ul>
```

## Using terms without taxonomizing {#without-taxonomizing}

The most common use for this fieldtype is to taxonomize, or "tag", your entry.

However, sometimes you have other ideas in mind for using taxonomy terms. For instance, you might have a "similar tags" field, or want to create an index of many different, unrelated things. In this case, you aren't tagging the entry itself at all.

When using the taxonomy field in this way, terms will get saved using _IDs_ instead of slugs.

```
similar_things:
  - categories/hats
  - tags/delightful
```

These will _not_ be automatically converted to Terms, since the field name does not match any taxonomy handle.
You will need to use the [Relate Tag](/tags/relate) in your template to have these converted to Terms.

```
<ul>
  {{ relate:similar_things }}
    <li><a href="{{ url }}">{{ title }}</a></li>
  {{ /relate:similar_things }}
</ul>
```

```html
<ul>
  <li><a href="/categories/hats">Hats</a></li>
  <li><a href="/tags/delightful">Delightful</a></li>
</ul>
```

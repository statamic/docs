---
title: "Collection:Count"
description: Fetches the number of entries in a collection
intro: |
  This tag is a clone of the [collection tag](/tags/collection) but with one big difference: it only returns the total number of entries that match your set of filters.
parent_tag: 045a6e54-c792-483a-a109-f07251a79e47
parameters:
  -
    name: in|from
    type: string
    description: >
      The collection in which to count entries.
  -
    name: "*"
    type: inherit
    description: 'All parameters available on the [collection tag](/tags/collection) are available.'
stage: 4
id: b888a242-ca4c-4a96-81ca-518bc5e3b085
---
## Overview

This tag's only purpose is to fetch the number of the entries in a collection that match your set of filtering parameters without the need for a tag pair/loop.

## Example

```
There are {{ collection:count in="pogs" }} pogs in this site.
```

```html
There are 6201 pogs in this site.
```

You could do the same thing inside a regular collection tag by aliasing the results to a single variable and using the [count modifier](/modifiers/count).

```
{{ collection:blog as="entries" }}
There are {{ entries | count }} pogs in this site.
{{ /collection:blog }}
```

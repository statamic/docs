---
title: "Taxonomy:Count"
description: Fetches the number of terms in a taxonomy
intro: |
  This tag is a clone of the [taxonomy tag](/tags/taxonomy) but with one big difference: it only returns the total number of terms that match your set of filters.
parent_tag: ba832b71-a567-491c-b1a3-3b3fae214703
parameters:
  -
    name: in|from
    type: string
    description: >
      The taxonomy in which to count terms.
  -
    name: "*"
    type: inherit
    description: 'All parameters available on the [taxonomy tag](/tags/taxonomy) are available.'
stage: 4
id: b32c0902-9642-4625-b4bc-de68fa8dfee2
---
## Overview

This tag's only purpose is to fetch the number of the terms in a taxonomy that match your set of filtering parameters without the need for a tag pair/loop.

## Example

```
There are {{ taxonomy:count in="tags" }} tags in this site.
```

```html
There are 6201 tags in this site.
```

You could do the same thing inside a regular taxonomy tag by aliasing the results to a single variable and using the [count modifier](/modifiers/count).

```
{{ taxonomy:tags as="terms" }}
There are {{ terms | count }} tags in this site.
{{ /taxonomy:tags }}
```

---
title: Increment
description: "Creates incrementing indexes inside loops"
intro: "Each time an increment tag is parsed, an index is incremented by one and displayed."
parameters:
  -
    name: from
    type: integer
    description: |
      The number to start incrementing from. Default: `0`;
  -
    name: by
    type: integer
    description: |
      The size to increment by. Default: `1`.
stage: 4
id: b33aa176-06e6-411d-a4b7-0a514f697d78
---
## Overview

Most loops already have an `index` variable that will display which iteration the loop is on. However, there are cases were you may need to start another counter, begin counting from a particular number, or increment by a step size other than `1`. For those reasons, this tag exists.

```
{{ items }}
  {{ increment }}
{{ /items }}
```

``` output
1 2 3 4 5 6
```

> A counter will only be incremented if its parsed. You can wrap it inside an `if` condition if you want it to be conditionally incremented.

## Multiple Counters

You can have multiple counters going at once in your view by giving each a unique name as the second tag argument.

```
{{ items }}
  {{ increment:again }}
{{ /items }}
```

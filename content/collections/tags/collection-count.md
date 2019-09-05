---
title: Count
overview: Get the number of entries in a collection.
parameters:
  -
    name: from|folder|use|in|collection
    type: string
    description: >
      The collection in which to count entries. All the parameters do the same thing - use whatever feels most natural
      in your templates.
  -
    name: collection params
    type: inheritance
    description: 'All parameters available on the [collection tag](/tags/collection) are also available here.'
id: b888a242-ca4c-4a96-81ca-518bc5e3b085
---

## Example {#example}

```
There are {{ collection:count in="blog" }} blog posts.
```

``` .language-output
There are 10 blog posts.
```

---
title: Get
types:
  - asset
  - utility
  - relationship
id: c6311d04-364d-4086-8b6b-2a58e88c6cb8
---
Gets a value from a relationship based on its ID. This is like a nicer-to-read single tag version of the
[Relate Tag](/tags/relate).

``` .language-yaml
featured_post: 4e82a520-275f-11e6-bdf4-0800200c9a66
```

```
{{ featured_post | get:title }}
```

``` .language-output
Featured Post Title
```

The above is equivalent to doing this:

```
{{ relate:featured_post }}{{ title }}{{ /relate:featured_post }}
```

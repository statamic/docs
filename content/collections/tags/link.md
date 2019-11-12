---
title: Link
description: 'Generates URLs'
intro:  Generate fully qualified URLs with the option to include your domain.
parameters:
  -
    name: to|src
    type: string
    description: |
      Generate a URL to this relative path string.
  -
    name: absolute
    type: boolean
    description: |
      Make the URL absolute if it isn't already. Default: `false`.
stage: 4
id: ce8211b3-7e33-46ae-85ff-fe8880dafe11
---
## Overview
You can create a fully qualified URL to any resource, asset, or page on your site using a path relative string.

For example, if you had a link to `<a href="fanny-packs">`, it would be broken if you left that relative area of the site. By using the link tag you can ensure it's relative to your site root, and include the domain if needed.

```
{{ link to="fanny-packs" }}
{{ link to="fanny-packs" absolute="true" }}
```

``` output
/fanny-packs
https://example.com/fanny-packs
```

---
id: f8e00858-1991-44ae-bc47-b87779e7a31d
blueprint: tag
title: Mount
intro: 'The Mount tag is used to return the URL to a collection''s mount entry.'
parameters:
  -
    name: handle
    type: string
    required: true
    description: 'Specify the name of the collection.'
---
## Overview

This tag lets you get the URL to a collection's mount entry.

```
<a href="{{ mount handle="blog" }}">Read Our Blog</a>
```

## Shorthand

You may also use a shorthand syntax, where the second tag argument is the collection handle.

```
<a href="{{ mount:blog }}">Read Our Blog</a>
```
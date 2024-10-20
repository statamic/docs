---
id: f8e00858-1991-44ae-bc47-b87779e7a31d
blueprint: tag
title: Mount URL
intro: 'The Mount URL tag is used to return the URL to a collection''s mount entry.'
parameters:
  -
    name: handle
    type: string
    required: true
    description: 'Specify the name of the collection.'
---
## Overview

This tag lets you get the URL to a collection's mount entry.

::tabs

::tab antlers
```antlers
<a href="{{ mount_url handle="blog" }}">Read Our Blog</a>
```
::tab blade
```blade
<a href="{{ Statamic::tag('mount_url')->handle('blog') }}">Read Our Blog</a>
```
::

## Shorthand

You may also use a shorthand syntax, where the second tag argument is the collection handle.

::tabs

::tab antlers
```antlers
<a href="{{ mount_url:blog }}">Read Our Blog</a>
```
::tab blade
```blade
<a href="{{ Statamic::tag('mount_url:blog') }}">Read Our Blog</a>
```
::
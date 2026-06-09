---
id: 85539849-c829-4ebc-a849-8b14fc8a4bf2
blueprint: tag
title: Children
description: 'Fetch data from children of the current URL'
intro: 'The Children tag allows you to loop over and fetch data from the current URL.'
parameters:
  -
    name: of
    type: string
    description: >
      The URL of the entry whose children you want to fetch. Defaults to the current URL.
---
## Overview

:::warning
Not to be confused with [the children variable when inside the Nav tag](/tags/nav#variables).
:::

The children tag allows you to fetch data and loop over the children of the current page/URL. Can be handy when building a sub-nav, for example.

You can get the parent by using the [Parent tag](/tags/parent).

## Example

::tabs

::tab antlers
```antlers
{{ children }}
    {{ title }}
{{ /children }}
```
::tab blade
```blade
<statamic:children>
  {{ $title }}
</statamic:children>
```
::

## Fetching children of another entry

Pass a URL to the `of` parameter to fetch children from somewhere other than the current page.

::tabs

::tab antlers
```antlers
{{ children of="/blog" }}
    {{ title }}
{{ /children }}
```
::tab blade
```blade
<statamic:children of="/blog">
  {{ $title }}
</statamic:children>
```
::

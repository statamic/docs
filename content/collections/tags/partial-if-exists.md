---
id: 29a6e9dd-283e-4463-a414-d115dcde8451
blueprint: tag-glide
title: 'Partial:If_Exists'
description: 'Renders a partial if it exists.'
intro: 'Renders a partial if it exists.'
parameters:
  -
    name: src
    type: string
    description: 'You can pass the name of the partial with a parameter instead of tag argument. Example: `src="cards/author_bio"` or `:src="var_name"`.'
  -
    name: '*'
    type: mixed
    description: 'Any parameter you create will be passed through to the partial as a variable.'
---
## Overview

You can use this tag to output a partial if it exists. Useful if you have some sort of dynamic loop.

::tabs

::tab antlers
```antlers
{{ partial:if_exists src="mypartial" }}
```
::tab blade
```blade
<s:partial:if_exists src="mypartial" />
```
::

Practically identical to the [`partial`](/tags/partial) except if the view doesn't exist it will just output
nothing instead of throwing a "view not found" exception.

## Related Reading

This tag goes hand in hand with the [`partial`](/tags/partial) tag.
You may be interested in the [`partial:exists`](/tags/partial-exists) tag if you need to do a more
complicated conditional check in your template.

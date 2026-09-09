---
id: f06c6941-8ad3-4eac-99b1-6d3dea857d57
title: 'Include:If_Exists'
description: 'Renders a view if it exists.'
intro: 'Renders a view if it exists.'
parameters:
  -
    name: src
    type: string
    description: 'You can pass the name of the view with a parameter instead of tag argument. Example: `src="cards/author"` or `:src="var_name"`.'
  -
    name: '*'
    type: mixed
    description: 'Any parameter you create will be passed through to the view as a variable.'
---
## Overview

You can use this tag to render a view if it exists. Useful if you have some sort of dynamic loop.

::tabs

::tab antlers
```antlers
{{ include:if_exists src="cards/author" }}
```
::tab blade
```blade
<s:include:if_exists src="cards/author" />
```
::

Practically identical to the [`include`](/tags/include) tag, except if the view doesn't exist it will just output
nothing instead of throwing a "view not found" exception.

## Related Reading

This tag goes hand in hand with the [`include`](/tags/include) tag.
You may be interested in the [`include:exists`](/tags/include-exists) tag if you need to do a more
complicated conditional check in your template.

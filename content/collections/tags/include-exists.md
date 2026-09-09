---
id: 35ff991a-fb8a-4747-9e12-f64047f0b192
title: 'Include:Exists'
description: 'Checks if a view exists.'
intro: 'Checks if a view exists.'
parameters:
  -
    name: src
    type: string
    description: 'You can pass the name of the view with a parameter instead of tag argument. Example: `src="cards/author"` or `:src="var_name"`.'
---
## Overview

You can use this tag to check if a view exists. Useful if you have some sort of dynamic loop.

::tabs

::tab antlers
```antlers
{{ if {include:exists src="cards/author"} }}
    It exists
{{ else }}
    It doesn't.
{{ /if }}
```
::tab blade
```blade
@if (Statamic::tag('include:exists')->src('cards/author')->fetch())
  It exists
@else
  It doesn't.
@endif
```
::

## Related Reading

This tag goes hand in hand with the [`include`](/tags/include) tag.
You may be interested in the [`include:if_exists`](/tags/include-if-exists) tag to simplify your template.

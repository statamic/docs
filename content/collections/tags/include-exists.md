---
id: 5821391e-fc26-4a44-9a14-9893c86f0387
title: 'Include:Exists'
description: 'Checks if a view exists.'
intro: 'Checks if a view exists.'
parameters:
  -
    name: src
    type: string
    required: true
    description: |
      The name of the view to check for. Example: `src="cards/author_bio"` or `:src="var_name"`.
---
## Overview

You can use this tag to check if a view exists. Useful if you have some sort of dynamic loop.

::tabs

::tab antlers
```antlers
{{ if {include:exists src="myview"} }}
  It exists.
{{ else }}
  It doesn't.
{{ /if }}
```
::tab blade
```blade
@if (Statamic::tag('include:exists')->src('myview')->fetch())
  It exists.
@else
  It doesn't.
@endif
```
::

## Related Reading

This tag goes hand in hand with the [`include`](/tags/include) tag.
You may be interested in the [`include:if_exists`](/tags/include-if-exists) tag to simplify your template.

---
id: 702a89b4-ff3e-4f29-b9cd-5343c4e7d34f
title: 'Include:If_Exists'
description: 'Renders a view if it exists.'
intro: 'Renders a view if it exists.'
parameters:
  -
    name: src
    type: string
    required: true
    description: |
      The name of the view to render. Example: `src="cards/author_bio"` or `:src="var_name"`.
  -
    name: when
    type: string
    description: |
      Render the view only if a condition is met.
  -
    name: unless
    type: string
    description: |
      The converse of `when`.
  -
    name: cascade
    type: boolean
    description: |
      When `true`, the [Cascade](/content-modeling/data-inheritance) is made available inside the view. Defaults to `false`.
  -
    name: params
    type: array
    description: |
      An associative array whose entries become variables in the view. Any parameter you set directly on the tag overrides a matching key.
  -
    name: handle_prefix
    type: string|array
    description: |
      A prefix, or array of prefixes, to strip from the keys in `params`. With `handle_prefix="hero_"`, a `hero_title` entry is also available as `{{ title }}`.
  -
    name: "*"
    type: mixed
    description: |
      Any other parameter you create will be passed through to the view as a variable.
---
## Overview

You can use this tag to output a view if it exists. If the view doesn't exist, nothing is output instead of throwing a "view not found" exception. Useful if you have some sort of dynamic loop.

::tabs

::tab antlers
```antlers
{{ include:if_exists src="myview" }}
```
::tab blade
```blade
<s:include:if_exists src="myview" />
```
::

This tag accepts everything the [`include`](/tags/include) tag does, including [slots](/tags/include#slots) and the same [scope rules](/tags/include#scope-isolation).

## Related Reading

This tag goes hand in hand with the [`include`](/tags/include) tag.
You may be interested in the [`include:exists`](/tags/include-exists) tag if you need to do a more complicated conditional check in your template.

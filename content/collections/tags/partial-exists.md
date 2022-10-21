---
id: 75bf08fb-59ba-4148-91ca-5199efa241cf
title: 'Partial:Exists'
description: 'Checks if a partial exists.'
intro: 'Checks if a partial exists.'
parameters:
  -
    name: src
    type: string
    description: 'You can pass the name of the partial with a parameter instead of tag argument. Example: `src="cards/author_bio"` or `:src="var_name"`.'
---
## Overview

You can use this tag to check if a partial exists. Useful if you have some sort of dynamic loop.

```
{{ if {partial:exists src="mypartial" } }}
    It exists
{{ else }}
    It doesn't.
{{ /if }}
```

## Related Reading

This tag goes hand in hand with the [`partial`](/tags/partial) tag.
You may be interested in the [`partial:if_exists`](/tags/partial-if-exists) tag to simplify your template.

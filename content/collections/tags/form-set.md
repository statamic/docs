---
title: "Form:Set"
id: 0b9590a7-f8b3-4a11-92b5-60d6d43cf869
description: Wraps other form tags to group them by the same formset.
intro: This is a "convenience" wrapper tag that will set all _other_ form tags to use the same formset.
parameters:
  -
    name: handle|is|in|form|formset
    type: string
    description: >
      Specify the name of the form.
stage: 4
---
## Overview

Each `form` tag needs to know which formset it is handling. As a convenience, rather than re-specifying the same formset parameter over and over, we can use an enclosing `{{ form:set }}` tag pair to apply it everywhere, automatically.

```
{{ form:set is="contact" }}

    {{ if {form:errors} }}
      {{ form:errors }}...{{ /form:errors }}
    {{ /if }}

    {{ if {form:success} }}...{{ /if }}

    {{ form:create }}...{{ /form:create }}

{{ /form:set }}
```

In this example, if we didn't use the `form:set` wrapper tag, we would need to add `in="contact"` to each of the
`form:something` tags.

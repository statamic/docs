---
title: "Form:Formset"
id: 0b9590a7-f8b3-4a11-92b5-60d6d43cf869
overview: Wrap a group of form tags to set them all to the same formset.
parameters:
  -
    name: in|is|formset
    type: string
    description: >
      The name of the formset to use. You can use `in`, `is`, or `formset`. Whichever feels more natural to you.
---
## Usage {#usage}

Each `form` tag needs to know which formset it is handling. As a convenience, rather than re-specifying the same formset parameter
over and over, we can use an enclosing `{{ form:set }}` tag pair to apply it automatically.

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

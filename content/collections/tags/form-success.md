---
title: "Form:Success"
id: e7430255-6237-4cc8-96c2-e8338758851f
overview: Returns true after a successful form submission.
intro: >
  This is how you check if a form was successful _outside_ of a [form:create](/tags/form-create) tag.
parameters:
  -
    name: handle|is|in|form|formset
    type: string
    description: >
      Specify the name of the form. Only required if you do _not_ use the `form:set` tag, or don't have a `form` defined in the current context.
stage: 4
---
## Example

```
{{ if {form:success in="contact"} }}
    <p>Thanks for filling out the survey! Sorry it was so long.</p>
{{ /if }}
```

> `form:success` is a Tag, not a variable. Wrap it with single braces when inside a conditional.

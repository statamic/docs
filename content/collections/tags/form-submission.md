---
title: "Form:Submission"
id: 8720d9ed-3a5f-4c60-af74-7b82933146a2
overview: Display data immediately following a successful submission.
parameters:
  -
    name: handle|is|in|form|formset
    type: string
    description: >
      The name of the form this tag should be targeting. This is only required if you do _not_ use the `form:set` tag, or
      if you don't have a `form` defined in the current context.
variables:
  -
    name: submission data
    type: array
    description: >
      All the fields that were entered in the submission are available in this Tag.
---

## Example {#example}

Here we'll output a small thank-you paragraph once there's a successful submission, otherwise just
show the form itself.

The `{{ name }}` and `{{ rating }}` variables would correspond the `name="name"` and `name="rating"` fields that
were submitted in the form.

```
{{ form:set is="feedback" }}
    {{ if {form:success} }}

        {{ form:submission }}
            Thanks for your feedback, {{ name }}.
            We appreciate the {{ rating }} star rating you gave us.
        {{ /form:submission }}

    {{ else }}

        {{ form:create }} ... {{ /form:create }}

    {{ /if }}
{{ /form:set }}
```

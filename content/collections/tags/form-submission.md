---
title: "Form:Submission"
id: 8720d9ed-3a5f-4c60-af74-7b82933146a2
description: Accesses the data from a successful submission.
intro: If you want to show the user the data they submitted — whether as a confirmation or to pre-populate or personalize some content — this is the easiest way to do it.
parameters:
  -
    name: handle|is|in|form|formset
    type: string
    description: >
      Specify the name of the form. Only required if you do _not_ use the `form:set` tag, or don't have a `form` defined in the current context.
variables:
  -
    name: submission data
    type: array
    description: >
      All the fields that were entered in the submission are available.
stage: 4
---
## Example

Here we'll output a small thank-you note once there's a successful submission, otherwise show the form itself.

The `{{ name }}` and `{{ rating }}` variables correspond to input fields of the same name.

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

---
title: "Form:Submissions"
id: afa2740e-2cf7-4ada-a92e-4fc92e827351
overview: Iterate over and display data from form submissions.
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
    type: mixed
    description: Each submission being iterated has access to all the field names as variables.
  -
    name: date
    type: Carbon|string
    description: Along with the submission data, all submissions will contain the date they were submitted.
---

## Usage {#usage}

This tag has the same functionality as the [collection](/tags/collection) tag, with exception that the collection
is of form submissions rather than entries.

```
{{ form:submissions in="feedback" }}
    <div>
        Submitted on {{ date }}
        Name: {{ name }}
        Rating: {{ rating }}
        Comment: {{ comment }}
    </div>
{{ /form:submissions }}
```

---
title: "Form:Success"
id: e7430255-6237-4cc8-96c2-e8338758851f
overview: Boolean if a form submission was successful.
parameters:
  -
    name: handle|is|in|form|formset
    type: string
    description: >
      The name of the form this tag should be targeting. This is only required if you do _not_ use the `form:set` tag, or
      if you don't have a `form` defined in the current context.
---
## Example {#example}

```
{{ form:set is="feedback" }}

    {{ if {form:success} }}
        Thanks for your feedback!
    {{ else }}
        {{ form:create }} ... {{ /form:create }}
    {{ /if }}

{{ /form:set }}
```

Note that since `form:success` is a Tag rather than a variable, it should be wrapped with single braces when
inside the conditional.

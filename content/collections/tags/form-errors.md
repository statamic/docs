---
title: Errors
id: eff214d5-cd61-4318-b351-14f765bbe4fc
overview: >
  When a form submission encounters a validation error, this Tag allows
  you to show your user where everything went south.
description: Display form errors.
parameters:
  -
    name: formset|in
    type: string
    description: >
      The name of the formset this tag should be targeting. This is only required if you do _not_ use the `form:set` tag, or
      if you don't have a `formset` defined in the current context.
variables:
  -
    name: value
    type: string
    description: >
      The output of the errors tag is a primitive array. That means in each iteration the `{{ value }}` will output
      a different error message. See the example below.
---
## Example {#example}

This tag can be used both as a conditional and as the data itself.

```
{{ form:set is="contact" }}
    {{ if {form:errors} }}
        <p>Oops, here's what went wrong:</p>
        <ul>
            {{ form:errors }}
                <li>{{ value }}</li>
            {{ /form:errors }}
        </ul>
    {{ /if }}

    {{ form:create }}
        ...
    {{ /form:create }}
{{ /form:set }}
```

Note that since `form:errors` is a Tag rather than a variable, it should be wrapped with single braces when
inside the conditional.

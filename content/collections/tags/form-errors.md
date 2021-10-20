---
title: "Form:Errors"
id: eff214d5-cd61-4318-b351-14f765bbe4fc
intro: >
  If a form submission encounters a validation error, you can use this tag to loop through the error messages and show your user where everything went south.
description: Provides access to form errors.
parameters:
  -
    name: handle|is|in|form|formset
    type: string
    description: >
      Specify the name of the form. Only required if you do _not_ use the `form:set` tag, or don't have a `form` defined in the current context.
variables:
  -
    name: value
    type: string
    description: >
      This tag contains a primitive array. In each iteration, the `{{ value }}` will output a different error message. See the example above.
stage: 4
---
## Example

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

:::tip
`form:errors` is a Tag, not a variable. Be sure to wrap it with single braces when inside a condition.
:::

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
---
## Example

This tag can be used both as a conditional and as the data itself.

::tabs

::tab antlers
```antlers
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

::tab blade
```blade
<s:form:set
  is="contact"
>
  <s:form:errors
    as="errors"
  >
    @if (count($errors) > 0)
      <p>Oops, here's what went wrong:</p>
      <ul>
        @foreach($errors as $error)
          <li>{{ $error['value'] }}</li>
        @endforeach
      </ul>
    @endif
  </s:form:errors>

  <s:form:create>
    ...
  </s:form:create>
</s:form:set>
```
::

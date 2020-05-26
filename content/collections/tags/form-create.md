---
title: "Form:Create"
id: aa96fcf1-510c-404b-9b63-cea8942e1bf8
overview: >
  Generate necessary `<form>` markup to accept form submissions.
parameters:
  -
    name: handle|is|in|form|formset
    type: string
    description: >
      The name of the form this tag should be targeting. This is only required if you do _not_ use the `form:set` tag, or
      if you don't have a `form` defined in the current context.
  -
    name: redirect
    type: string
    description: >
      The location your user will be taken after a successful form submission. If left blank, the user will stay
      on the same page.
  -
    name: error_redirect
    type: string
    description: >
      The same as `redirect`, but for failed submissions.
  -
    name: allow_request_redirect
    type: boolean
    description: When set to true, the `redirect` and `error_redirect` parameters will get overridden by `redirect` and `error_redirect` query parameters in the URL.
  -
    name: HTML Attributes
    type:
    description: >
      Set HTML attributes as if you were in an HTML element. For example, `class="required" id="contact-form"`.
variables:
  -
    name: fields
    type: array
    description: >
      An array of available fields for [dynamic rendering](#dynamic-rendering).
  -
    name: errors
    type: array
    description: An indexed array of any validation errors upon submission. Suitable for looping through. eg. `{{ errors }}{{ value }}{{ /errors }}`
  -
    name: error
    type: array
    description: An array of validation errors indexed by field names. Suitable for targeting fields. eg. `{{ error:email }}`
  -
    name: old
    type: array
    description: An array of submitted values from the previous request. Useful for re-populating fields if there are validation errors.
  -
    name: success
    type: string
    description: A success message.
---
## Overview

Here we'll be creating a form to submit an entry in the `contact` form.

```
{{ form:create in="contact" }}

    {{ if errors }}
        <div class="bg-red-300 text-white p-2">
            {{ errors }}
                {{ value }}<br>
            {{ /errors }}
        </div>
    {{ /if }}

    {{ if success }}
        <div class="bg-green-300 text-white p-2">
            {{ success }}
        </div>
    {{ /if }}

    <label>Email</label>
    <input type="text" name="email" value="{{ old:email }}" />

    <label>Message</label>
    <textarea name="message" rows="5">{{ old:message }}</textarea>

    <button>Submit</button>

{{ /form:create }}
```

You can also use the shorthand syntax for `form:create in="contact"`.

```
{{ form:contact }}
    ...
{{ /form:contact }}
```

## Dynamic Rendering

Instead of hardcoding individual fields, you may loop through the `fields` array to render fields more dynamically.

```
{{ fields }}
    <div class="p-2">
        <label>{{ display }}</label>
        <div class="p-1">{{ field }}</div>
        {{ if error }}
            <p class="text-gray-500">{{ error }}</p>
        {{ /if }}
    </div>
{{ /fields }}
```

Each item in the `fields` array contains `type`, `display` and `handle`, which are configurable from the `user` blueprint.

You will also find the field's `old` input on unsuccessful submission, as well as an `error` message when relevant.

Finally, the `field` value contains a pre-rendered form input.  Using this will intelligently render inputs as inputs, textareas as textareas, and snozzberries as snozzberries.  You can customize these pre-rendered templates by running `php artisan vendor:publish --tag=statamic-forms`, which will expose editable templates in your `views/vendor/statamic/forms/fields` folder.

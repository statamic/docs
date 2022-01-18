---
title: "Form:Create"
id: aa96fcf1-510c-404b-9b63-cea8942e1bf8
description: Manages markup and success/error handling for forms.
intro: Statamic [forms](/forms) serve to collect, report, and reuse user submitted data. This tag handles the HTML markup, redirect behavior, and success/error states and messages for these forms.
parameters:
  -
    name: handle|is|in|form|formset
    type: string
    description: >
      Specify the name of the form. Only required if you do _not_ use the `form:set` tag, or don't have a `form` defined in the current context.
  -
    name: redirect
    type: string
    description: >
      The location your user will be taken after a successful form submission. If left blank, the user will stay on the same page.
  -
    name: error_redirect
    type: string
    description: >
      The location your user will be taken after a failed form submission. If left blank, the user will stay on the same page.
  -
    name: allow_request_redirect
    type: boolean
    description: When `true`, the `redirect` and `error_redirect` parameters will get overridden by `redirect` and `error_redirect` query parameters in the URL. For example, `?redirect=/thanks`
  -
    name: files
    type: boolean
    description: When `true`, the `enctype="multipart/form-data"` attribute will be rendered on your `<form>` tag for file uploads.
  -
    name: js
    type: string
    description: Enable [conditional fields](#conditional-fields) using one of the provided JS drivers.
  -
    name: HTML Attributes
    type:
    description: >
      Set HTML attributes as if you were on an HTML element. For example, `class="required" id="contact-form"`.
variables:
  -
    name: fields
    type: array
    description: >
      An array of available fields for [dynamic rendering](#dynamic-rendering).
  -
    name: errors
    type: array
    description: |
      An indexed array of any validation errors upon submission. For example: `{{ errors }}{{ value }}{{ /errors }}`
  -
    name: error
    type: array
    description: |
      An array of validation errors indexed by **field name**. For example: `{{ error:email }}`
  -
    name: old
    type: array
    description: An array of submitted values from the previous request. Used for re-populating fields if there are validation errors.
  -
    name: success
    type: string
    description: A success message, usually used in a condition to check of a form submission was successful. `{{ if success }} Hurray! {{ /if }}`
  -
    name: submission_created
    type: boolean
    description: A success boolean, which differs from `success` in that it will actually return falsey when the [honeypot](/forms#honeypot) is filled. This can be useful when you want to show a fake success message for honeypot spam, but want to prevent analytics tracking code from being rendered.
stage: 4
---
## Overview

Here we'll be creating a form to submit an entry in a `contact` form.

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

When you need to render a form that's selected via the Form Fieldtype you can use this pattern:

```
{{ form:create in="{ form_fieldtype:handle }" }}
    ...
{{ /form:create }}
```

This way you can let Control Panel users selected which form should be used on an entry.

## Dynamic Rendering

Instead of hardcoding individual fields, you may loop through the `fields` array to render fields in a dynamic fashion.

```
{{ fields }}
    <div class="p-2">
        <label>
          {{ display }}
          {{ if validate | contains:required }}
            <sup class="text-red">*</sup>
          {{ /if }}
        </label>
        <div class="p-1">{{ field }}</div>
        {{ if error }}
            <p class="text-gray-500">{{ error }}</p>
        {{ /if }}
    </div>
{{ /fields }}
```

Each item in the `fields` array contains the following data configurable in the form's blueprint.

| Variable | Type | Description |
|---|---| --- |
| `handle` | string | System name for the field |
| `display` | string | User-friendly field label |
| `type` | string | Name of the [fieldtype](/fieldtypes) |
| ` field` | string | Pre-rendered HTML based on the fieldtype |
| `error` | string | Error message from an unsuccessful submission |
| `old` | array | Contains user input from an unsuccessful submission |
| `instructions` | string | User-friendly instructions label |
| `validate` | array | Contains an array of validation rules |

### Pre-rendered HTML

Using the `field` variable will intelligently render inputs as inputs, textareas as textareas, and snozzberries as snozzberries.

You can customize these pre-rendered snippets by running `php artisan vendor:publish --tag=statamic-forms`. It will expose editable templates snippets in your `views/vendor/statamic/forms/fields` directory that will be used by each fieldtype.

This approach, combined with the [blueprint editor](/blueprints), will give you something very similar to a traditional "Form Builder" from other platforms.

**Example**

```
{{ form:contact }}
    {{ fields }}
        <div class="mb-2">
            <label class="block">{{ display }}</label>
            {{ field }}
        </div>
    {{ /fields }}
{{ /form:contact }}
```

```output
<form method="POST" action="https://website.example/!/forms/contact">
    <input type="hidden" name="_token" value="cN03woeRj5Q0GtlOj7GydsZcRwlyp9VLzfpwDFJZ">
    <div class="mb-2">
        <label class="block">Name</label>
        <input type="text" name="name" value="">
    </div>
      <div class="mb-2">
        <label class="block">Email Address</label>
        <input type="text" name="email" value="">
    </div>
      <div class="mb-2">
        <label class="block">Note</label>
        <textarea name="message"></textarea>
    </div>
</form>
```

## Conditional Fields

You may also conditionally show and hide fields by utilizing the [conditional fields](/conditional-fields#overview) settings in your form's blueprint editor. Once your fields are configured in the control panel, you will need to include the necessary front-end scripts and enable javascript on the `form:create` tag. We currently ship with an [Alpine.js](https://alpinejs.dev/) driver, but it is also possible to [build your own JS driver]() as well.

### Including the Scripts

For our Alpine.js example, the first step is to include Alpine, as well as Statamic's front-end `helpers.js` script:

```html
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="/vendor/statamic/frontend/js/helpers.js"></script>
```

These can be added to your [layout](/views#layouts) just before your `</body>` tag. Alternatively, you could also work these into your webpack/mix build, but this is the simplest way.

### Enabling the Form Driver

The next step is to enable the Alpine form driver via the `js="alpine"` parameter.

```
{{ form:contact js="alpine" }}
    ...
{{ /form:contact }}
```

This will generate an Alpine component, with automatic `x-data` handling that will respect old input when there are validation errors, etc.

### Wiring Up the Fields

Finally, you will need to wire up the fields. With Alpine, this is done using `x-model` on the input to keep it in sync with the component, as well as an `x-if` to conditionally render the input and its label.

```
<template x-if="{{ show_field:name }}">
    <label>Name</label>
    <input type="text" name="name" value="{{ old:name }}" x-model="name" />
</template>
```

The `x-model` should reference the field's handle, and the `x-if` should reference the appropriate `show_field` JS generated by Statamic; In this case, `x-model="name"` and `x-if="{{ show_field:name }}"` respectively.

### Wiring Up Dynamically Rendered Fields

If you are [dynamically rendering your fields](#dynamic-rendering) using the `fields` loop, your template might look something like this:

```
{{ fields }}
    <template x-if="{{ show_field }}">
        <div class="p-2">
            <label>{{ display }}</label>
            <div class="p-1">{{ field }}</div>
        </div>
    </template>
{{ /fields }}
```

The pre-rendered `{{ field }}` input will automatically render `x-model` for you, but you'll still need to wrap your input and its label with an `x-if="{{ show_field }}`, as shown above.

### Scoping Your Alpine Data

If you are using other Alpine components in your form or on your page, the included Alpine driver allows you to scope the generated `x-data` to prevent conflicts with your other components. To do this, provide a scope key when enabling the JS driver.

```
{{ form:contact js="alpine:contact_form" }}
    ...
{{ /form:contact }}
```

The above will nest your form fields in a `contact_form` object within the generated `x-data`.

If you are hardcoding your inputs, you will need adjust your `x-model` to follow suit.

```
<template x-if="{{ show_field:name }}">
    <label>Name</label>
    <input type="text" name="name" value="{{ old:name }}" x-model="contact_form.name" />
</template>
```

If you are [dynamically rendering your fields](#dynamic-rendering) using the `fields` loop, this is once again handled for you.

### Building Your Own JS Driver

Should you want to work with another JS framework for handling conditional field logic, we've provided a few tools to help you [build your own JS driver]().

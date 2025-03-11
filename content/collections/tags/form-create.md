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
    name: csrf
    type: boolean
    description: When `false`, the hidden `name="_token"` attribute won't be added to the form so you can use other ways of providing the token. Defaults to `true`.
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
    type: string
    description: >
      Set HTML attributes as if you were on an HTML element. For example, `class="required" id="contact-form"`.
variables:
  -
    name: fields
    type: array
    description: >
      An array of available fields for [dynamic rendering](#dynamically-rendering-fields).
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

::tabs

::tab antlers
```antlers
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
::tab blade
```blade
<s:form:create in="contact">

    @if (count($errors) > 0)
        <div class="bg-red-300 text-white p-2">
            @foreach ($errors as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif

    @if ($success)
        <div class="bg-green-300 text-white p-2">
            {{ $success }}
        </div>
    @endif

    <label>Email</label>
    <input type="text" name="email" value="{{ old('email') }}" />

    <label>Message</label>
    <textarea name="message" rows="5">{{ old('message') }}</textarea>

    <button>Submit</button>

</s:form:create>
```
::

You can also use the shorthand syntax for `form:create in="contact"`.

::tabs

::tab antlers
```antlers
{{ form:contact }}
    ...
{{ /form:contact }}
```
::tab blade
```blade
<s:form:contact>
    ...
</s:form:contact>
```
::

Using this tag, Statamic will automatically take care of opening your form with a proper [CSRF token](https://laravel.com/docs/csrf).

```html
<form method="POST" action="https://website.example/!/forms/contact">
    <input type="hidden" name="_token" value="cN03woeRj5Q0GtlOj7GydsZcRwlyp9VLzfpwDFJZ">
    ...
</form>
```

It also provides helpers for [dynamically rendering](#dynamic-rendering) sections and fields, [conditionally rendering](#conditional-fields) fields, etc.

## Dynamic Rendering

### Dynamically Rendering via Form Fieldtype

When you need to render a form that's selected via the [Form Fieldtype](/fieldtypes/form) you can use this pattern:

::tabs

::tab antlers
```antlers
{{ form:create :in="form_fieldtype:handle" }}
    ...
{{ /form:create }}
```
::tab blade
```blade
<s:form:create :in="$form_fieldtype->handle">
    ...
</s:form:create>
```
::

This way you can let Control Panel users select which form should be used on an entry.

### Dynamically Rendering Fields

Instead of hardcoding individual fields, you may loop through the `fields` array using the [form:fields](/tags/form-fields) tag to render your blueprint's fields in a dynamic fashion.

::tabs

::tab antlers
```antlers
{{ form:contact }}

    {{ form:fields }}
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
    {{ /form:fields }}

    <button>Submit</button>

{{ /form:contact }}
```
::tab blade
```blade
<s:form:contact>

    <s:form:fields>
        <div class="p-2">
            <label>
                {{ $field['display'] }}
                @if (in_array('required', $field['validate'] ?? []))
                    <sup class="text-red">*</sup>
                @endif
            </label>
            <div class="p-1">{{ $field['field'] }}</div>
            @if ($field['error'])
                <p class="text-gray-500">{{ $field['error'] }}</p>
            @endif
        </div>
    </s:form:fields>

    <button>Submit</button>

</s:form:contact>
```
::

Each item in the `fields` array contains the following data configurable in the form's blueprint.

| Variable | Type | Description |
|---|---| --- |
| `handle` | string | System name for the field |
| `display` | string | User-friendly field label |
| `type` | string | Name of the [fieldtype](/fieldtypes) |
| `field` | string | [Pre-rendered field HTML](#prerendered-field-html) based on the fieldtype |
| `error` | string | Error message from an unsuccessful submission |
| `old` | array | Contains user input from an unsuccessful submission |
| `instructions` | string | User-friendly instructions label |
| `validate` | array | Contains an array of validation rules |
| `width` | string | Width of the field assigned in the blueprint |


### Pre-rendered Field HTML

Using the `field` variable will intelligently render inputs as inputs, textareas as textareas, and snozzberries as snozzberries.

You can customize these pre-rendered snippets by running `php artisan vendor:publish --tag=statamic-forms`. It will expose editable templates snippets in your `views/vendor/statamic/forms/fields` directory that will be used by each fieldtype.

:::tip
By default, pre-rendered snippets are implemented in Antlers. If you'd prefer to use Blade, you can grab some [ready-to-go Blade snippets](/blade-form-fields) to use as a starting point.
:::

This approach, combined with the [blueprint editor](/blueprints), will give you something very similar to a traditional "Form Builder" from other platforms.

**Example**

::tabs

::tab antlers
```antlers
{{ form:fields }}
    <div class="mb-2">
        <label class="block">{{ display }}</label>
        {{ field }}
    </div>
{{ /form:fields }}
```
::tab blade
```blade
<s:form:fields>
    <div class="mb-2">
        <label class="block">{{ $field['display'] }}</label>
        {{ $field['field'] }}
    </div>
</s:form:fields>
```
::

```output
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
```

### Dynamically Rendering Sections

If you have defined multiple sections in your form's blueprint, you can loop over these `sections` in a dynamic fashion as well.

::tabs

::tab antlers
```antlers
{{ form:contact }}

    {{ sections }}
        <fieldset>
            <legend>{{ display }}</legend>
            {{ form:fields }}
                ...
            {{ /form:fields }}
        </fieldset>
    {{ /sections }}

    <button>Submit</button>

{{ /form:contact }}
```
::tab blade
```blade
<s:form:contact>

    @foreach($sections as $section)
        <fieldset>
            <legend>{{ $section['display'] }}</legend>
            <s:form:fields :section="$section">
                ...
            </s:form:fields>
        </fieldset>
    @endforeach

    <button>Submit</button>

</s:form:contact>
```
::

Each item in the `sections` array contains the following data configurable in the form's blueprint.

| Variable | Type | Description |
|---|---| --- |
| `display` | string | User-friendly section label |
| `instructions` | string | User-friendly section instructions |
| `fields` | array | An array of [fields](#dynamically-rendering-fields) defined within that section |


## Conditional Fields

You may conditionally show and hide fields by utilizing the [conditional fields](/conditional-fields#overview) settings in your form's blueprint editor. Once configured, by including the necessary front-end scripts and enabling JavaScript on the `form:create` tag, all of the conditional logic will Just Work™.

Statamic includes an [Alpine.js](https://alpinejs.dev/) driver or you can build your own [custom JS driver](#custom-js-drivers) to wire up whichever framework you prefer.

### Including the Scripts

For our Alpine.js example, the first step is to include Alpine, as well as Statamic's front-end `helpers.js` script:

```html
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="/vendor/statamic/frontend/js/helpers.js"></script>
```

These can be added to your [layout](/views#layouts) just before your `</body>` tag. Alternatively, you could also work these into your webpack/mix build, but this is the simplest way.

### Enabling the JS Driver

The next step is to enable the Alpine JS driver via the `js="alpine"` parameter.

::tabs

::tab antlers
```antlers
{{ form:contact js="alpine" }}
    ...
{{ /form:contact }}
```
::tab blade
```blade
<s:form:contact js="alpine">
    ...
</s:form:contact>
```
::

This will generate an Alpine component, with automatic `x-data` handling that will respect old input when there are validation errors, etc.

### Wiring Up the Fields

Finally, you will need to wire up the fields. With Alpine, this is done using `x-model` on the input to keep it in sync with the component, as well as an `x-if` to conditionally render the input and its label.

::tabs

::tab antlers
```antlers
<template x-if="{{ show_field['name'] }}">
    <div class="p-2">
        <label>Name</label>
        <input type="text" name="name" value="{{ old:name }}" x-model="name" />
    </div>
</template>
```
::tab blade
```blade
<template x-if="{{ $show_field['name'] }}">
    <div class="p-2">
        <label>Name</label>
        <input type="text" name="name" value="{{ old('name') }}" x-model="name" />
    </div>
</template>
```
::

The `x-model` should reference the field's handle, and the `x-if` should reference the appropriate `show_field` JS generated by Statamic; In this case, `x-model="name"` and `x-if="{{ show_field['name'] }}"` respectively.

For nested fields, you can get `show_field` JS by passing the whole dotted handle as the key, ie) `x-if="{{ show_field['field_group.nested_field']}}"`.

### Wiring Up Dynamically Rendered Fields

If you are [dynamically rendering your fields](#dynamic-rendering) using the `fields` loop, your template might look something like this:

::tabs

::tab antlers
```antlers
{{ form:fields }}
    <template x-if="{{ show_field }}">
        <div class="p-2">
            <label>{{ display }}</label>
            <div class="p-1">{{ field }}</div>
        </div>
    </template>
{{ /form:fields }}
```
::tab blade
```blade
<s:form:fields>
    <template x-if="{{ $field['show_field'] }}">
        <div class="p-2">
            <label>{{ $field['display'] }}</label>
            <div class="p-1">{{ $field['field'] }}</div>
        </div>
    </template>
</s:form:fields>
```
::

The pre-rendered `{{ field }}` input will automatically render `x-model` for you, but you'll still need to wrap your input and its label with an `x-if="{{ show_field }}`, as shown above.

### Scoping Your Alpine Data

If you are using other Alpine components in your form or on your page, the included Alpine driver allows you to scope the generated `x-data` to prevent conflicts with your other components. To do this, provide a scope key when enabling the JS driver.

::tabs

::tab antlers
```antlers
{{ form:contact js="alpine:contact_form" }}
    ...
{{ /form:contact }}
```
::tab blade
```blade
<s:form:contact js="alpine:contact_form">
    ...
</s:form:contact>
```
::

The above will nest your form fields in a `contact_form` object within the generated `x-data`.

If you are hardcoding your inputs, you will need adjust your `x-model` to follow suit.

::tabs

::tab antlers
```antlers
<template x-if="{{ show_field:name }}">
    <div class="p-2">
        <label>Name</label>
        <input type="text" name="name" value="{{ old:name }}" x-model="contact_form.name" />
    </div>
</template>
```
::tab blade
```blade
<template x-if="{{ $show_field['name'] }}">
    <div class="p-2">
        <label>Name</label>
        <input type="text" name="name" value="{{ old('name') }}" x-model="contact_form.name" />
    </div>
</template>
```
::

If you are [dynamically rendering your fields](#dynamic-rendering) using the `fields` loop, this is once again handled for you.


## Custom JS Drivers

Should you need to work with another JS framework for handling [conditional fields](#conditional-fields) and form state in realtime, we've provided a few tools to help you build your own JS driver.

### Creating the Driver

To write a custom JS form driver, create a class and extend `Statamic\Forms\JsDrivers\AbstractJsDriver`.

```php
<?php

namespace App\Forms;

use Statamic\Forms\JsDrivers\AbstractJsDriver;
use Statamic\Statamic;

class RadJs extends AbstractJsDriver
{
    public function addToFormAttributes()
    {
        return [
            'r-data' => Statamic::modify($this->getInitialFormData())->toJson()->entities(),
        ];
    }

    public function addToRenderableFieldAttributes($field)
    {
        return [
            'r-model' => $field->handle(),
        ];
    }

    public function addToRenderableFieldData($field, $data)
    {
        $conditions = Statamic::modify($field->conditions())->toJson()->entities();

        return [
            'show_field' => 'Statamic.$conditions.showField('.$conditions.', $data)',
        ];
    }
}
```

In this above example, we provide `r-data` and `r-model` attributes for a fictional framework called `Rad.js`, as well as `show_field` [conditional logic](#the-helpersjs-script) for each renderable field.

:::tip
For a more real-world example, here is how you could create [a custom driver for Vue.js](https://gist.github.com/jesseleite/3507f7ad3dd062b9e5f7592c899bf297). Of course, you should also check out our built-in [Alpine.js driver](https://github.com/statamic/cms/blob/13721c5738c3fe43ce5b2161595a6d42016e7594/src/Forms/JsDrivers/Alpine.php).
:::

### Registering the Driver

To register your custom JS form driver class, simply call its static `register()` method from within a service provider.

``` php
public function register()
{
    \App\Forms\RadJs::register();
}
```

### Driver Requirements

The only true requirement of your custom driver is that you return `show_field` javascript from the `addToRenderableFieldData()` method, so that the user can wire up `show_field` [conditional logic](#the-helpersjs-script) as per [the documentation above](#wiring-up-the-fields).

### Available Methods and Properties

Take a look at the [AbstractJsDriver](https://github.com/statamic/cms/blob/feature/frontend-form-conditions/src/Forms/JsDrivers/AbstractJsDriver.php) class to see what is available to you, but here is a list of available methods and properties at a glance:

#### Definable Render Methods

- Define an `addToFormData($data)` method in your class to add to the available data within the `form:create` tag pair.
- Define an `addToFormAttributes()` method in your class to add custom HTML attributes to your `<form>` element.
- Define an `addToRenderableFieldData($field, $data)` method in your class to add to the available data for each field within the `fields` loop.
- Define an `addToRenderableFieldAttributes($field)` method in your class to add custom HTML attributes to each pre-rendered `field` field input within the `fields` loop.
- Define a `render($html)` method to control the overall rendering of your form component HTML.

#### Callable Helper Methods

- Call `$this->getInitialFormData()` to get the initial form field values from the server, while respecting old input when there are validation errors, etc.

#### Driver Properties

- The `$this->form` property gives you access to the relevant `Statamic\Forms\Form` object anywhere within your driver class.
- The `$this->options` property gives you access to the passed [driver options](#driver-options).

### Driver Options

You can also pass comma-delimited options into the `js` parameter like so:

::tabs

::tab antlers
```antlers
{{ form:contact js="radjs:foo:bar" }}
    ...
{{ /form:contact }}
```
::tab blade
```blade
<s:form:contact js="radjs:foo:bar">
    ...
</s:form:contact>
```
::

Within your driver class, you'll be able to access `$this->options` to retrieve an array of options (ie. `['foo', 'bar']` in the example above).

### The Helpers.js Script

The `Statamic.$conditions.showField(conditions, data)` helper is available when including the `helpers.js` script:

```html
<script src="/vendor/statamic/frontend/js/helpers.js"></script>
```

The `conditions` parameter accepts your field's conditions, typically generated using `$field->conditions()`.

The `data` parameter accept's an object containing your form's values, typically stored somewhere within your form's javascript state.

This JS helper will evaluate your [field conditions](/conditional-fields#overview) in realtime against your form's field values to determine whether or not the field in question should be shown.

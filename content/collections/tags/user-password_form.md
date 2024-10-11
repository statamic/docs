---
id: d592bbbf-9bf4-4043-80bb-158e0da497f7
blueprint: tag
title: 'User:Password_Form'
description: 'Creates a user password update form'
parameters:
  -
    name: redirect
    type: string
    description: |
      Where the user should be taken after successfully saving.
  -
    name: error_redirect
    type: string
    description: |
      The same as `redirect`, but for failed a failed submission.
  -
    name: allow_request_redirect
    type: boolean
    description: 'When set to true, the `redirect` and `error_redirect` parameters will get overridden by `redirect` and `error_redirect` query parameters in the URL.'
  -
    name: 'HTML Attributes'
    type: null
    description: |
      Set HTML attributes as if you were in an HTML element. For example, `class="required" id="profile-form"`.
variables:
  -
    name: fields
    type: array
    description: |
      An array of available fields for [dynamic rendering](#dynamic-rendering).
  -
    name: errors
    type: array
    description: 'An array of validation errors.'
  -
    name: error
    type: array
    description: 'An array of validation errors indexed by field names. Suitable for targeting fields. eg. `{{ error:email }}`'
  -
    name: old
    type: array
    description: 'An array of previously submitted values.'
  -
    name: success
    type: string
    description: 'A success message.'
---
## Overview

User tags are designed for sites that have areas or features behind a login. The `user:password_form` tag allows your users to change their password.

The tag will render the opening and closing `<form>` HTML elements for you.

### Example

A basic user password form, with validation errors.


::tabs

::tab antlers
```antlers
{{ user:password_form }}

    {{ if errors }}
        <div class="bg-red-300 text-white p-2">
            {{ errors }}
                {{ value }}<br>
            {{ /errors }}
        </div>
    {{ /if }}

    {{ if success }}
        <div class="bg-green-300 text-white p-2">
            {{ success }}<br>
        </div>
    {{ /if }}

    <label>Current Password</label>
    <input type="password" name="current_password" />

    <label>New Password</label>
    <input type="password" name="password" />

    <label>Confirm Password</label>
    <input type="password" name="password_confirmation" />

    <button type="submit">Save</button>

{{ /user:password_form }}
```
::tab blade
```blade
<s:user:password_form>
  @if ($errors)
    <div class="bg-red-300 text-white p-2">
      @foreach ($errors as $error)
        {{ $error }}<br>
      @endforeach
    </div>
  @endif

  @if ($success)
    <div class="bg-green-300 text-white p-2">
      {{ $success }}<br>
    </div>
  @endif

  <label>Current Password</label>
  <input type="password" name="current_password" />

  <label>New Password</label>
  <input type="password" name="password" />

  <label>Confirm Password</label>
  <input type="password" name="password_confirmation" />

  <button type="submit">Save</button>
</s:user:password_form>
```
::

## Dynamic Rendering

Instead of hardcoding individual fields, you may loop through the `fields` array to render fields more dynamically.


::tabs

::tab antlers
```antlers
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
::tab blade
```blade
<s:user:password_form>

  @foreach ($fields as $field)
    <div class="p-2">
      <label>{{ $field['display'] }}</label>
      <div class="p-1">{!! $field['field'] !!}</div>
      @if ($field['error'])
        <p class="text-gray-500">{{ $field['error'] }}</p>
      @endif
    </div>
  @endforeach

</s:user:password_form>
```
::

Each item in the `fields` array contains `type`, `display` and `handle`, which are configurable from the `user` blueprint.

You will also find the field's `old` input on unsuccessful submission, as well as an `error` message when relevant.

Finally, the `field` value contains a pre-rendered form input.  Using this will intelligently render inputs as inputs, textareas as textareas, and snozzberries as snozzberries.  You can customize these pre-rendered templates by running `php artisan vendor:publish --tag=statamic-forms`, which will expose editable templates in your `views/vendor/statamic/forms/fields` folder.


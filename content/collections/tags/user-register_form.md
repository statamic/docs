---
title: User:Register_Form
description: Creates user registration forms
parameters:
  -
    name: redirect
    type: string
    description: >
      Where the user should be taken after
      successfully registering.
  -
    name: error_redirect
    type: string
    description: >
      The same as `redirect`, but for failed registrations.
  -
    name: allow_request_redirect
    type: boolean
    description: When set to true, the `redirect` and `error_redirect` parameters will get overridden by `redirect` and `error_redirect` query parameters in the URL.
  -
    name: HTML Attributes
    type:
    description: >
      Set HTML attributes as if you were in an HTML element. For example, `class="required" id="registration-form"`.
variables:
  -
    name: fields
    type: array
    description: >
      An array of available fields for [dynamic rendering](#dynamic-rendering).
  -
    name: errors
    type: array
    description: An array of validation errors.
  -
    name: error
    type: array
    description: An array of validation errors indexed by field names. Suitable for targeting fields. eg. `{{ error:email }}`
  -
    name: old
    type: array
    description: An array of previously submitted values.
  -
    name: success
    type: string
    description: A success message.
id: 9323ebd8-c36c-4f0f-b73a-cb5ac4544e72
---
## Overview

User tags are designed for sites that have areas or features behind a login. The `user:registration_form` tag helps you build a public registration form for new users.

The tag will render the opening and closing `<form>` HTML elements for you. The rest of the form markup is up to you as long as you have `email`, `password`, and `password_confirmation` input fields.

### Example

A basic registration form, with validation errors.

::tabs

::tab antlers
```antlers
{{ user:register_form }}

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

    <label>Email</label>
    <input type="email" name="email" value="{{ old:email }}" />

    <label>Password</label>
    <input type="password" name="password" />

    <label>Password Confirmation</label>
    <input type="password" name="password_confirmation" />

    <button>Register</button>

{{ /user:register_form }}
```
::tab blade
```blade
<s:user:register_form>
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

  <label>Email</label>
  <input type="email" name="email" value="{{ old('email') }}" />

  <label>Password</label>
  <input type="password" name="password" />

  <label>Password Confirmation</label>
  <input type="password" name="password_confirmation" />

  <button>Register</button>
</s:user:register_form>
```
::

## Password Rules

You may also customize your password rules by explicitly setting a `password` field in your `user.yaml` blueprint.

```yaml
-
  handle: password
  field:
    type: text
    display: Password
    input: password
    validate: 'min:8|alpha_num'
```

## Additional Fields

You are allowed to add any additional fields to your registration form, and they will be added to the user's account provided that they exist in the `user.yaml` blueprint.

Any submitted data that does _not_ exist in the blueprint will be completely ignored.

Additional fields will be validated as per your blueprint `validate` rules.

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
<s:user:register_form>

  @foreach ($fields as $field)
    <div class="p-2">
      <label>{{ $field['display'] }}</label>
      <div class="p-1">{!! $field['field'] !!}</div>

      @if ($field['error'])
        <p class="text-gray-500">{{ $field['error'] }}</p>
      @endif
    </div>
  @endforeach

</s:user:register_form>
```
::

Each item in the `fields` array contains `type`, `display` and `handle`, which are configurable from the `user` blueprint.

You will also find the field's `old` input on unsuccessful submission, as well as an `error` message when relevant.

Finally, the `field` value contains a pre-rendered form input.  Using this will intelligently render inputs as inputs, textareas as textareas, and snozzberries as snozzberries.  You can customize these pre-rendered templates by running `php artisan vendor:publish --tag=statamic-forms`, which will expose editable templates in your `views/vendor/statamic/forms/fields` folder.

## New User Roles

Most of the time, new members will need some roles assigned to them so that they can do different things on your site. You can configure the default `new_user_roles` in your `config/statamic/users.php` config. When a user successfully registers as a member, their account will automatically be assigned the roles in this list.

It’s best to remember that these are _starting_ roles for the user. You can later either manually add roles to users in their files, update their account through the Control Panel, or have add-ons automatically add or remove roles as needed when users perform certain tasks.

## Honeypot

If you want to protect your registration form from spam bots you can specify the handle of a [honeypot field](/forms#honeypot) in `config/statamic/users.php` using the `registration_form_honeypot_field` key.


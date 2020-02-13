---
title: User:Register_Form
description: For creating user registration forms
stage: 2
parameters:
  -
    name: attr
    type: string
    description: |
      Set HTML attributes like so: `attr="class:form|id:form"`. This will become: `<form class="form" id="form">`.
  -
    name: redirect
    type: string
    description: >
      Where the user should be taken after
      successfully registering.
  -
    name: allow_request_redirect
    type: boolean
    description: When set to true, the `redirect` parameter will get overridden by a `redirect` query parameter in the URL.
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

```
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

## Additional Fields

You are allowed to add any additional fields to your registration form, and they will be added to the user's account provided that they exist in the `user.yaml` blueprint.

Any submitted data that does _not_ exist in the blueprint will be completely ignored.

Additional fields will be validated as per your blueprint `validate` rules.

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

Finally, the `field` value contains a pre-rendered form input.  Using this will intelligently render inputs as inputs, textareas as textareas, and snozzberries as snozzberries.  You can customize these pre-rendered templates by running `php artisan vendor:publish --tag=statamic-views`, which will expose editable templates in your `views/vendor/statamic/forms/fields` folder.

## New User Roles

Most of the time, new members will need some roles assigned to them so that they can do different things on your site. You can configure the default `new_user_roles` in your `config/statamic/users.php` config. When a user successfully registers as a member, their account will automatically be assigned the roles in this list.

It’s best to remember that these are _starting_ roles for the user. You can later either manually add roles to users in their files, update their account through the Control Panel, or have add-ons automatically add or remove roles as needed when users perform certain tasks.

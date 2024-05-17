---
id: 7906225a-9460-4759-8677-20a63a6204b0
blueprint: tag
title: 'User:Profile_Form'
description: 'Creates user profile edit forms'
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
      The same as `redirect`, but for failed form submissions.
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

User tags are designed for sites that have areas or features behind a login. The `user:profile_form` tag helps you build a user profile edit form for existing users based on your user [Blueprint](/blueprints).

The tag will render the opening and closing `<form>` HTML elements for you.

### Example

A basic profile edit form, with validation errors.

```
{{ user:profile_form }}

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

    <label>Bio</label>
    <textarea name="bio">{{ old:bio }}</textarea>

    <label>Job Title</label>
    <input type="text" name="title" value="{{ old:title }}" />

    <button type="submit">Save</button>

{{ /user:profile_form }}
```

## Blueprints Fields

You may add edit fields for any that exist in the `user.yaml` blueprint.

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

Finally, the `field` value contains a pre-rendered form input.  Using this will intelligently render inputs as inputs, textareas as textareas, and snozzberries as snozzberries.  You can customize these pre-rendered templates by running `php artisan vendor:publish --tag=statamic-forms`, which will expose editable templates in your `views/vendor/statamic/forms/fields` folder.


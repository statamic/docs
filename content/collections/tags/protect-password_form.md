---
id: 2a2ec438-4274-4de7-9261-94221507e6c6
title: 'Protect:Password_Form'
intro: 'This tag is used to create a custom content [password protection](/protecting-content#password) form.'
parameters:
  -
    name: HTML Attributes
    type: string
    description: >
      Set HTML attributes as if you were on an HTML element. For example, `class="required" id="contact-form"`.
variables:
  -
    name: invalid_token
    type: boolean
    description: |
      Returns `true` when the token is missing or invalid. Functionally the same as the `no_token` variable.
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
    description: A success message that can be used in a condition to check if the password was valid. `{{ if success }} Welcome to Narnia! {{ /if }}`
related_entries:
  - 75be125b-7d92-496c-ac5d-7098560d3d44
---
## Overview

The HTML of the form itself is up to you. The only requirement is to name the password input `password` and wrap the form with the tag pair.

Any variables from the protected entry will also be available in the password form.

## Example

::tabs

::tab antlers
```antlers
{{ protect:password_form }}
    {{ if invalid_token }}
        No token has been provided.
    {{ else }}

        {{ if error }}
            <div class="error">{{ error }}</div>
        {{ /if }}

        <input type="password" name="password" />

        {{ errors:password }}
            <div class="inline-error">{{ value }}</div>
        {{ /errors:password }}

        <button>Submit</button>

    {{ /if }}
{{ /protect:password_form }}
```
::tab blade
```blade
<s:protect:password_form>
  @if ($no_token)
    No token has been provided.
  @else
    @if ($error)
      <div class="error">{{ $error }}</div>
    @endif

    <input type="password" name="password" />

    @if (isset($errors['password']))
      @foreach ($errors['password'] as $error)
        <div class="inline-error">{{ $error }}</div>
      @endforeach
    @endif

    <button>Submit</button>
  @endif
</s:protect:password_form>
```
::

### Tokens

When visiting a password protected page, Statamic generates a token and appends it to the form’s URL. Without this token, the form cannot function correctly. This is to combat brute-forcing and bots.

In the example above, you can see the `invalid_token` boolean will be populated for you. This may happen if you visit the form URL directly.

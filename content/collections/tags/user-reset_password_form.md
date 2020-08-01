---
title: User:Reset_Password_Form
description: >
  For creating a user password reset form
parameters:
  -
    name: redirect
    type: string
    description: >
      The URL the user will be taken after the
      form is successfully submitted. Leaving
      this blank will keep the user on the
      same page.
variables:
  -
    name: success
    type: boolean
    description: "This will be `true` if the form has been submitted successfully. If you don't use the `redirect` parameter, you can keep your users on the same page and show a success message."
  -
    name: url_invalid
    type: boolean
    description: This will be `true` if the `code` query parameter is missing/incorrect, or if the `user` query parameter is invalid.
  -
    name: errors
    type: array
    description: An array of validation errors.
id: e39fad1d-8b31-4dba-b32e-a0048084d178
---

## The form {#form}

Here's a basic reset password form. A user will enter and confirm their new password.

Since we don’t set a `redirect` parameter, the user will come right back here after
submitting, where the `success` condition will kick in and they will be shown a success message.

```
{{ user:reset_password_form }}

    {{ if success }}

        <p class="alert alert-success">Password has been reset.</p>

    {{ elseif url_invalid }}

        <p class="alert alert-danger">This reset URL is invalid.</p>

    {{ else }}

        {{ if errors }}
            <div class="alert alert-danger">
                {{ errors }}
                    {{ value }}<br>
                {{ /errors }}
            </div>
        {{ /if }}

        <label>E-Mail</label>
        <input type="email" name="email" />

        <label>Password</label>
        <input type="password" name="password" />

        <label>Password Confirmation</label>
        <input type="password" name="password_confirmation" />

        <button>Submit</button>

    {{ /if }}

{{ /user:reset_password_form }}
```

Visiting the URL containing this form _directly_ will set a `url_invalid` invalid variable you can use to check if they've actually come from the form in their previous request.

This URL needs to have the appropriate `user` and `code` query parameters (e.g. /some/url?user=username&code="abc123"`

These can be created automatically using a `user:forgot_password_form`.

---
title: User:Reset_Password_Form
description: Creates a "Create a New Password" form
intro: This tag is used to to set a new password _after_ a user has received the reset link from the "forgot my password" form.
parameters:
  -
    name: redirect
    type: string
    description: >
      The URL the user will be taken after the
      form is successfully submitted. Leaving
      this blank will keep the user on the
      same page.
  -
    name: error_redirect
    type: string
    description: >
      The same as `redirect`, but for failed validation errors.
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
stage: 4
id: e39fad1d-8b31-4dba-b32e-a0048084d178
---
## Overview

After a user has put their email address into the [user:forgot_password_form](/tags/user-forgot_password_form), they'll arrive here to reset their password. This is the form used to create a _new_ password. That's really all there is to it.

## Example


::tabs

::tab antlers
```antlers
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
::tab blade
```blade
<s:user:reset_password_form>
  @if ($success)
    <p class="alert alert-success">Password has been reset.</p>
  @elseif ($url_invalid)
    <p class="alert alert-danger">This reset URL is invalid.</p>
  @else

    @if ($errors)
      <div class="alert alert-danger">
        @foreach ($errors as $error)
          {{ $error }}<br>
        @endforeach
      </div>
    @endif

    <label>E-Mail</label>
    <input type="email" name="email" />

    <label>Password</label>
    <input type="password" name="password" />

    <label>Password Confirmation</label>
    <input type="password" name="password_confirmation" />

    <button>Submit</button>
  @endif
</s:user:reset_password_form>
```
::

## Arriving at this URL

This URL needs to have the appropriate `token` query parameter (e.g. `/some/url?token=the-generated-token-goes-here`)

Visiting the URL containing this form _directly_ will set a `url_invalid` variable. You can use this variable to check if they've actually arrived here through the password reset mail. This variable just checks whether there is a `token` query parameter available in the URL. This token will then be sent along with the email address and new password they fill out in an attempt to reset their password. If the token is incorrect, a validation error will be shown after submitting the form.

The reset password mail which contains the right `token` may be sent by using a `user:forgot_password_form` tag.

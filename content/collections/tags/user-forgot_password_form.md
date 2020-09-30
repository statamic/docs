---
title: User:Forgot_Password_Form
description: Creates a "Forgot Password" form
intro: This tag is used to create a "forgot my password" form for your users.
parameters:
  -
    name: redirect
    type: string
    description: >
      Where the user should be taken after requesting a password reset.
  -
    name: error_redirect
    type: string
    description: >
      The same as `redirect`, but for for failed password reset requests.
  -
    name: allow_request_redirect
    type: boolean
    description: When set to true, the `redirect` and `error_redirect` parameters will get overridden by `redirect` and `error_redirect` query parameters in the URL.
  -
    name: reset_url
    type: string
    description: >
      The URL containing your Reset Password
      Form. A link to this URL will be
      included in the email, along with the
      appropriate query parameters.
  -
    name: HTML Attributes
    type:
    description: >
      Set HTML attributes as if you were in an HTML element. For example, `class="required" id="registration-form"`.
variables:
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
  -
    name: email_sent
    type: string
    description: An alias of the `success` variable.
stage: 4
id: 3e69f12e-72ac-4f1a-9847-fa08d651e750
---
## Overview

Users will enter their email address in the form and, upon submitting, an email will be sent with a link to create a new password.

Unless you set a `redirect` parameter, the user will be redirected back to the **same page** after submitting, and the `success` variable will allow you to show a success message.

## Example

```
{{ user:forgot_password_form reset_url="/reset-password" }}

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
    <input type="text" name="email" value="{{ old:email }}" />

    <button type="submit">Send Reset Email</button>

{{ /user:forgot_password_form }}
```

The email will contain a link to the URL specified in the `reset_url` parameter, along with extra query parameters. On that URL you must have a [user:reset_password_form](/tags/user-reset_password_form) tag to finish the task and let the user set their new password.

> The user needs to be logged out for this tag to do anything. You may way to wrap the form in `{{ if logged_out }}{{ /if }}`.

## The email {#email}

Once the form is submitted, an email will be sent containing the URL for resetting the password.

This email is bundled with Statamic and will work for most people out of the box. However, if you'd like to customize it, you can. [Here's how to create custom emails][custom-emails].

The template is named `user-reset` and should contain a `{{ reset_url }}` variable, which is the generated reset URL.

[custom-emails]: /knowledge-base/emails#templates

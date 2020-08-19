---
title: User:Forgot_Password_Form
description: Creates a "Forgot Password" form
intro: This tag is used to create a "forgot my password" form for your users.
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
    name: allow_request_redirect
    type: boolean
    description: When set to true, the `redirect` parameter will get overridden by a `redirect` query parameter in the URL.
  -
    name: reset_url
    type: string
    description: >
      The URL containing your Reset Password
      Form. A link to this URL will be
      included in the email, along with the
      appropriate query parameters.
variables:
  -
    name: success
    type: boolean
    description: "This will be `true` if the form has been submitted successfully. If you don't use the `redirect` parameter, you can keep your users on the same page and show a success message."
  -
    name: email_sent
    type: boolean
    description: The same as the `success` variable.
  -
    name: errors
    type: array
    description: An array of validation errors.
stage: 4
id: 3e69f12e-72ac-4f1a-9847-fa08d651e750
---
## Overview

Users will enter their email address in the form and, upon submitting, an email will be sent with a link to create a new password.

Unless you set a `redirect` parameter, the user will be redirected back to the **same page** after submitting, and the `email_sent` condition will will allow you to show a success message.

## Example

```
{{ user:forgot_password_form reset_url="/reset-password" }}

    {{ if email_sent }}
        <p>Email sent!</p>
    {{ else }}

        {{ if errors }}
            <div class="alert alert-danger">
                {{ errors }}
                    {{ value }}<br>
                {{ /errors }}
            </div>
        {{ /if }}

        <label>Email Address</label>
        <input type="text" name="email" />
        <button>Send Reset Email</button>
    {{ /if }}

{{ /user:forgot_password_form }}
```

The email will contain a link to the URL specified in the `reset_url` parameter, along with extra query parameters. On that URL you must have a [user:reset_password_form](/tags/user-reset_password_form) tag to finish the task and let the user set their new password.

> The user needs to be logged out for this tag to do anything. You may way to wrap the form in `{{ if logged_out }}{{ /if }}`.

## The email {#email}

Once the form is submitted, an email will be sent containing the URL for resetting the password.

This email is bundled with Statamic and will work for most people out of the box. However, if you'd like to customize it, you can. [Here's how to create custom emails][custom-emails].

The template is named `user-reset` and should contain a `{{ reset_url }}` variable, which is the generated reset URL.

[custom-emails]: /knowledge-base/emails#templates

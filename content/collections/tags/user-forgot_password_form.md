---
title: User:Forgot_Password_Form
description: >
  For creating a user forgot Password (aka set new password) form
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
id: 3e69f12e-72ac-4f1a-9847-fa08d651e750
---
## The form {#form}

Here's a basic forgot password form. A user will enter their username, and an email will be
sent to the corresponding email address. Since we don't set a `redirect` parameter, the user
will come right back here after submitting, where the `email_sent` condition will kick in
and they will be shown a success message.

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

        <label>Username</label>
        <input type="text" name="username" />

        <button>Send email</button>

    {{ /if }}

{{ /user:forgot_password_form }}
```

The email that they receive will contain a link to the URL specified in the `reset_url` parameter
along with some extra query parameters. On that page, you should add a `user:reset_password_form`
tag, so they can reset their password.

## The email {#email}

Once the form is submitted, an email will be sent containing the URL for resetting the password.

This email is bundled with Statamic and will work for most people out of the box. However, if you'd
like to customize it, you can. [Find out how to write custom emails][custom-emails]. The template
used is `user-reset` and should contain a `{{ reset_url }}` variable, which is the generated reset URL.

[custom-emails]: /knowledge-base/emails#templates

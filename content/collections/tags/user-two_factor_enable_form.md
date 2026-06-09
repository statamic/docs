---
title: User:Two_Factor_Enable_Form
description: Renders the first step of 2FA setup — generates the user's 2FA secret
intro: Step one of the two-factor authentication setup flow. Submitting this form generates a 2FA secret for the user and sends them on to the setup page where they confirm the code.
parameters:
  -
    name: redirect
    type: string
    description: Where the user should be taken after their 2FA secret has been generated. Typically this is the page that renders `{{ user:two_factor_setup_form }}`.
  -
    name: allow_request_redirect
    type: boolean
    description: When set to true, the `redirect` parameter will get overridden by a `redirect` query parameter in the URL.
  -
    name: HTML Attributes
    type:
    description: >
      Set HTML attributes as if you were in an HTML element. For example, `class="required" id="2fa-enable-form"`.
variables:
  -
    name: errors
    type: array
    description: An array of validation errors.
  -
    name: error
    type: array
    description: An array of validation errors indexed by field names.
  -
    name: success
    type: string
    description: A success message.
id: 8f4c6868-0aee-4814-a498-a4e118c2f400
---
## Overview

The `user:two_factor_enable_form` tag renders **step one** of the two-factor authentication setup flow. Submitting it generates the user's 2FA secret (and eventually their recovery codes, once they confirm), then redirects them on to the setup page where the QR code and confirmation form are displayed.

The tag will render the opening and closing `<form>` HTML elements for you. No input fields are required — just a submit button.

:::tip
This form only renders for an authenticated user who does **not** already have 2FA enabled. It also requires an [elevated session](/tags/user-elevated_session_form) — if the session isn't elevated, the user will be redirected to confirm their identity first.
:::

### Example

::tabs

::tab antlers
```antlers
{{ user:two_factor_enable_form redirect="/account/2fa/setup" }}

    {{ if errors }}
        <div class="bg-red-300 text-white p-2">
            {{ errors }}
                {{ value }}<br>
            {{ /errors }}
        </div>
    {{ /if }}

    <p>Click below to start setting up two-factor authentication. You'll be taken to a page where you can scan a QR code with your authenticator app.</p>

    <button type="submit">Set Up Two-Factor Authentication</button>

{{ /user:two_factor_enable_form }}
```
::tab blade
```blade
<s:user:two_factor_enable_form redirect="/account/2fa/setup">
    @if ($errors)
        <div class="bg-red-300 text-white p-2">
            @foreach ($errors as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif

    <p>Click below to start setting up two-factor authentication. You'll be taken to a page where you can scan a QR code with your authenticator app.</p>

    <button type="submit">Set Up Two-Factor Authentication</button>
</s:user:two_factor_enable_form>
```
::

## Redirect behavior

After the secret is generated, Statamic decides where to send the user in the following order:

1. The form's `redirect` parameter (submitted as `_redirect`).
2. The `statamic.users.two_factor_setup_url` config key in `config/statamic/users.php`.
3. The referring page (i.e. back to where the form was rendered).

Whichever destination is used, that page should render [`{{ user:two_factor_setup_form }}`](/tags/user-two_factor_setup_form) so the user can complete setup.

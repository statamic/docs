---
title: User:Two_Factor_Challenge_Form
description: Renders a form for users to enter their 2FA code during login
intro: When a user with two-factor authentication enabled logs in, they need to verify their identity with a code from their authenticator app. This tag renders that verification form.
parameters:
  -
    name: redirect
    type: string
    description: Where the user should be taken after successful verification.
  -
    name: error_redirect
    type: string
    description: Where the user should be redirected on validation errors.
  -
    name: allow_request_redirect
    type: boolean
    description: When set to true, the `redirect` and `error_redirect` parameters will get overridden by `redirect` and `error_redirect` query parameters in the URL.
  -
    name: HTML Attributes
    type:
    description: >
      Set HTML attributes as if you were in an HTML element. For example, `class="required" id="2fa-form"`.
variables:
  -
    name: errors
    type: array
    description: An array of validation errors.
  -
    name: error
    type: array
    description: An array of validation errors indexed by field names. Suitable for targeting fields. eg. `{{ error:code }}`
  -
    name: success
    type: string
    description: A success message.
id: 3a8e9b4c-5d7f-4a2b-8c1e-6f9d0a3b5c7e
---
## Overview

The `user:two_factor_challenge_form` tag renders a form for users to complete the second step of two-factor authentication. After submitting valid credentials on the login form, users with 2FA enabled are redirected to this challenge form.

The tag will render the opening and closing `<form>` HTML elements for you. Users can verify their identity by entering either a `code` from their authenticator app or a `recovery_code`.

:::tip
This form will only render content if there's a pending 2FA challenge in the session. If accessed without a pending challenge, the form contents won't be displayed.
:::

### Example

::tabs

::tab antlers
```antlers
{{ user:two_factor_challenge_form redirect="/dashboard" }}

    {{ if errors }}
        <div class="bg-red-300 text-white p-2">
            {{ errors }}
                {{ value }}<br>
            {{ /errors }}
        </div>
    {{ /if }}

    <p>Enter the 6-digit code from your authenticator app:</p>
    <input type="text" name="code" inputmode="numeric" autocomplete="one-time-code" maxlength="6" />

    <p>Or use a recovery code:</p>
    <input type="text" name="recovery_code" />

    <button type="submit">Verify</button>

{{ /user:two_factor_challenge_form }}
```
::tab blade
```blade
<s:user:two_factor_challenge_form redirect="/dashboard">
    @if ($errors)
        <div class="bg-red-300 text-white p-2">
            @foreach ($errors as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif

    <p>Enter the 6-digit code from your authenticator app:</p>
    <input type="text" name="code" inputmode="numeric" autocomplete="one-time-code" maxlength="6" />

    <p>Or use a recovery code:</p>
    <input type="text" name="recovery_code" />

    <button type="submit">Verify</button>
</s:user:two_factor_challenge_form>
```
::

## Redirect Behavior

If you don't specify a `redirect` parameter, the form will use the `redirect` value from the original login form. This allows you to specify the redirect destination once on the login form and have it carry through the entire 2FA flow.

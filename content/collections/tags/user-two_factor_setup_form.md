---
title: User:Two_Factor_Setup_Form
description: Renders a form for authenticated users to set up 2FA on their account
intro: Allow your users to enable two-factor authentication on their accounts. This tag provides everything needed to display a QR code and verify the setup.
parameters:
  -
    name: redirect
    type: string
    description: Where the user should be taken after successful setup (e.g., a recovery codes page).
  -
    name: error_redirect
    type: string
    description: Where the user should be redirected on validation errors.
  -
    name: HTML Attributes
    type:
    description: >
      Set HTML attributes as if you were in an HTML element. For example, `class="required" id="2fa-setup-form"`.
variables:
  -
    name: qr_code
    type: string
    description: SVG markup for the QR code that can be rendered directly in the template.
  -
    name: qr_code_url
    type: string
    description: A data URL for the QR code, suitable for use with an `<img>` tag's `src` attribute.
  -
    name: secret_key
    type: string
    description: The TOTP secret key for users who prefer to enter it manually into their authenticator app.
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
id: 4b9f0c5d-6e8a-4b3c-9d2f-7a0e1b4c6d8f
---
## Overview

The `user:two_factor_setup_form` tag renders a form for authenticated users to enable two-factor authentication. The form displays a QR code that users scan with their authenticator app, and requires them to enter a verification code to confirm the setup.

The tag will render the opening and closing `<form>` HTML elements for you. You'll need to provide a `code` input field for the verification code.

:::tip
This form requires the user to be authenticated. If the user already has 2FA enabled, the form contents won't be rendered.
:::

### Example

::tabs

::tab antlers
```antlers
{{ user:two_factor_setup_form redirect="/account/recovery-codes" }}

    {{ if errors }}
        <div class="bg-red-300 text-white p-2">
            {{ errors }}
                {{ value }}<br>
            {{ /errors }}
        </div>
    {{ /if }}

    <h2>Set Up Two-Factor Authentication</h2>

    <p>Scan this QR code with your authenticator app:</p>

    {{# Option 1: Render SVG directly #}}
    <div class="qr-code">
        {{ qr_code }}
    </div>

    {{# Option 2: Use as image source #}}
    <img src="{{ qr_code_url }}" alt="QR Code" width="200" height="200" />

    <p>Or enter this code manually: <code>{{ secret_key }}</code></p>

    <label>
        Enter the 6-digit code from your app to confirm:
        <input type="text" name="code" inputmode="numeric" autocomplete="one-time-code" maxlength="6" />
    </label>

    <button type="submit">Enable Two-Factor Authentication</button>

{{ /user:two_factor_setup_form }}
```
::tab blade
```blade
<s:user:two_factor_setup_form redirect="/account/recovery-codes">
    @if ($errors)
        <div class="bg-red-300 text-white p-2">
            @foreach ($errors as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif

    <h2>Set Up Two-Factor Authentication</h2>

    <p>Scan this QR code with your authenticator app:</p>

    {{-- Option 1: Render SVG directly --}}
    <div class="qr-code">
        {!! $qr_code !!}
    </div>

    {{-- Option 2: Use as image source --}}
    <img src="{{ $qr_code_url }}" alt="QR Code" width="200" height="200" />

    <p>Or enter this code manually: <code>{{ $secret_key }}</code></p>

    <label>
        Enter the 6-digit code from your app to confirm:
        <input type="text" name="code" inputmode="numeric" autocomplete="one-time-code" maxlength="6" />
    </label>

    <button type="submit">Enable Two-Factor Authentication</button>
</s:user:two_factor_setup_form>
```
::



## Displaying the QR code

You have two options for displaying the QR code:

1. **SVG Markup** (`qr_code`): Renders directly in the HTML. This is generally preferred as it scales well and doesn't require an additional request.

2. **Data URL** (`qr_code_url`): Use with an `<img>` tag if you prefer image-based rendering or need more control over sizing.

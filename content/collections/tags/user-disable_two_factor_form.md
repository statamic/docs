---
title: User:Disable_Two_Factor_Form
description: Renders a form to disable 2FA on the user's account
intro: Allow users to turn off two-factor authentication. If their role requires 2FA, they'll be prompted to set it up again.
parameters:
  -
    name: redirect
    type: string
    description: Where the user should be taken after disabling 2FA.
  -
    name: setup_url
    type: string
    description: URL to redirect to if the user's role requires 2FA. They will need to set it up again immediately.
  -
    name: HTML Attributes
    type:
    description: >
      Set HTML attributes as if you were in an HTML element. For example, `class="disable-form"`.
variables:
  -
    name: success
    type: string
    description: A success message.
id: 8f3d4a9b-0c2e-4f7a-3b6d-1e4f5a8b0c2d
---
## Overview

The `user:disable_two_factor_form` tag renders a form that allows authenticated users to disable two-factor authentication on their account. This removes the 2FA requirement and deletes their recovery codes.

The tag will render the opening and closing `<form>` HTML elements for you. No input fields are required—just a submit button.

:::tip
This form requires the user to be authenticated with 2FA enabled and an [elevated session](/tags/user-elevated_session_form). If the session isn't elevated, the user will be redirected to confirm their identity first.
:::

### Example

::tabs

::tab antlers
```antlers
{{ user:disable_two_factor_form redirect="/account" setup_url="/account/setup-2fa" }}

    {{ if success }}
        <div class="bg-green-300 text-white p-2">
            {{ success }}
        </div>
    {{ /if }}

    <p>Are you sure you want to disable two-factor authentication?</p>
    <button type="submit">Disable Two-Factor Authentication</button>

{{ /user:disable_two_factor_form }}
```
::tab blade
```blade
<s:user:disable_two_factor_form redirect="/account" setup_url="/account/setup-2fa">
    @if ($success)
        <div class="bg-green-300 text-white p-2">
            {{ $success }}
        </div>
    @endif

    <p>Are you sure you want to disable two-factor authentication?</p>
    <button type="submit">Disable Two-Factor Authentication</button>
</s:user:disable_two_factor_form>
```
::

## Enforced 2FA

If the user belongs to a role that has 2FA enforced (configured via `two_factor_enforced_roles` in your config), they will be redirected to the `setup_url` after disabling. This ensures they immediately set up 2FA again to maintain compliance with your security requirements.

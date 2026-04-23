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
    name: allow_request_redirect
    type: boolean
    description: When set to true, the `redirect` parameter will get overridden by a `redirect` query parameter in the URL.
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
{{ user:disable_two_factor_form redirect="/account" }}

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
<s:user:disable_two_factor_form redirect="/account">
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

If the user belongs to a role that has 2FA enforced (configured via `two_factor_enforced_roles` in your config), they can't really stay signed in with 2FA off — so after the form is submitted, Statamic ignores the `redirect` parameter and sends them to the setup page instead. That destination is pulled from the `statamic.users.two_factor_setup_url` config key in `config/statamic/users.php`, falling back to Statamic's built-in setup route if that's left `null`.

---
title: User:Reset_Two_Factor_Recovery_Codes_Form
description: Renders a form to generate new recovery codes
intro: If a user has used some of their recovery codes or suspects they've been compromised, they can generate a fresh set. This invalidates all existing codes.
parameters:
  -
    name: redirect
    type: string
    description: Where the user should be taken after generating new codes.
  -
    name: HTML Attributes
    type:
    description: >
      Set HTML attributes as if you were in an HTML element. For example, `class="reset-form"`.
variables:
  -
    name: success
    type: string
    description: A success message.
id: 7e2c3f8a-9b1d-4e6f-2a5c-0d3e4f7a9b1c
---
## Overview

The `user:reset_two_factor_recovery_codes_form` tag renders a form that allows authenticated users to generate a new set of recovery codes. When submitted, all existing recovery codes are invalidated and replaced with new ones.

The tag will render the opening and closing `<form>` HTML elements for you. No input fields are required—just a submit button.

:::tip
This form requires the user to be authenticated with 2FA enabled and an [elevated session](/tags/user-elevated_session_form). If the session isn't elevated, the user will be redirected to confirm their identity first.
:::

### Example

::tabs

::tab antlers
```antlers
{{ user:reset_two_factor_recovery_codes_form redirect="/account/recovery-codes" }}

    {{ if success }}
        <div class="bg-green-300 text-white p-2">
            {{ success }}
        </div>
    {{ /if }}

    <p>Generate new recovery codes? Your current codes will be invalidated.</p>
    <button type="submit">Generate New Codes</button>

{{ /user:reset_two_factor_recovery_codes_form }}
```
::tab blade
```blade
<s:user:reset_two_factor_recovery_codes_form redirect="/account/recovery-codes">
    @if ($success)
        <div class="bg-green-300 text-white p-2">
            {{ $success }}
        </div>
    @endif

    <p>Generate new recovery codes? Your current codes will be invalidated.</p>
    <button type="submit">Generate New Codes</button>
</s:user:reset_two_factor_recovery_codes_form>
```
::

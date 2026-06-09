---
title: User:Two_Factor_Recovery_Codes
description: Displays the user's 2FA recovery codes
intro: Recovery codes provide a backup way for users to access their account if they lose their authenticator device. This tag displays those codes.
variables:
  -
    name: code
    type: string
    description: A single recovery code.
id: 5c0a1d6e-7f9b-4c4d-0e3a-8b1f2c5d7e9a
---
## Overview

The `user:two_factor_recovery_codes` tag loops through and displays the authenticated user's recovery codes. Each recovery code can only be used once to log in if the user doesn't have access to their authenticator app.

:::tip
This tag requires the user to be authenticated with 2FA enabled. If 2FA is not enabled, the tag won't render any content.
:::

### Example

::tabs

::tab antlers
```antlers
{{ if {user:two_factor_enabled} }}
    <h2>Your Recovery Codes</h2>
    <p>Store these codes in a safe place. Each code can only be used once.</p>

    <ul class="recovery-codes">
        {{ user:two_factor_recovery_codes }}
            <li><code>{{ code }}</code></li>
        {{ /user:two_factor_recovery_codes }}
    </ul>
{{ else }}
    <p>You don't have two-factor authentication enabled.</p>
{{ /if }}
```
::tab blade
```blade
@if (Statamic::tag('user:two_factor_enabled')->fetch())
    <h2>Your Recovery Codes</h2>
    <p>Store these codes in a safe place. Each code can only be used once.</p>

    <ul class="recovery-codes">
        <s:user:two_factor_recovery_codes>
            <li><code>{{ $code }}</code></li>
        </s:user:two_factor_recovery_codes>
    </ul>
@else
    <p>You don't have two-factor authentication enabled.</p>
@endif
```
::

:::tip
[`{{ user:two_factor_enabled }}`](/tags/user-two_factor_enabled) is a tag, not a variable, so conditionals need the extra braces: `{{ if {user:two_factor_enabled} }}`.
:::


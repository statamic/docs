---
title: User:Two_Factor_Enabled
description: Returns whether the current user has 2FA enabled
intro: A boolean tag that returns `true` when the authenticated user has two-factor authentication enabled. Useful for conditionally showing recovery code or disable UI.
id: fa2eaa81-6a76-48d1-8b37-a0abda40b09e
---
## Overview

The `user:two_factor_enabled` tag returns `true` when the currently authenticated user has confirmed their two-factor authentication setup, and `false` otherwise (including when nobody is logged in).

### Example

Because this is a tag rather than a variable, use the extra brace syntax inside conditionals:

::tabs

::tab antlers
```antlers
{{ if {user:two_factor_enabled} }}
    <h2>Your Recovery Codes</h2>
    {{ user:two_factor_recovery_codes }}
        <li><code>{{ code }}</code></li>
    {{ /user:two_factor_recovery_codes }}

    {{ user:disable_two_factor_form }}
        <button type="submit">Disable 2FA</button>
    {{ /user:disable_two_factor_form }}
{{ else }}
    {{ user:two_factor_enable_form redirect="/account/2fa/setup" }}
        <button type="submit">Enable 2FA</button>
    {{ /user:two_factor_enable_form }}
{{ /if }}
```
::tab blade
```blade
@if (Statamic::tag('user:two_factor_enabled')->fetch())
    <h2>Your Recovery Codes</h2>
    <s:user:two_factor_recovery_codes>
        <li><code>{{ $code }}</code></li>
    </s:user:two_factor_recovery_codes>

    <s:user:disable_two_factor_form>
        <button type="submit">Disable 2FA</button>
    </s:user:disable_two_factor_form>
@else
    <s:user:two_factor_enable_form redirect="/account/2fa/setup">
        <button type="submit">Enable 2FA</button>
    </s:user:two_factor_enable_form>
@endif
```
::

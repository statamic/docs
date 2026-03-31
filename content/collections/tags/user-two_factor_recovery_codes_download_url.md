---
title: User:Two_Factor_Recovery_Codes_Download_URL
description: Outputs a URL to download recovery codes as a text file
id: 6d1b2e7f-8a0c-4d5e-1f4b-9c2a3d6e8f0b
---
## Overview

The `user:two_factor_recovery_codes_download_url` tag outputs a URL that allows the authenticated user to download their recovery codes as a plain text file. This provides a convenient way for users to save their codes offline.

:::tip
This tag requires the user to be authenticated with 2FA enabled. If 2FA is not enabled, the tag returns an empty string.
:::

### Example

::tabs

::tab antlers
```antlers
{{ if current_user:two_factor_confirmed_at }}
    <a href="{{ user:two_factor_recovery_codes_download_url }}">
        Download Recovery Codes
    </a>
{{ /if }}
```
::tab blade
```blade
@if (current_user()->two_factor_confirmed_at)
    <a href="{{ Statamic::tag('user:two_factor_recovery_codes_download_url')->fetch() }}">
        Download Recovery Codes
    </a>
@endif
```
::

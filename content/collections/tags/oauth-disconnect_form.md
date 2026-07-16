---
title: 'OAuth:Disconnect_Form'
blueprint: tag
description: 'Creates a form to disconnect an OAuth provider'
intro: Renders a form that disconnects an OAuth provider from the current user's account.
parameters:
  -
    name: provider
    type: string
    description: 'The provider to disconnect. Required.'
  -
    name: HTML Attributes
    type:
    description: 'Set HTML attributes as if you were in an HTML element. For example, `class="disconnect-form"`.'
related_entries:
  - f7676fe0-abb3-4a05-8530-6d23a9b5130d
id: 9c953755-175e-48c1-a196-b840f5620587
---
## Overview

The `oauth:disconnect_form` tag renders a form to disconnect an OAuth provider from the current user's account. It's typically used inside an [`{{ oauth }}`](/tags/oauth) loop.

::tabs

::tab antlers
```antlers
{{ oauth }}
    {{ if connected }}
        {{ oauth:disconnect_form :provider="name" }}
            <button type="submit">Disconnect {{ label }}</button>
        {{ /oauth:disconnect_form }}
    {{ /if }}
{{ /oauth }}
```
::tab blade
```blade
<s:oauth>
    @if ($connected)
        <s:oauth:disconnect_form :provider="$name">
            <button type="submit">Disconnect {{ $label }}</button>
        </s:oauth:disconnect_form>
    @endif
</s:oauth>
```
::

Disconnecting requires an elevated session. If the user doesn't have one, they'll be redirected to do so before being sent back to complete the disconnect.

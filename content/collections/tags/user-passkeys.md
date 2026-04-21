---
id: 38323438-4719-4a7b-ba5a-8abfe0d7dfc0
blueprint: tag
title: 'User:Passkeys'
description: 'Lists the current user''s passkeys'
intro: 'Loop through the authenticated user''s registered passkeys.'
variables:
  -
    name: id
    type: string
    description: 'The passkey identifier.'
  -
    name: name
    type: string
    description: 'The user-defined passkey name.'
  -
    name: last_login
    type: Carbon
    description: 'The last time the passkey was used for login, or null if never used.'
related_entries:
    - 7432f1cb-7418-4d54-8e65-51b1ae3bcb3a
    - 7a958307-4cdb-47f3-a689-0c7de57e3ff7
    - d0ed4ac0-536a-47a1-965b-202b52baddb2
---
## Overview

The `user:passkeys` tag loops through the user's passkeys. Useful for building a passkey management page where users can view and delete their passkeys.

### Example

::tabs

::tab antlers
```antlers
{{ user:passkeys as="passkeys" }}
    {{ if passkeys }}
        <h3>Your Passkeys</h3>
        <ul>
            {{ passkeys }}
                <li>
                    <strong>{{ name }}</strong>
                    {{ if last_login }}
                        <span>Last used: {{ last_login format="M j, Y g:i A" }}</span>
                    {{ else }}
                        <span>Never used</span>
                    {{ /if }}

                    {{ user:delete_passkey_form :id="id" }}
                        <button type="submit">Delete</button>
                    {{ /user:delete_passkey_form }}
                </li>
            {{ /passkeys }}
        </ul>
    {{ else }}
        <p>You haven't set up any passkeys yet.</p>
    {{ /if }}
{{ /user:passkeys }}
```
::tab blade
```blade
<s:user:passkeys as="passkeys">
    @if ($passkeys)
        <h3>Your Passkeys</h3>
        <ul>
            @foreach ($passkeys as $passkey)
                <li>
                    <strong>{{ $passkey['name'] }}</strong>
                    @if ($passkey['last_login'])
                        <span>Last used: {{ $passkey['last_login']->format('M j, Y g:i A') }}</span>
                    @else
                        <span>Never used</span>
                    @endif

                    <s:user:delete_passkey_form :id="$passkey['id']">
                        <button type="submit">Delete</button>
                    </s:user:delete_passkey_form>
                </li>
            @endforeach
        </ul>
    @else
        <p>You haven't set up any passkeys yet.</p>
    @endif
</s:user:passkeys>
```
::

## Aliasing

You can use the `as` parameter to alias the passkeys into a variable, which allows you to use `{{ if passkeys }}` to check if there are any passkeys before rendering.

```antlers
{{ user:passkeys as="passkeys" }}
    {{ if passkeys }}
        {{# Render passkeys list #}}
    {{ /if }}
{{ /user:passkeys }}
```

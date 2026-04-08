---
id: 7a958307-4cdb-47f3-a689-0c7de57e3ff7
blueprint: tag
title: 'User:Passkey_Form'
description: 'Creates a passkey registration form'
intro: 'Allows authenticated users to set up passkeys'
variables:
  -
    name: create_url
    type: string
    description: 'URL to fetch WebAuthn attestation options for creating a new passkey.'
  -
    name: store_url
    type: string
    description: 'URL to store the new passkey after registration.'
  -
    name: errors
    type: array
    description: An array of validation errors.
  -
    name: success
    type: string
    description: A success message.
related_entries:
    - 38323438-4719-4a7b-ba5a-8abfe0d7dfc0
    - d0ed4ac0-536a-47a1-965b-202b52baddb2
    - 7432f1cb-7418-4d54-8e65-51b1ae3bcb3a
---
## Overview

The `user:passkey_form` tag provides the necessary URLs to set up passkeys for authenticated users.

### JavaScript helpers

You'll need to include the frontend helpers script on your page:

```html
<script src="/vendor/statamic/frontend/js/helpers.js"></script>
```

### Example

::tabs

::tab antlers
```antlers
{{ user:passkey_form }}
    <input type="text" id="passkey-name" placeholder="Passkey name (e.g., My Laptop)">
    <button type="button" id="create-passkey">Create Passkey</button>

    {{ if success }}
        <p>Passkey created successfully!</p>
    {{ /if }}

    {{ if errors }}
        <ul>
            {{ errors }}
                <li>{{ value }}</li>
            {{ /errors }}
        </ul>
    {{ /if }}

    <script>
        document.getElementById('create-passkey').addEventListener('click', () => {
            const name = document.getElementById('passkey-name').value || 'My Passkey';

            Statamic.$passkeys.register({
                optionsUrl: '{{ create_url }}',
                verifyUrl: '{{ store_url }}',
                name: name,
                onSuccess: () => location.reload(),
                onError: (error) => alert(error.message),
                // csrfToken (optional)
            });
        });
    </script>
{{ /user:passkey_form }}
```
::tab blade
```blade
<s:user:passkey_form>
    <input type="text" id="passkey-name" placeholder="Passkey name (e.g., My Laptop)">
    <button type="button" id="create-passkey">Create Passkey</button>

    @if ($success)
        <p>Passkey created successfully!</p>
    @endif

    @if ($errors)
        <ul>
            @foreach ($errors as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <script>
        document.getElementById('create-passkey').addEventListener('click', () => {
            const name = document.getElementById('passkey-name').value || 'My Passkey';

            Statamic.$passkeys.register({
                optionsUrl: '{{ $create_url }}',
                verifyUrl: '{{ $store_url }}',
                name: name,
                onSuccess: () => location.reload(),
                onError: (error) => alert(error.message),
                // csrfToken (optional)
            });
        });
    </script>
</s:user:passkey_form>
```
::

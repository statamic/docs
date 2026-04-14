---
id: d0ed4ac0-536a-47a1-965b-202b52baddb2
blueprint: tag
title: 'User:Delete_Passkey_Form'
description: 'Creates a form to delete a passkey'
intro: 'As the tag name suggests, it allows you to delete a passkey.'
parameters:
  -
    name: id
    type: string
    description: 'The passkey ID to delete. Required.'
  -
    name: redirect
    type: string
    description: Where the user should be taken after successfully deleting a passkey.
  -
    name: HTML Attributes
    type:
    description: 'Set HTML attributes as if you were in an HTML element. For example, `class="delete-form"`.'
related_entries:
    - 38323438-4719-4a7b-ba5a-8abfe0d7dfc0
    - 7a958307-4cdb-47f3-a689-0c7de57e3ff7
    - 7432f1cb-7418-4d54-8e65-51b1ae3bcb3a
---
## Overview

The `user:delete_passkey_form` tag renders a form to delete a passkey.

### Example

The tag is typically used inside a [`{{ user:passkeys }}`](/tags/user-passkeys) loop:

::tabs

::tab antlers
```antlers
{{ user:passkeys as="passkeys" }}
    {{ passkeys }}
        <div>
            {{ name }}

            {{ user:delete_passkey_form :id="id" }}
                <button type="submit">Delete</button>
            {{ /user:delete_passkey_form }}
        </div>
    {{ /passkeys }}
{{ /user:passkeys }}
```
::tab blade
```blade
<s:user:passkeys as="passkeys">
    @foreach ($passkeys as $passkey)
        <div>
            {{ $passkey['name'] }}

            <s:user:delete_passkey_form :id="$passkey['id']">
                <button type="submit">Delete</button>
            </s:user:delete_passkey_form>
        </div>
    @endforeach
</s:user:passkeys>
```
::

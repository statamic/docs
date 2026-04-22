---
title: User:Elevated_Session_Form
description: Creates a form to confirm user identity for elevated sessions
intro: If you want to protect sensitive frontend actions with re-authentication, this tag renders the form for users to confirm their identity.
parameters:
  -
    name: HTML Attributes
    type:
    description: >
      Set HTML attributes as if you were in an HTML element. For example, `class="required" id="confirm-form"`.
variables:
  -
    name: method
    type: string
    description: |
      The authentication method required. One of: `password_confirmation`, `verification_code`, or `passkey`.
  -
    name: allow_passkey
    type: boolean
    description: |
      Whether the user has passkeys available as an authentication option.
  -
    name: resend_code_url
    type: string
    description: |
      URL to resend the verification code. Only relevant when `method` is `verification_code`.
  -
    name: passkey_options_url
    type: string
    description: |
      URL to fetch WebAuthn assertion options for passkey authentication.
  -
    name: submit_url
    type: string
    description: |
      The URL where the form submits to. Useful when implementing passkey authentication via JavaScript.
  -
    name: errors
    type: array
    description: An array of validation errors.
  -
    name: old
    type: array
    description: An array of previously submitted values.
related_entries:
  - 5eab02e3-c76b-4f44-a304-6a78877d099f
id: 45cca7b8-63e1-4a26-bd61-6ae9cfb4a3ce
---
## Overview

[Elevated Sessions](/control-panel/elevated-sessions) allow you to prompt users for their password or a verification code before being able to take certain actions.

The `user:elevated_session_form` tag renders a form allowing authenticated users to confirm their identity and start an elevated session. Useful for protecting sensitive actions that require re-authentication.

The tag will render the opening and closing `<form>` HTML elements for you. The rest of the form markup is up to you.

### Example

::tabs

::tab antlers
```antlers
{{ user:elevated_session_form }}
    {{ if errors }}
        <div class="bg-red-300 text-white p-2">
            {{ errors }}
                {{ value }}<br>
            {{ /errors }}
        </div>
    {{ /if }}

    {{ if method == "password_confirmation" }}
        <label>Password</label>
        <input type="password" name="password" />
    {{ /if }}

    {{ if method == "verification_code" }}
        <p>A verification code has been sent to your email.</p>
        <label>Verification Code</label>
        <input type="text" name="verification_code" />
        <a href="{{ resend_code_url }}">Resend code</a>
    {{ /if }}

    <button type="submit">Confirm</button>
{{ /user:elevated_session_form }}
```
::tab blade
```blade
<s:user:elevated_session_form>
  @if ($errors)
    <div class="bg-red-300 text-white p-2">
      @foreach ($errors as $error)
        {{ $error }}<br>
      @endforeach
    </div>
  @endif

  @if ($method === 'password_confirmation')
    <label>Password</label>
    <input type="password" name="password" />
  @endif

  @if ($method === 'verification_code')
    <p>A verification code has been sent to your email.</p>
    <label>Verification Code</label>
    <input type="text" name="verification_code" />
    <a href="{{ $resend_code_url }}">Resend code</a>
  @endif

  <button type="submit">Confirm</button>
</s:user:elevated_session_form>
```
::

## Authentication Methods

The `method` variable indicates how the user should confirm their identity:

- **`password_confirmation`** - User should enter their password.
- **`verification_code`** - User doesn't have a password, so they should enter the verification code sent to their email.
- **`passkey`** - User requires a passkey to login. Passkey authentication requires JavaScript - see the below section for more details.

### Passkeys

Passkey authentication requires JavaScript. Include the frontend helpers script and use the `passkey_options_url` and `submit_url` variables:

```antlers
{{ user:elevated_session_form }}
    {{ if method == "password_confirmation" }}
        <input type="password" name="password" />
        <button type="submit">Confirm with Password</button>
    {{ /if }}

    {{ if method == "verification_code" }}
        <p>A verification code has been sent to your email.</p>
        <label>Verification Code</label>
        <input type="text" name="verification_code" />
        <a href="{{ resend_code_url }}">Resend code</a>
        <button type="submit">Confirm with Verification Code</button>
    {{ /if }}

    {{ if allow_passkey }}
        <button type="button" id="passkey-confirm">Confirm with Passkey</button> {{# [tl! focus:start] #}}

        <script src="/vendor/statamic/frontend/js/helpers.js"></script>
        <script>
            Statamic.$passkeys.configure({
                optionsUrl: '{{ passkey_options_url }}',
                verifyUrl: '{{ submit_url }}',
                onSuccess: (data) => window.location = data.redirect || '/',
                onError: (error) => alert(error.message)
            });

            document.getElementById('passkey-confirm').addEventListener('click', () => {
                Statamic.$passkeys.authenticate();
            });
        </script> {{# [tl! focus:end] #}}
    {{ /if }}
{{ /user:elevated_session_form }}
```

## Protecting routes

To require an elevated session on your routes, apply the middleware:

```php
use Statamic\Http\Middleware\RequireElevatedSession;

Route::get('/account/sensitive-action', SensitiveActionController::class)
    ->middleware(['auth', RequireElevatedSession::class]);
```

When users access a protected route without an elevated session, they'll be redirected to confirm their identity. After successful confirmation, they're redirected back to the original URL.

## Configuration

In `config/statamic/users.php`:

```php
// Duration in minutes before the elevated session expires
'elevated_session_duration' => 15,

// URL to a custom elevated session page.
// When null, it'll fallback to a Statamic-powered page.
'elevated_sessions_url' => null,
```

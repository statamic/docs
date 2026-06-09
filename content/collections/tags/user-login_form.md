---
title: User:Login_Form
description: Creates user login forms
intro: If you want to build a login form for your users, this is the easiest way to do it.
parameters:
  -
    name: redirect
    type: string
    description: Where the user should be taken after successfully logging in.
  -
    name: error_redirect
    type: string
    description: >
      The same as `redirect`, but for failed logins.
  -
    name: allow_request_redirect
    type: boolean
    description: When set to true, the `redirect` and `error_redirect` parameters will get overridden by `redirect` and `error_redirect` query parameters in the URL.
  -
    name: HTML Attributes
    type:
    description: >
      Set HTML attributes as if you were in an HTML element. For example, `class="required" id="login-form"`.
variables:
  -
    name: errors
    type: array
    description: An array of validation errors.
  -
    name: old
    type: array
    description: An array of previously submitted values.
  -
    name: success
    type: string
    description: A success message.
  -
    name: passkey_options_url
    type: string
    description: URL to fetch WebAuthn assertion options for passkey login.
  -
    name: passkey_verify_url
    type: string
    description: URL to verify passkey login.
id: 7432f1cb-7418-4d54-8e65-51b1ae3bcb3a
---
## Overview

User tags are designed for sites that have areas or features behind a login. The `user:login_form` tag helps you build that login form.

The tag will render the opening and closing `<form>` HTML elements for you. The rest of the form markup is up to you as long as you have an `email` and `password` input field.

### Example

::tabs

::tab antlers
```antlers
{{ user:login_form }}

    {{ if errors }}
        <div class="bg-red-300 text-white p-2">
            {{ errors }}
                {{ value }}<br>
            {{ /errors }}
        </div>
    {{ /if }}

    {{ if success }}
        <div class="bg-green-300 text-white p-2">
            {{ success }}<br>
        </div>
    {{ /if }}

    <label>Email</label>
    <input type="email" name="email" value="{{ old:email }}" />

    <label>Password</label>
    <input type="password" name="password" value="{{ old:password }}" />

    <button type="submit">Log in</button>

{{ /user:login_form }}
```
::tab blade
```blade
<s:user:login_form>
  @if ($errors)
    <div class="bg-red-300 text-white p-2">
      @foreach ($errors as $error)
        {{ $error }}<br>
      @endforeach
    </div>
  @endif

  @if ($success)
    <div class="bg-green-300 text-white p-2">
      {{ $success }}<br>
    </div>
  @endif

  <label>Email</label>
  <input type="email" name="email" value="{{ old('email') }}" />

  <label>Password</label>
  <input type="password" name="password" value="{{ old('password') }}" />

  <button type="submit">Log in</button>
</s:user:login_form>
```
::

## Precognition

The login endpoint supports [Laravel Precognition](https://laravel.com/docs/precognition) for live, server-driven validation. See [Precognition for User Forms](/forms#user-forms) for setup and a full example.

## Passkeys

You can add passkey authentication to your login form using Statamic's frontend JavaScript helpers.

1. First, include the helpers script on your page:
    ```html
    <script src="/vendor/statamic/frontend/js/helpers.js"></script>
    ```

2. Use the provided variables to add a passkey login option:
    ```antlers
    {{ user:login_form }}
        <input type="email" name="email" value="{{ old:email }}" />
        <input type="password" name="password" value="{{ old:password }}" />
        <button type="submit">Log in with Password</button>

        <button type="button" id="passkey-login">Login with Passkey</button> {{# [tl! focus:start] #}}

        <script>
            Statamic.$passkeys.configure({
                optionsUrl: '{{ passkey_options_url }}',
                verifyUrl: '{{ passkey_verify_url }}',
                onSuccess: (data) => window.location = data.redirect || '/',
                onError: (error) => alert(error.message)
            });

            document.getElementById('passkey-login').addEventListener('click', () => {
                Statamic.$passkeys.authenticate();
            });

            // Enable browser autofill for passkeys
            Statamic.$passkeys.initAutofill();
        </script> {{# [tl! focus:end] #}}
    {{ /user:login_form }}
    ```
3. Add `autocomplete="username webauthn"` to your email input for browser autofill to work.

For more information on managing passkeys on the frontend, see the following docs:
- [`{{ user:passkeys }}`](/tags/user-passkeys)
- [`{{ user:passkey_form }}`](/tags/user-passkey_form)
- [`{{ user:delete_passkey_form }}`](/tags/user-delete_passkey_form)

## Two-Factor Authentication

When a user with two-factor authentication (2FA) enabled submits the login form, Statamic will redirect them to a challenge page so they can enter a code from their authenticator app. If the user belongs to a role that requires 2FA but hasn't set it up yet, they'll be redirected to the setup page instead.

You can customize where each of these redirects goes using the `two_factor_challenge_url` and `two_factor_setup_url` config keys in `config/statamic/users.php`. Leave them `null` to use Statamic's built-in pages.

```php
// config/statamic/users.php

'two_factor_challenge_url' => '/account/2fa/challenge',
'two_factor_setup_url' => '/account/2fa/setup',
```

When rolling your own frontend pages, use the following tags to render the forms:

- [`{{ user:two_factor_challenge_form }}`](/tags/user-two_factor_challenge_form) — the code verification form during login
- [`{{ user:two_factor_enable_form }}`](/tags/user-two_factor_enable_form) — step 1 of setup, generates the secret
- [`{{ user:two_factor_setup_form }}`](/tags/user-two_factor_setup_form) — step 2 of setup, displays the QR code and confirms the code

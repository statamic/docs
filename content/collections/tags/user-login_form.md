---
title: User:Login_Form
description: Creates user login forms
intro: If you want to build a login form for your users, this is the easiest way to do it.
stage: 4
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

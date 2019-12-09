---
title: User:Login_Form
description: For creating a user login form
intro: If you wan to build a login form for your users, this is the easiest way to do it.
stage: 4
parameters:
  -
    name: attr
    type: string
    description: |
      Set HTML attributes like so: `attr="class:form|id:form"`. This will become: `<form class="form" id="form">`.
  -
    name: redirect
    type: string
    description: Where the user should be taken after successfully logging in.
  -
    name: allow_request_redirect
    type: boolean
    description: When set to true, the `redirect` parameter will get overridden by a `redirect` query parameter in the URL.
variables:
  -
    name: errors
    type: array
    description: An array of validation errors.
  -
    name: old
    type: array
    description: An array of previously submitted values.
id: 7432f1cb-7418-4d54-8e65-51b1ae3bcb3a
---
## Overview

User tags are designed for sites that have areas or features behind a login. The `user:login` tag helps you build that login form.

The tag will render the opening and closing `<form>` HTML elements for you. The rest of the form markup is up to you as long as you have an `email` and `password` input field.

## Example

```
{{ user:login_form }}

    {{ if errors }}
        <div class="bg-red-300 text-white p-2">
            {{ errors }}
                {{ value }}<br>
            {{ /errors }}
        </div>
    {{ /if }}

    <label>Email</label>
    <input type="text" name="email" value="{{ old:email }}" />

    <label>Password</label>
    <input type="password" name="password" value="{{ old:password }}" />

    <button type="submit">Log in</button>

{{ /user:login_form }}
```

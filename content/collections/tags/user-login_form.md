---
title: User:Login_Form
description: For creating a user login form
parameters:
  -
    name: attr
    type: string
    description: Set HTML attributes, e.g., `attr="class:form|id:form"`
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
id: 7432f1cb-7418-4d54-8e65-51b1ae3bcb3a
---
## Example {#example}

A basic login form, with validation errors.

```
{{ user:login_form }}

    {{ if errors }}
        <div class="alert alert-danger">
            {{ errors }}
                {{ value }}<br>
            {{ /errors }}
        </div>
    {{ /if }}


    <label>Username</label>
    <input type="text" name="username" value="{{ old:username }}" />

    <label>Password</label>
    <input type="password" name="password" value="{{ old:password }}" />

    <button>Log in</button>

{{ /user:login_form }}
```

---
title: User:Register_Form
description: For creating user registration forms
parameters:
  -
    name: redirect
    type: string
    description: >
      Where the user should be taken after
      successfully registering.
  -
    name: allow_request_redirect
    type: boolean
    description: When set to true, the `redirect` parameter will get overridden by a `redirect` query parameter in the URL.
variables:
  -
    name: errors
    type: array
    description: An array of validation errors.
id: 9323ebd8-c36c-4f0f-b73a-cb5ac4544e72
---
By default, `username`, `email`, `password`, and `password_confirmation` fields are all required. However, if `login_type` is set to `email` in `site/settings/users.yaml`, the `username` field can be omitted.

## Example {#example}

A basic registration form, with validation errors.

```
{{ user:register_form }}

    {{ if errors }}
        <div class="alert alert-danger">
            {{ errors }}
                {{ value }}<br>
            {{ /errors }}
        </div>
    {{ /if }}

    <label>Username</label>
    <input type="text" name="username" value="{{ old:username }}" />

    <label>Email</label>
    <input type="email" name="email" value="{{ old:email }}" />

    <label>Password</label>
    <input type="password" name="password" />

    <label>Password Confirmation</label>
    <input type="password" name="password_confirmation" />

    <button>Register</button>

{{ /user:register_form }}
```


### Additional Fields

You are allowed to add any additional fields to your registration form, and they will be added to the user's account
provided that they exist in the `user.yaml` fieldset.

Any submitted data that does _not_ exist in the fieldset will be completely ignored.

Additional fields will be validated as per your fieldset `validate` rules.

### New user roles

Most of the time, new members will need some roles assigned to them so that they can do different things on your site. You get to choose these roles by adding the `id`s of the roles, in an array called `new_user_roles` in your `site/settings/users.yaml` file. When a user successfully registers as a member, their account will automatically be assigned the roles in this list.

It’s best to remember that these are _starting_ roles for the user. You can later either manually add roles to users in their files, update their account through the Control Panel, or have add-ons automatically add or remove roles as needed when users perform certain tasks.

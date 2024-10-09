---
title: User:Profile
description: Fetches user data.
intro: Fetching user data made easy.
parameters:
  -
    name: id
    type: string
    description: |
      Fetch user by ID.
  -
    name: email
    type: string
    description: |
      Fetch user by email.
  -
    name: field
    type: string
    description: |
      Fetch user by a specific field value. Used with `value` below.
  -
    name: value
    type: string
    description: |
      Value of above `field` to fetch user by.
variables:
  -
    name: user data
    type: mixed
    description: >
      All user data (except password) is
      available.
  -
    name: no_results
    type: boolean
    description: >
      `true` if user cannot be found or is logged out.
  -
    name: 'is_[role]'
    type: boolean
    description: >
      `true` if user is assigned a given role. For example, `is_admin` or
      `is_banned`.
  -
    name: 'in_[group]'
    type: boolean
    description: >
      `true` if user is in a given group. For example, `in_admin` or
      `in_editors`.
id: 3be76d15-dee7-4619-a4cb-4a343e93c677
---
## Overview
The `user:profile` tag has access to all of a user's basic data. Passwords and hashes are _not_ available through this tag.

:::tip
This will default to the currently logged in user if none are specified.
:::


## Shorthand

You can use `user` and drop the `:profile` bit off if you prefer.

## Examples

To output the currently logged in user's details, you can do this:

::tabs

::tab antlers
```antlers
{{ user }}
  The current user's name is {{ name }}.
{{ /user }}
```
::tab blade
```blade
<s:user>
  The current user's name is {{ $name }}.
</s:user>

{{-- Aliasing the user. --}}
<s:user
  as="user"
>
  The current user's name is {{ $user->name }}.
</s:user>
```
::

Or perhaps you'd like to show user profile pages. Assuming your users have a `username` field, you could create a wildcard route like this:

```php
Route::statamic('users/{username}', 'users.show');
```

Then when visiting `/users/chuck`, for example, you could display Chuck's details like this:


::tabs

::tab antlers
```antlers
{{ user:profile field="username" :value="segment_2" }}
  {{ first_name }} {{ last_name }}
{{ /user:profile }}
```
::tab blade
```blade
<s:user:profile
  field="username"
  :value="$segment_2 ?? null"
>
  {{ $first_name }} {{ $last_name }}
</s:user:profile>
```
::

Or to find a user by email:

::tabs

::tab antlers
```antlers
{{ user:profile :email="email" }}
  {{ first_name }} {{ last_name }}
{{ /user:profile }}
```
::tab blade
```blade
<s:user:profile
  :email="$email"
>
  {{ $first_name }} {{ $last_name }}
</s:user:profile>
```
::

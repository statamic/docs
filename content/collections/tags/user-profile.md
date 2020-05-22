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
The `{{ user:profile }}` tag has access to all of a user's basic data. Passwords and hashes are _not_ available through this tag.

> This will default to the currently logged in user if none are specified.


## Shorthand

You can use `{{ user }}` and drop the `:profile` bit off if you prefer.

## Examples

To output the currently logged in user's details, you can do this:

```
{{ user }}
  The current user's name is {{ first_name }} {{ last_name }}.
{{ /user }}
```

Or perhaps you'd like to show user profile pages. You could create a wildcard route like this:

```php
Route::statamic('users/{user}', 'users.show');
```

Then when visiting `/users/chuck`, for example, you could display Chuck's details like this:

```
{{ user:profile :email="email" }}
  {{ first_name }} {{ last_name }}
{{ /user:profile }}
```

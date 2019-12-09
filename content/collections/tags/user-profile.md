---
title: User:Profile
description: Fetches user data
parameters:
  -
    name: id
    type: string
    description: |
      Specify the ID for a user to output their data.
      Leave blank to target the currently logged in user.
  -
    name: username
    type: string
    description: |
      Specify the username of a user to output their data.
      Leave blank to target the currently logged in user.
  -
    name: email
    type: string
    description: |
      Specify the email of a user to output their data.
      Leave blank to target the currently logged in user.
variables:
  -
    name: user data
    type: mixed
    description: >
      All user data (front matter) will be
      available.
  -
    name: no_results
    type: boolean
    description: >
      If a specified user cannot be found, or
      if the user is logged out, this will be
      `true`.
  -
    name: 'is_[role]'
    type: boolean
    description: >
      A boolean for checking if the user is
      assigned a given role. eg. `is_admin` or
      `is_banned`.
  -
    name: 'in_[group]'
    type: boolean
    description: >
      A boolean for checking if the user is in
      a given group. eg. `in_admins` or
      `in_editors`.
id: 3be76d15-dee7-4619-a4cb-4a343e93c677
---
The `{{ user:profile }}` tag (or simply `{{ user }}`) will make all the fields in a user available.

If you don't specify the user with either `id`, `username`, or `email` parameters, the currently logged in user will be shown.

## Example {#example}

To output the currently logged in user's details, you can do this:

```
{{ user }}
  The current user's username is {{ username }} and their email is {{ email }}.
{{ /user }}
```

Or perhaps you'd like to show user profile pages. You could create a wildcard route like this:

``` .language-yaml
routes:
  /users/{username}
```

Then when visiting `/users/chuck`, for example, you could display their details like this:

```
{{ user:profile username="{username}" }}
  {{ first_name }} {{ last_name }}
{{ /user:profile }}
```

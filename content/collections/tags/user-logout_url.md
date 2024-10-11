---
title: User:Logout_URL
description: Generates a user logout URL
parameters:
  -
    name: redirect
    type: string
    description: >
       Where the user should be redirected
       after logging out. Defaults to the home
       page.
id: 232b878c-18da-4d01-80f3-a85fcdf65ed8
stage: 3
---
## Example {#example}


::tabs

::tab antlers
```antlers
<a href="{{ user:logout_url }}">Log out</a>
```
::tab blade
```blade
<a href="{{ Statamic::tag('user:logout_url')->fetch() }}">Log out</a>
```
::

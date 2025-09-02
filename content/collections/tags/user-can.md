---
title: User:Can
description: Checks if a user has a specific permission
intro: Anything inside the `user:can` tag will only be rendered if the user has the specified permission.
parameters:
  -
    name: permission|do
    type: string
    description: >
      The permissions to check against. You can use the parameter `permission` or `do`, depending on you feel about the grammar of each case. Specify multiple permissions by pipe separating them: `{{ user:can do="things|stuff" }}`.
id: 649f1eb3-cd60-46ec-ba07-38e2a4747952
---
## Overview

User tags are designed for sites that have areas or features behind a login. The `{{ user:can }}` tag is used to check if the currently logged in user has a one or more specific permissions.

## Example

Let's say we want a link to edit the current entry in the control panel if the user has the `edit faq entries` permission.

::tabs

::tab antlers
```antlers
{{ user:can do="edit faq entries" }}
    <a href="{{ edit_url }}">Edit this Page</a>
{{ /user:can }}
```
::tab blade
```blade
{{-- Using user methods --}}
@if (auth()->user()?->can('edit blog entries'))
  ...
@endif

{{-- Using Fluent Tags --}}
@if (Statamic::tag('user:can')->do('edit blog entries')->fetch())
  ...
@endif

{{-- Using Antlers Blade Components --}}
<s:user:can
  do="edit blog entries"
>
  ...
</s:user:can>
```
::

## Super Users

[Super users](/users#super-users) can always do everything, so no matter what you check for — whether it exists as an actual permission or not — it will always return `true`.

## Can’t

We also support the negative use case using `{{ user:cant }}` tags.

::tabs

::tab antlers
```antlers
{{ user:cant do="anything" }}
  <p>Aww, I'm sure that's not true! 😊</p>
{{ /user:cant }}
```
::tab blade
```blade
{{-- Using user methods --}}
@if (auth()->user()?->cant('do anything'))
  <p>Aww, I'm sure that's not true! 😊</p>
@endif

{{-- Using Fluent Tags --}}
@if (Statamic::tag('user:cant')->do('anything')->fetch())
  <p>Aww, I'm sure that's not true! 😊</p>
@endif

{{-- Using Antlers Blade Components --}}
<s:user:cant
  do="anything"
>
  <p>Aww, I'm sure that's not true! 😊</p>
</s:user:cant>
```
::

## Permissions List

Check out the the complete [list of user permissions](/users#permissions).

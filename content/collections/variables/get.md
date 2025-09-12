---
id: 546c4334-df40-4e9a-aff4-a56c43e839d8
blueprint: variables
types:
  - system
title: Get
---
An array of `GET` variables that come from any query strings present in the current URL. It can be used as a tag pair with access to all your parameters or as a single tag to access parameters directly. A counterpart to `{{ post }}`.


Example URL: `/about?show=pants&hide=jeggings`

::tabs

::tab antlers
```antlers
{{ get:show }}

{{ get }}
  {{ show }}
  {{ hide }}
{{ /get }}

```
::tab blade
```blade
{{ $get['show'] ?? '' }}

-- or --

{{ request()->get('show') }}
```
::

```html
pants

pants
jeggings
```

Be sure to escape these values with the `sanitize` modifier if you plan to use them in output in production.

::tabs

::tab antlers
```antlers
<!-- Because let's face it. You really *should* sanitize your jeggings. -->
{{ get:jeggings | sanitize }}
```
::tab blade
```blade
{{ request()->get('jeggings') }}

-- or --

{!! Statamic::modify(request()->get('jeggings'))->sanitize() !!}
```
::

Accessing `GET` values with a variable key in Antlers can be done by wrapping the key with `[]`.

```antlers
{{ show_key = "show" }}
{{ hide_key = "hide" }}
{{ get[show_key] }}
{{ get[hide_key] }}
```

```html
pants
jeggings
```

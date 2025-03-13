---
id: 3bcdbffa-8020-4364-8c2a-1fe1a9ff0a5c
blueprint: modifiers
modifier_types:
  - string
  - utility
added_in: 2.8.4
title: Spaceless
---
Removes excess whitespace and line breaks from a string. A definite OCD pleaser.

```
html: |
    <p>I copy & pasted
        <a href="http://goodnightchrome.show">this link
        </a>   <strong>for you!</strong>    </p>
```

::tabs

::tab antlers
```antlers
{{ html | spaceless }}
```
::tab blade
```blade
{!! Statamic::modify($html)->spaceless() !!}
```
::

```html
<p>I copy & pasted <a href="http://goodnightchrome.show">this link </a><strong>for you!</strong></p>
```

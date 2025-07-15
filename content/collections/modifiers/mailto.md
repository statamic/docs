---
id: 65bcc454-2731-4f83-97cf-03659fb38db5
blueprint: modifiers
modifier_types:
  - markup
attributes: true
title: Mailto
---
Generate a `mailto` link element with the value as the email address. If it's _not_ an email address, it's going to be one busted link.

```yaml
holler: holler@example.com
```

::tabs

::tab antlers
```antlers
{{ holler | mailto }}
{{ holler | mailto('class:text-white bg-brown') }}
{{ holler | mailto('class:text-white', 'data-tracking:true') }}
```
::tab blade
```blade
{{ Statamic::modify($holler)->mailto() }}
{{ Statamic::modify($holler)->mailto('class:text-white') }}
{{ Statamic::modify($holler)->mailto('class:text-white', 'data-tracking:true') }}
```
::

```html
<a href="mailto:holler@example.com">holler@example.com</a>
<a href="mailto:holler@example.com" class="text-white bg-brown">holler@example.com</a>
<a href="mailto:holler@example.com" class="text-white" data-tracking="true">holler@example.com</a>
```

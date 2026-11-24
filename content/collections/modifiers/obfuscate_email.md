---
id: 536ac4b3-bfc7-4ced-8c83-d389fb94a262
blueprint: modifiers
modifier_types:
  - markup
attributes: true
title: 'Obfuscate Email'
---
Encodes an email address with HTML entities while keeping it readable in the browser. Bots that decode HTML can still read the address.

```yaml
holler: holler@example.com
```

::tabs

::tab antlers
```antlers
{{ holler | obfuscate_email }}
```
::tab blade
```blade
{!! Statamic::modify($holler)->obfuscateEmail() !!}
```
::

```html
# output appears as holler@example.com
&#104;o&#108;le&#x72;&#x40;&#x65;&#x78;&#x61;&#109;&#x70;&#108;&#101;&#x2e;&#x63;&#x6f;m
```

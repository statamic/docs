---
id: 15ab735c-a877-423a-8e7f-c61e3f68744b
blueprint: modifiers
modifier_types:
  - string
  - utility
title: Slugify
---
Converts the string into an URL slug. This includes replacing non-ASCII characters with their closest ASCII equivalents, removing remaining non-ASCII
and non-alphanumeric characters, and replacing whitespace with dashes. And then everything is lowercased.


```yaml
string: Please, have some lemoñade.
```

::tabs

::tab antlers
```antlers
{{ string | slugify }}
```
::tab blade
```blade
{{ Statamic::modify($string)->slugify() }}
```
::

```html
please-have-some-lemonade
```

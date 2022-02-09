---
id: c5832187-290e-4701-aa74-316d8130e7bb
modifier_types:
  - string
title: 'Add Slashes'
---
Modifies a string by adding backslashes before characters that need to be escaped. These characters are:

- single quote `'`
- double quote `"`
- backslash `\`

This is most often used when passing string data into JavaScript.

``` yaml
summary: >
  "I'm not listening!" said the small, strange creature.
```

```
{{ summary | add_slashes }}
```

``` output
\"I\'m not listening!\" said the small, strange creature.
```

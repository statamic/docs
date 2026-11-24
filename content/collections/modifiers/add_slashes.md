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
- NUL (the null byte)

This uses PHP's [addslashes()](https://www.php.net/manual/en/function.addslashes.php). It does not encode a complete JavaScript string; use an appropriate JSON encoder when passing data to JavaScript.

``` yaml
summary: >
  "I'm not listening!" said the small, strange creature.
```

::tabs

::tab antlers
```antlers
{{ summary | add_slashes }}
```

::tab blade
```blade
{{ Statamic::modify($summary)->addSlashes() }}
```
::

``` output
\"I\'m not listening!\" said the small, strange creature.
```

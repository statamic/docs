---
id: 898d2e63-fc2c-4b66-bd26-8a53883a0aad
blueprint: variables
types:
  - system
title: Config
---
Statamic (and Laravel) have many config files in the `config` directory. Each file/directory is the 'key' to retrieve its data.

For example, if you want to check whether the Control Panel is enabled, you could use:

::tabs

::tab antlers
``` antlers
{{ config:statamic:cp:enabled }}
```
::tab blade
```blade
{{ config('statamic.cp.enabled') }}
```
::

To retrieve from the `config/app.php` you would:

::tabs

::tab antlers
``` antlers
{{ config:app:variable_you_want }}
```
::tab blade
```blade
{{ config('statamic.app.variable_you_want') }}
```
::

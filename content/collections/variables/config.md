---
id: 898d2e63-fc2c-4b66-bd26-8a53883a0aad
blueprint: variables
types:
  - system
title: Config
description: Access configuration values from Statamic and Laravel config files.
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


## Custom Config

No longer available by default since 5.73.11. To use custom config variables in views you need to add
them to the view config allowlist in `config/statamic/system.php`.

Here is how to add the custom `foo` config variable from the app.php config file:

```php
// config/app.php

return [
    // ...
    'foo' => 'bar'
    // ...
];

// config/statamic/system.php

return [
    // ...
    'view_config_allowlist' => [
        '@default', // spreads the defaults into this array
        'app.foo',
    ],
    // ...
];
```

Now you can access it in your views:  `{{ config:app:foo }}`

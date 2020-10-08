---
title: Config
description: 'Retrieves configuration data'
intro: 'The config tag is used to get configuration values from your config files'
stage: 5
id: 898fba0b-3b32-4b13-a73f-c0eecbaf4db5
---
## Overview
Statamic (and Laravel) have many config files in the `config` folder. Each file/folder is the 'key' to retrieve its data.

For example, if you want to get the system timezone from the `config/statamic/system.php` file, you would use:

``` antlers
{{ config:statamic:system:timezone }}
```

To retrieve from the `app.php` you would:

``` antlers
{{ config:app:variable_you_want }}
```

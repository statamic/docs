---
id: 668f4934-9dd9-4e5b-b24e-8fa6173336c2
blueprint: repositories
title: 'Site Repository'
class: \Statamic\Facades\Site
nav_title: 'Sites'
related_entries:
  - fb20f2e0-3881-43e6-8507-3308a18c54b0
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1634259827
---
To work with the with Site Repository, use the following Facade:

```php
use Statamic\Facades\Site;
```

## Methods

| Methods | Description |
| ------- | ----------- |
| `all()` | Get all Sites |
| `get($handle)` | Get Site by handle |
| `findByUrl($url)` | Get site by a given URL |
| `current()` | Returns the current site, determined by the current page URL. |
| `setCurrent($handle)` | Sets the current site. |
| `selected()` | Returns the site currently selected in the Control Panel |
| `setSelected($handle)` | Sets the selected site. |
| `default()` | Returns the "default site", which will be the first site in the `sites` config |
| `authorized()` | Returns a collection of Site objects, where the user is authorized to view the site (see [Multisite Permissions](https://statamic.dev/multi-site#permissions)). |
| `hasMultiple()` | Returns a boolean indicating if multiple sites are configured. |
| `setConfig($config)` | Accepts an array. Allows you to override the configured sites. |

## Resolving the current site

When you're using the `Site::current()` method, sometimes the current page URL will lead to the wrong site being returned (like when using Livewire). In this case, you can use the resolveCurrentUrlUsing to check against a different URL:

```php
// app/Providers/AppServiceProvider.php

use Statamic\Facades\Site;

Site:: resolveCurrentUrlUsing(fn () => Livewire::originalUrl());
```

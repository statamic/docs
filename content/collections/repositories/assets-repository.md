---
id: 391907fa-1312-4143-80e7-546d20f20d84
blueprint: repositories
title: 'Assets Repository'
class: \Statamic\Facades\Asset
related_entries:
  - e7833062-e05c-42c9-ad35-dc5077f1f0b8
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1634414521
nav_title: Assets
---
## Methods

| Methods | Description |
| ------- | ----------- |
| `all()` | Get all Assets |
| `find()` | Get Asset by `filename` |
| `findByPath()` | Get Asset by `path` |
| `findByUrl()` | Get Asset by `url` |
| `query()` | Query Builder |
| `whereContainer()` | Find Assets by [AssetContainer](#asset-container) |
| `whereFolder()` | Find Assets in a filesystem folder |

To work with the Asset Repository, use the following Facade:

```php
use Statamic\Facades\Asset;
```

:::tip
You **must** specify the Asset Container when querying Assets.
:::

## Examples

#### Get all assets in a container

```php
Asset::query()
    ->where('container', 'main')
    ->get();
```

#### Get all assets in a folder

```php
Asset::query()
->where('container', 'main')
    ->where('folder', 'team_photos')
    ->get();
```

#### Get all assets without an alt tag

```php
Asset::query()
    ->where('container', 'main')
    ->where('alt', null)
    ->get();
```

#### Get all Assets with "thumbnail" in the filename.

```php
Asset::query()
    ->where('container', 'main')
    ->where('filename', 'like', '%thumbnail%')
    ->get();
```

#### Get the newest 10 assets from a container

```php
Asset::query()
    ->where('container', 'main')
    ->orderBy('last_modified', 'desc')
    ->get();
```
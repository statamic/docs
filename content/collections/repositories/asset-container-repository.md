---
id: 2ecb1176-6cf1-48cf-937e-baad66a002fa
blueprint: repositories
title: 'Asset Container Repository'
class: \Statamic\Facades\AssetContainer
nav_title: 'Asset Containers'
related_entries:
  - e7833062-e05c-42c9-ad35-dc5077f1f0b8
  - 391907fa-1312-4143-80e7-546d20f20d84
  - 7277432d-bb25-458a-a3a2-a72976b44ad5
  - 5b748a3f-be0e-41c1-8877-73f6b7ee1d0a
  - d0c65546-74f1-4a15-89d5-1562a95ee2c6
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1634259827
---
To work with the AssetContainer Repository, use the following Facade:

```php
use Statamic\Facades\AssetContainer;
```

## Methods

| Methods | Description |
| ------- | ----------- |
| `all()` | Get all AssetContainers |
| `find($id)` | Get AssetContainer by `id` |
| `findByHandle($handle)` | Get AssetContainer by `handle` |
| `findOrFail($id)` | Get AssetContainer by `id`. Throws an `AssetContainerNotFoundException` when the asset container cannot be found. |
| `queryAssets()` | Query Builder for the AssetContainer's [Assets](/repositories/asset-repository) |
| `make()` | Makes a new AssetContainer instance |

:::tip
The `id` is the same as `handle` while using the default Stache driver.
:::

## Querying

While the `AssetContainer` Repository does not have a Query Builder, you can still query for Assets _inside_ AssetContainers with the `queryAssets` method. This approach can be useful for retrieving Assets with an existing AssetContainer object.

```php
$videos = AssetContainer::find('videos');

$videos->queryAssets()
    ->where('series', 'stranger-things')
    ->get();
```

When an asset container can't be found, the `AssetContainer::find()` method will return `null`. If you'd prefer an exception be thrown, you may use the `findOrFail` method:

```php
AssetContainer::findOrFail('videos');
```

## Creating

Start by making an instance of an asset container with the `make` method. You can pass the handle into it.

```php
$container = AssetContainer::make('assets');
```

You may call additional methods on the container to customize it further.

```php
$container
  ->title('Assets')
  ->allowDownloading(true)
  ->allowMoving(true)
  ->allowRenaming(true)
  ->allowUploads(true)
  ->createFolders(true)
  ->searchIndex('assets');
```

Finally, save it.

```php
$container->save();
```

---
id: 391907fa-1312-4143-80e7-546d20f20d84
blueprint: repositories
title: 'Asset Repository'
class: \Statamic\Facades\Asset
related_entries:
  - e7833062-e05c-42c9-ad35-dc5077f1f0b8
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1634414521
nav_title: Assets
---
To work with the Asset Repository, use the following Facade:

```php
use Statamic\Facades\Asset;
```

## Methods

| Methods | Description |
| ------- | ----------- |
| `all()` | Get all Assets |
| `find($filename)` | Get Asset by `filename` |
| `findByPath($path)` | Get Asset by `path` |
| `findByUrl($url)` | Get Asset by `url` |
| `findOrFail($filename)` | Get Asset by `filename`. Throws an `AssetNotFoundException` when the asset cannot be found. |
| `query()` | Query Builder |
| `whereContainer($container)` | Find Assets by [AssetContainer](/repositories/asset-container-repository) |
| `whereFolder($folder)` | Find Assets in a filesystem folder |
| `make()` | Makes a new `Asset` instance |

:::tip
You **must** specify the Asset Container when querying Assets.
:::

## Querying

#### Examples {.popout}

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

#### Get all Assets with "thumbnail" in the path.

```php
Asset::query()
    ->where('container', 'main')
    ->where('path', 'like', '%thumbnail%')
    ->get();
```

#### Get the newest 10 assets from a container

```php
Asset::query()
    ->where('container', 'main')
    ->orderBy('last_modified', 'desc')
    ->get();
```

## Creating

Start by making an instance of an asset with the `make` method.
You need at least a path and the container before you can save an asset.

```php
$asset = Asset::make()->container('assets')->path('images/hat.jpg');
```

Or, if you have an asset container instance, you can use the `makeAsset` method.

```php
$asset = $container->makeAsset('images/hat.jpg');
```

Once you have an asset instance, you can add data to it.

```php
$asset->data(['foo' => 'bar']);
```

Finally, save it. It'll return a boolean for whether it succeeded.

```php
$asset->save(); // true or false
```

:::tip
Saving an asset instance will only store the metadata. It doesn't actually create the asset itself.

You should manually place the asset at the corresponding location, or you can use the `upload` method which accepts an `UploadedFile` instance.

```php
$file = $request->file('file');
$asset->upload($file);
```
:::

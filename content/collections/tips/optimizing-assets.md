---
id: b50310b0-64ae-4ae4-b219-a637ed89e4d7
title: 'Optimizing Assets'
intro: 'Slow asset browser on S3 or Spaces? Stop the Stache watcher from scanning every request, persist asset caches separately, and move metadata to the database when flat-file indexing buckles.'
template: page
categories:
  - development
  - performance
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1622821191
---
Statamic's asset system can point at a local directory or a remote service like Amazon S3 or DigitalOcean Spaces. That means you can drop files straight onto the disk without going through the Control Panel — handy.

The downside is file operations. Local disks eat that cost quietly. Remote disks turn every listing and existence check into an API request, and the asset browser gets sluggish fast.

:::tip
Don't install `league/flysystem-cached-adapter`. That package only worked with Flysystem v1 / Laravel 8 and earlier. Modern Statamic runs on Flysystem v2+, so the old `'cache' => true` disk option is dead. Use the levers below instead.
:::

These are in no particular order — grab whatever fits your setup.

## Disable the Stache watcher

Asset containers (and everything else) live in the [Stache](/stache). The watcher scans `last_modified` timestamps on every request so filesystem changes get picked up automatically.

That's great locally. On production — especially with remote asset disks — it's pure overhead.

New sites default to `auto` (on in `local`, off everywhere else). Make sure production is not forcing it on:

```env
STATAMIC_STACHE_WATCHER=auto
```

```php
// config/statamic/stache.php
'watcher' => env('STATAMIC_STACHE_WATCHER', 'auto'),
```

Set it to `false` if you want it off everywhere. With the watcher disabled, manage assets through the Control Panel (or clear/rebuild caches yourself) if you change files outside Statamic.

## Persist asset meta and folder listings

Statamic caches asset metadata and container folder listings in Laravel's application cache. That keeps the CP from re-listing your bucket on every click — until someone runs `php artisan cache:clear` and wiping the app cache also wipes the asset indexes.

If you have a lot of assets or folders, give them their own cache stores so they survive a normal cache clear:

```php
// config/cache.php

'asset_meta' => [
    'driver' => 'file',
    'path' => storage_path('statamic/asset-meta'),
],
'asset_container_contents' => [
    'driver' => 'file',
    'path' => storage_path('statamic/asset-container-contents'),
],
```

Clear _just_ those stores with:

```shell
php please assets:clear-cache
```

More detail: [Custom cache stores](/assets#custom-cache-stores).

## Use Redis for asset cache stores

A `file` driver is fine on a single server. On multiple app nodes, each machine keeps its own listing cache — so every box still ends up hitting S3. Point both stores at Redis (or another shared cache) so listings and meta are shared:

```php
// config/cache.php

'asset_meta' => [
    'driver' => 'redis',
    'connection' => 'cache',
],
'asset_container_contents' => [
    'driver' => 'redis',
    'connection' => 'cache',
],
```

Same `assets:clear-cache` command clears them.

## Pre-generate asset metadata

Cold caches mean the first CP browse (or Glide hit) pays for dimensions, file size, and `last_modified` by talking to the disk — painful on S3/Spaces. Warm meta ahead of time:

```shell
php please assets:meta
```

Pass a container handle to scope it. Prune orphaned `.meta` files left behind after deletes outside Statamic with `php please assets:meta-clean`. Worth running both in deploy scripts after bulk uploads or migrations.

## Move assets to the database

Still slow after dedicated caches? Flat-file / cache-backed asset indexing can struggle at larger scales. The [Eloquent Driver](https://github.com/statamic/eloquent-driver) stores asset records in the database instead, which often makes the asset browser and queries feel much snappier on big libraries — especially on S3/Spaces.

```shell
php please install:eloquent-driver
```

Pick the assets repository when prompted (or export later with `php please eloquent:export-assets` if you change your mind). Full walkthrough: [Storing Content in a Database](/tips/storing-content-in-a-database).

## Process source images on upload

Phone photos and camera dumps kill bandwidth, Glide work, and CP thumbnails. Enforce max dimensions (or other Glide params) on the _original_ at upload time with a source-processing preset:

```php
// config/statamic/assets.php
'image_manipulation' => [
    'presets' => [
        'max_upload_size' => ['w' => 2000, 'h' => 2000, 'fit' => 'max'],
    ],
],
```

Then assign that preset as the container's source processor. `fit: max` only downsizes images larger than those dimensions — smaller ones stay put. Details: [Process source images](/image-manipulation#process-source-images).

## Limit Glide preset warming

Conversely, when using remote source disks and uploading lots of images, consider disabling [Glide presets](/image-manipulation#presets) on upload by default to prevent a large amount of image transforms you might never use (think WordPress).

```php
// config/statamic/assets.php
'image_manipulation' => [
    'generate_presets_on_upload' => false,
],
```

Or pick which presets each container warms in the container settings (leave blank to warm nothing). Generate what you need later — in deploy or a queue — with:

```shell
php please assets:generate-presets
```

## Disable video thumbnails

The CP can generate video thumbnails via FFmpeg so videos aren't generic file icons. On a remote disk that's an expensive fetch + encode for every new video. If you don't need them:

```php
// config/statamic/assets.php
'video_thumbnails' => false,
```

## Disable filesystem asserts

Flysystem can check that a file exists before reading or writing it. On S3 that's an extra API round-trip. Turn it off on the disk your asset container uses:

```php
// config/filesystems.php
'disks' => [
    's3' => [
        'driver' => 's3',
        // ...
        'disable_asserts' => true, // asserts, not assets
    ],
],
```

## Check for existence through Assets

Mostly for addon developers.

If you need to know whether a file exists, prefer the `Asset` object — it caches the result after the first filesystem hit. On S3 that means one API call even if you ask a million times:

```php
$asset = AssetContainer::find('s3')->makeAsset('foo.jpg');
$asset->exists();
```

These go to the filesystem (and S3) every time:

```php
$asset->disk()->exists($asset->path());

File::exists($asset->path());
```

Use them when you genuinely need a live check. Otherwise stick to `$asset->exists()`.

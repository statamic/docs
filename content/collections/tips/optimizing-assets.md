---
id: b50310b0-64ae-4ae4-b219-a637ed89e4d7
title: 'Optimizing Assets'
template: page
categories:
  - development
  - performance
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1622821191
---

:::tip
**This only Applies to Statamic 3.1+**
:::
:::tip
**If you are looking at optimisation due to performance issues it may be worth taking a look at the [performance section of the Nav tag](/tags/nav#performance)**
:::

Statamic's asset system allows you to point at a directory either locally or a remote service like Amazon S3.

Doing things this way allows you to drop assets right onto the disk without needing to specifically use Statamic's Control Panel. Handy!

The downside to this is that it could slow down because of the number of file operations. Especially on remote services like Amazon S3 or Digital Ocean Spaces, because it would be performing API requests.

Don't worry though, there are ways to keep things zippy!

## 1. Disable the Stache watcher

Statamic stores information about assets in the Stache which is our flat file database. The Stache has a "watcher" feature that will keep an eye on your files, and update things whenever it notices they've changed.

If you turn the watcher off, it won't need to look at the filesystem on every request, and things will become much faster.

```php
// config/statamic/stache.php
'watcher' => false,
```

With this off, you will need to use the Control Panel to manage your assets (and edit entries, etc) or clear the cache manually if you do make manual changes to the files.

## 2. Enabling Flysystem caching

Statamic's assets use Flysystem under the hood. Flysystem has a feature where it can cache filesystem calls, you just need to install and enable it. Please note that the `flysystem-cached-adapter` package [is not compatible](https://flysystem.thephpleague.com/docs/upgrade-from-1.x/#miscellaneous-changes) with Flysystem v2+ and only works with Laravel <= 8.

``` shell
composer require league/flysystem-cached-adapter
```

```php
/// config/filesystems.php
'disks' => [
    's3' => [
        'driver' => 's3',
        // ...
        'cache' => true,
    ]
]
```

More details in the [Laravel Docs](https://laravel.com/docs/8.x/filesystem#caching).

## 3. Disable Filesystem asserts

Flysystem also has a feature where any time you try to read a file, it will first check if it exists. You disable this though, using the `disable_asserts` (that's asserts, not assets) flag on your Asset Container's disk.

```php
/// config/filesystems.php
'disks' => [
    's3' => [
        'driver' => 's3',
        // ...
        'disable_asserts' => true,
    ]
]
```

_It's possible that in the future Statamic will do this automatically for you._

## 4. Check for existence through Assets

This one is a tip mostly for addon developers.

If you need to check if a file exists, instead of looking directly at the filesystem, you should do it using the `Asset` object since it has some extra optimizations built in.

You can call this method a million times and it will only look at the filesystem once. In the case of S3, it would only make a single API call.

```php
$asset = AssetContainer::find('s3')->makeAsset('foo.jpg');
$asset->exists();
```

Where as these methods would be looking at the filesystem every time. Depending on your situation, this might be what you need, but you should be aware that since it's looking at the filesystem every time, it'll mean an API call to S3 every time.

```php
$asset->disk()->exists($asset->path());

File::exists($asset->path());
```

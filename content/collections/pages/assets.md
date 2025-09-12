---
id: 7277432d-bb25-458a-a3a2-a72976b44ad5
blueprint: page
title: Assets
intro: 'Assets are files managed by Statamic and made available to your writers and developers with tags and fieldtypes. They can be images, videos, PDFs, or any other type of file. Assets can have fields and content attached to them, just like entries, making them very powerful.'
template: page
related_entries:
  - 5b748a3f-be0e-41c1-8877-73f6b7ee1d0a
  - b70a3d9a-6605-446e-b278-de99ba561fe0
  - 7277432d-bb25-458a-a3a2-a72976b44ad5
  - 0c30a664-9bc3-4c5e-ad8c-66452b049748
  - b50310b0-64ae-4ae4-b219-a637ed89e4d7
  - 458b8203-e330-4d78-9bf5-82aaec8d458b
  - d0c65546-74f1-4a15-89d5-1562a95ee2c6
  - 420f083d-99be-4d54-9f81-3c09cb1f97b7
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1633025886
---
## Overview

Assets live in directories on your local server, in an [Amazon S3 bucket](https://aws.amazon.com/s3), or other cloud storage services. Each defined location is called a **container**.


Statamic scans the files in each container and caches [meta information](#metadata) (like `width` and `height` for images) on them. This cache is used to speed up interactions and response times when working with them on the [frontend](/frontend) of your site.

## Asset browser

You can explore these files in the Control Panel's asset browser. You can edit, sort, search, move, rename, replace, reupload, preview, and — if working with images — even set focal crop points to make dynamically resized images look their best.

<figure>
    <img src="/img/asset-browser-v4.png" alt="Assets browser">
    <figcaption>Browsing some assets.</figcaption>
</figure>

## Asset actions

There are a number of actions that can be taken on assets while in the asset browser. Some can be run in bulk (on multiple assets at once), while others are only available on individual assets.

Single asset actions are available by clicking the options menu (three-dot icon) associated with the asset, and picking the desired action from the dropdown list.

Bulk asset actions are available at the top of the asset browser whenever you have one or more assets selected.

<figure>
    <img src="/img/asset-actions.png" alt="Assets actions">
    <figcaption>Check out those sweet actions.</figcaption>
</figure>

### Edit
Editing an asset opens a new modal window with a number of additional options, as well as any blueprint fields, like title, alt text, description, or other meta data defined on your asset container.

Most of the asset actions are also available inside the editor, along with the ability to set a Focal Point for images.

<figure>
    <img src="/img/asset-editor-v4.png" alt="The Statamic Asset Editor">
    <figcaption>The asset editor is pretty slick, if we say so ourselves.</figcaption>
</figure>

### Copy URL
Running this action allows you to copy the URL of an asset. You can use the copied URL to share or reference the asset in other places, such as in emails, documents, or on other websites.

Bulk
: No

### Download
With this action, you can download an asset to your local device. It allows you to save a copy of the asset on your computer, making it accessible even when you're offline or outside Statamic.

Bulk
: Yes

### Duplicate
The duplicate action creates a copy of an asset. It's useful when you want to have multiple copies of the same asset, either for organizational purposes or to make variations or modifications to the duplicated version without affecting the original asset.

When duplicated, the new filename will be appended with `-{numberOfDuplicates}`. If you duplicate a file 3 times, you will have new copies named `yourFile-1.ext`, `yourFile-2.ext`, `yourFile-3.ext`. Feel free to rename these. In fact, we encourage it.

Bulk
: Yes

### Move
Moving an asset involves changing its location within the folder structure of your Statamic assets. This action is handy when you want to reorganize your assets or place them in a different folder for better categorization and management.

Assets moved with the move action will update any references to it throughout your content wherever the [Assets field](/fieldtypes/assets) is used.

Bulk
: Yes

### Rename
As the name suggests, the rename action allows you to change the name of an asset. It's useful when you want to give a more descriptive or meaningful name to an asset or when you need to update the name to match changes in its content.

Assets renamed with the rename action will update any references to it throughout your content wherever the [Assets field](/fieldtypes/assets) is used.

Bulk
: Yes*

_*Each rename action only accepts one new filename, so this is only useful in bulk for renaming files of different extensions._

### Replace
The replace action lets you replace an existing asset with a new version with a new filename. This helps to ensure that your visitors don't run into browser-cached, old versions of your assets. Replaced assets with the replace action will update any references to it throughout your content wherever the [Assets field](/fieldtypes/assets) is used.

Bulk
: No

### Reupload
Reuploading an asset involves uploading a new version of an existing asset, effectively replacing the previous version with the **same exact filename**. Keep in mind that by not changing the filename, your visitors may encounter browser-cached, old versions of the asset.

Bulk
: No

### Delete
The delete action removes an asset from your site and server, permanently. Exercise caution when using this action, as deleted assets cannot always be easily restored.

Bulk
: Yes

## Asset fields

Asset fields are configured like a [blueprint](/blueprints) and attached to the [container](#containers). Whenever you edit an asset in the Control Panel, you'll see the fields from the configured blueprint.

This data is stored in the asset's [meta data](#metadata) file.

<figure>
    <img src="/img/asset-editor.png" alt="The asset editor editing an image">
    <figcaption>Editing an image with the asset editor.</figcaption>
</figure>

## Metadata

Asset metadata is stored in YAML files inside a hidden `.meta` subdirectory inside each container. For example, `images/tree.jpg` gets an `images/.meta/tree.jpg.yaml` cache file.

These files contain cached data, including but not limited to: image dimensions, file size, last modification dates, and so on.

These cache files can also contain user created data. The fields are defined by the asset container's blueprint. Typically these are alt text, focal points, descriptions, and so on, but they could be anything you want at all.

``` yaml
size: 9151
last_modified: 1558533973
width: 216
height: 104
data:
  alt: 'A tree with a tire swing'
  focus: 54-54-1
```

:::tip
You should consider version controlling these files if you plan to set data like alt tags and focal points. Make sure your efforts are preserved.
:::

## Containers

Each container has its own settings, configurable permissions, and [blueprint](#blueprints). One container might be a local filesystem with upload, download, rename, and move permissions enabled, and another could be a read-only remote S3 bucket or stock image service.

Containers can be created through the Control Panel and are defined as YAML files located in `content/assets`. Each container's filename becomes its `handle`.

``` yaml
# content/assets/assets.yaml
title: 'Assets'
disk: 'assets'
```

Each container implements a "disk", also known as a [Laravel Filesystem](https://laravel.com/docs/filesystem). This native Laravel feature groups a [driver](#drivers), URL, location, and [visibility](#container-visibility) together. Statamic includes a local disk on fresh installs. You can modify or delete it, but many sites can simply use it as is.

``` php
'disks' => [
    'assets' => [
        'driver' => 'local',
        'root' => public_path('assets'),
        'url' => '/assets',
        'visibility' => 'public', // (more info about visibility below)
    ],
]
```

Filesystems are defined in `config/filesystems.php`.  They can point to the local filesystem, S3, or any [Flysystem adapter](https://flysystem.thephpleague.com/v2/docs/).

### Private containers

Sometimes it’s handy to store assets that shouldn’t be publicly visible through a direct URL or browser.

:::tip
If your asset container's disk does not have a `url` property, Statamic will not output URLs.
:::

Private containers should be located above webroot. If you leave the disk within the webroot, the files will still be accessible directly outside of Statamic if you know the file path.

``` files theme:serendipity-light
/
  app/
  content/
  config/
  public/
    not-in-here/ # [tl! ~~]
    index.php
  put-it-out-here/ # [tl! ~~]
  resources/
  vendor/
```

Make sure to also set the [visibility](#container-visibility) to `private`.


### Container visibility

Your filesystem's disk can have a `visibility`, which is an abstraction of file permissions. You can set it to `public` or `private`,
which essentially controls whether they're accessible or not.

Be sure to set `'visibility' => 'public'` if you want to be able to see, interact with, and manipulate files in your container.

:::tip
If you're using a service based driver like Amazon S3, and you want the files to be accessible by URL, make sure you set the [visibility](#container-visibility) to `public`.
:::

## Blueprints

The default container [Blueprint](/blueprints) contains a single "alt text" field — just useful and simple enough to get you started.

You can customize the fields on the blueprint by visiting the container in the Control Panel and choosing "Edit Blueprint" in the options dropdown.

If you want to edit the blueprint file directly, you can do so in `resources/blueprints/assets/{handle}.yaml`.

## Ordering

### Default sort order in listings

You can choose which field and direction to sort the list of assets in the Control Panel by setting the `sort_by` and `sort_dir` variables in your container.yaml. By default the file name will be used.

## Drivers

Statamic uses Flysystem and includes the core `local` driver. S3, SFTP, and other drivers can be [installed with composer](https://laravel.com/docs/filesystem#driver-prerequisites).

Flysystem is not limited to these three, however. There are adapters for many other storage systems. You can [create a custom driver](https://laravel.com/docs/filesystem#custom-filesystems) if you want to use one of these additional adapters in your Laravel application.


## Frontend templating {#templating}

There are two main methods for working with Asset data on the frontend. The Assets Fieldtype, and the Assets Tag.

### Assets fieldtype

The [Assets Fieldtype](/fieldtypes/assets) can be used in your content Blueprints to attach assets to your entries, taxonomy terms, globals, or user accounts. It can be used to create image galleries, video players, zip downloads, or anything else you can think of.

All of the data stored on your Assets will be available on the frontend without having to create any kind of duplication.

#### Example

If you had a `slideshow` field with a whole bunch of images selected, you can render them by looping through them.

::tabs

::tab antlers
```antlers
<div class="slideshow">
    {{ slideshow }}
        <img src="{{ url }}" alt="{{ alt }}">
    {{ /slideshow }}
</div>
```
::tab blade
```blade
<div class="slideshow">
  @foreach($slideshow as $image)
      <img src="{{ $image->url }}" alt="{{ $image->alt }}">
  @endforeach
</div>
```
::

Learn more about the [Assets Fieldtype](/fieldtypes/assets).

### Assets tag

If you ever find yourself needing to loop over all of the assets in a container (or folder inside a container) instead of selecting them manually with the Assets Fieldtype, this is the way.

#### Example

::tabs

::tab antlers
```antlers
{{ assets container="photoshoots" limit="10" sort="rating" }}
    <img src="{{ url }}" alt="{{ alt }}" />
{{ /assets }}
```
::tab blade
```blade
<statamic:assets
  container="photoshoots"
  limit="10"
  sort="rating"
>
  <img src="{{ $url }}" alt="{{ $alt }}" />
</statamic:assets>
```
::

Learn more about the [Assets Tag](/tags/assets) and what you can do with it.

### Manipulating images

Statamic uses the [Glide library](https://glide.thephpleague.com/) to dynamically resize, crop, and manipulate images. It's really easy to use and has [its own tag](/tags/glide).

::tabs

::tab antlers
```antlers
{{ glide:image width="120" height="500" filter="sepia" }}
```
::tab blade
```blade
{{-- Using Statamic Tags --}}
<statamic:glide
  :src="$img"
  width="120"
  height="500"
  filter="sepia"
/>

{{-- Using Fluent Tags --}}

{{
  Statamic::tag('glide')
    ->src($img)
    ->width(120)
    ->height(500)
    ->filter('sepia')
    ->fetch()
}}
```
::

## Search indexes

You can configure search indexes for your collections to improve the efficiency and relevancy of your users searches. Learn [how to connect indexes](search#connecting-indexes).

## Allowed file extensions

For security reasons, Statamic restricts the file extensions that can be uploaded via the Control Panel and the Assets field on [Forms](/forms).

Common extensions like `.jpg`, `.csv` and `.txt` are permitted by default. To upload additional file extensions, specify them in `config/statamic/assets.php`:

```php
/*
|--------------------------------------------------------------------------
| Additional Uploadable Extensions
|--------------------------------------------------------------------------
|
| Statamic will only allow uploads of certain approved file extensions.
| If you need to allow more file extensions, you may add them here.
|
*/

'additional_uploadable_extensions' => [
    'gpx', 'vcf', // ...
],
```

## SVG sanitization

For security reasons, Statamic automatically sanitizes uploaded SVG files. 

However, if you **trust your users** and need to upload SVG files without them being sanitization, you may disable it:

```php
/*
|--------------------------------------------------------------------------
| SVG Sanitization
|--------------------------------------------------------------------------
|
| Statamic will automatically sanitize SVG files when uploaded to avoid
| potential security issues. However, if you have a valid reason for
| disabling this, and you trust your users, you may do so here.
|
*/

'svg_sanitization_on_upload' => false,
```

## Custom cache stores

Statamic leverages [Laravel's application cache](https://laravel.com/docs/cache) to cache asset metadata and folders. However, this means that whenever you run `php artisan cache:clear`, the cached asset information will be cleared.

If you have a lot of assets and/or folders, you might want to specify a custom cache store so the cached assets are persisted when you clear your application cache.

The cache store can be customized in `config/cache.php`.

```php
'asset_meta' => [
    'driver' => 'file',
    'path' => storage_path('statamic/asset-meta'),
],
'asset_container_contents' => [
    'driver' => 'file',
    'path' => storage_path('statamic/asset-container-contents'),
],
```

To clear these caches, run `php please assets:clear-cache`.

## Performance

If you're using [custom asset cache stores](#custom-cache-stores) and you're experiencing performance issues with Assets, like slow queries or a slow asset browser, it might be worth moving your assets to the database using the Eloquent Driver. It takes a different approach to caching asset metadata, which sometimes works better for sites with more assets.

You can find out more about [moving assets to the database here](/tips/storing-content-in-a-database#moving-content-to-the-database).

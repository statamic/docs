---
id: 2aa44c22-f626-4f9e-826d-c23ef482cf08
title: 'Using Digital Ocean Spaces for an Asset Container'
template: page
categories:
  - development
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1622821446
---
You might know it's possible to use Amazon S3 for your Asset Containers, but it's also very simple to use [DigitalOcean Spaces](https://www.digitalocean.com/products/spaces/).

Since Digital Ocean Spaces is compatible with the Amazon S3 API, you can use the `s3` flysystem driver, but with Digital Ocean credentials.

First, install the AWS Flysystem adapter:

``` shell
composer require "league/flysystem-aws-s3-v3 ~1.0"
```

Add a filesystem to `config/filesystems.php`, and make sure to use the `s3` driver.

```php
'do_spaces' => [
    'driver' => 's3',
    'key' => env('DO_SPACES_KEY'),
    'secret' => env('DO_SPACES_SECRET'),
    'endpoint' => env('DO_SPACES_ENDPOINT'),
    'region' => env('DO_SPACES_REGION'),
    'bucket' => env('DO_SPACES_BUCKET'),
    'root' => env('DO_SPACES_ROOT'),
    'url' => env('DO_SPACES_URL'),
    'visibility' => 'public', // Set this public so the files uploaded are available publically.
],
```

Add the following enviromental variables to your `.env` file and fill in with the values unique to your Space. You can generate keys and secrets from the DigitalOcean API settings.

```env
DO_SPACES_KEY=
DO_SPACES_SECRET=
DO_SPACES_ENDPOINT=https://ams3.digitaloceanspaces.com  # Depending on your region.
DO_SPACES_REGION=AMS3                                   # Depending on your region.
DO_SPACES_BUCKET=statamic                               # The name of your Space.
DO_SPACES_ROOT=the_folder/you_want                      # The root folder on your Space you want for this container.
DO_SPACES_URL=https://cdn.statamic.com/                 # The URL Statamic should prepend to the file name and the root when you request an asset in your templates.
```

Create a new Asset Container using this `do_spaces` as a Disk. You can do this via the CP or add a `handle.yaml` file to `content/assets`:

```yaml
title: "MySpace"
disk: do_spaces
```

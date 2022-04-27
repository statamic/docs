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

## Install

First, install the AWS Flysystem adapter:

``` shell
composer require league/flysystem-aws-s3-v3
```

## Configure a filesystem

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

```env
DO_SPACES_KEY=
DO_SPACES_SECRET=
DO_SPACES_ENDPOINT=
DO_SPACES_REGION=
DO_SPACES_BUCKET=
DO_SPACES_ROOT=
DO_SPACES_URL=
```

- The `key` and `secret` can be generated in the "API" section of your dashboard.
- You can find the `endpoint` in the Space's settings. It'll look something like `https://nyc3.digitaloceanspaces.com`.
- The `region` will be in the endpoint. e.g. `nyc3`
- The `bucket` will be the name of your space. e.g. `myspace`
- You only need to set the `root` if you want this disk to be a subfolder of your space. This is fairly uncommon.
- The `url` will be in the header of the file browser, or in list of your spaces. It'll look something like `https://myspace.nyc3.digitaloceanspaces.com`
- If you've enabled the CDN, it's possible you'd have a non-Digital Ocean `url`. Look for the "edge" URL.

## Link to the asset container

Create a new Asset Container using this `do_spaces` as a Disk. You can do this via the CP or add a `handle.yaml` file to `content/assets`:

```yaml
title: "MySpace"
disk: do_spaces
```

:::tip
If you're having performance issues with S3 containers in the Control Panel, check out these [optimization tips](/tips/optimizing-assets).
:::


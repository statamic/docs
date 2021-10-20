---
id: ede9cc18-90fe-4775-9e50-83724149abf3
title: 'Troubleshooting Asset Permissions'
intro: 'You''ve uploaded files to a service like Amazon S3 or Digital Ocean Spaces, but your files are private.'
template: page
categories:
  - troubleshooting
  - privacy-gdpr
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1622821358
---
By default, filesystem disk permissions are private for security.

If you want your assets to be publicly accessible, you need to set your disk's `visibility` to `public` in `config/filesystems.php`.

``` php
's3' => [
    'driver' => 's3',
    'key' => env('AWS_ACCESS_KEY_ID'),
    'secret' => env('AWS_SECRET_ACCESS_KEY'),
    'region' => env('AWS_DEFAULT_REGION'),
    'bucket' => env('AWS_BUCKET'),
    'url' => env('AWS_URL'),
    'visibility' => 'public', // 👈 you're missing this
],
```

Conversely, if you **want** your files to be private, then you can either remove that line, or set it to `private`.

:::tip
This setting only applies to newly uploaded files. You'll need to log into AWS or Spaces and bulk change the permissions on existing files.
:::

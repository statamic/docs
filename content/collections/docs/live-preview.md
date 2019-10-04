---
title: 'Live Preview'
intro: 'Live Preview gives you the ability to see what your entry will look like in real time as you write and edit. You can control the preview screen size and even pop it out into a new window.'
template: page
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1570191892
id: cdffd2c9-cf42-495d-a8f1-f416ddfddc29
---
## Device Sizes

You can customize the list of device sizes in `config/statamic/live_preview.php`.

``` php
    'devices' => [
        'Laptop' => ['width' => 1440, 'height' => 900],
        'Tablet' => ['width' => 1024, 'height' => 786],
        'Mobile' => ['width' => 375, 'height' => 812],
    ],
```
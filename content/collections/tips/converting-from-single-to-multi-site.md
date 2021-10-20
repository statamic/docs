---
id: e1da92af-a0d8-40bb-9417-52675fad5e1f
title: 'Converting from Single to Multi-site'
template: page
categories:
  - development
  - cli
  - localization
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1622821029
---
## Move files

:::tip
This can be automated using the following command:

```shell
php please multisite
```

It's important to run the command **before** making changes to the config file.
:::

2. For each collection:
    - Move all entries into a directory named after the first site's handle. (eg. `content/collections/blog/*.md` into `content/collections/blog/default/*.md`)
    - Add a `sites` array to the collection's yaml file with each site you want the entries to be available in.
3. For each structure:
    - Take the `root` and `tree` variables, and move them in a file in a subdirectory named after the first site's handle. (eg. `content/structures/pages.yaml` to `content/structures/default/pages.yaml`)
    - Add a `sites` array to the root structure's yaml file with each site you want the structure to be available in.
4. For each global set:
    - Take the values inside the `data` array, and move them to the top level in a file in a subdirectory named after the first site's handle. (eg. `content/globals/pages.yaml` to `content/globals/default/pages.yaml`)
    - Add a `sites` array to the root global's yaml file with each site you want the structure to be available in.
5. Clear the cache:
  ``` shell
  php artisan cache:clear
  ```

At this point, your content will be available in the default site. You will need to localize each piece of content by following the steps in its respective documentation.

**If you don't add the `sites` to the respective container files, the site selector will not be visible in the control panel.**

## Update config

Add the new site to your `config/statamic/sites.php` config.

``` php
return [
    'sites' => [
        'default' => [
            'name' => 'First site',
            'locale' => 'en_US',
            'url' => '/',
        ],
        'second' => [
            'name' => 'Second site',
            'locale' => 'en_US',
            'url' => '/second/',
        ],
    ]
];
```

By default, the first site is named `default`, but feel free to rename it.

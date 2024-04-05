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
## Automated Conversion

We recommend using the following command to convert from a single to multi-site installation:

``` shell
php please multisite
```

## Manual Conversion

If you wish to better understand how to manually convert from a single to multi-site installation, the steps are as follows.

### Enable Multisite Config

First, enable `multisite` in your `config/statamic/system.php`:

``` php
'multisite' => true,
```

### Adding New Sites

Next, you can add new sites through the control panel at `/cp/sites`, or directly in your `content/sites.yaml` file:

``` yaml
default:
  name: First Site
  locale: en_US
  url: /
second:
  name: Second Site
  locale: en_US
  url: /second/
```

By default, the first site handle is named `default`, but feel free to rename it. This handle will be used below.

### Update Default Site Content

Now you'll need to update your default site content file & folder structure, so that Statamic knows where to find it, now that you've enabled multi-site.

1. For each collection:
    - Move all entries into a directory named after your default site's handle. (eg. `content/collections/blog/*.md` into `content/collections/blog/default/*.md`)
    - Add a `sites` array to the collection's yaml file with each site you want the entries to be available in.
2. For each tree structure:
    - Take the `root` and `tree` variables, and move them in a file in a subdirectory named after your default site's handle. (eg. `content/trees/navigation/pages.yaml` to `content/trees/navigation/default/pages.yaml`)
    - Add a `sites` array to the root structure's yaml file with each site you want the structure to be available in.
3. For each global set:
    - Take the values inside the `data` array, and move them to the top level in a file in a subdirectory named after the default site's handle. (eg. `content/globals/pages.yaml` to `content/globals/default/pages.yaml`)
    - Add a `sites` array to the root global's yaml file with each site you want the global to be available in.

At this point, your content will be available in the default site. You will need to localize each piece of content by following the steps in its respective documentation.

_**Note:** If you don't add the `sites` to the respective container files, the site selector will not be visible in the control panel._

### Clear The Cache

Finally, clear your cache!

``` shell
php artisan cache:clear
```

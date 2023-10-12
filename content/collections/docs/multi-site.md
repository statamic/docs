---
title: Multi-Site
intro: |
    Statamic's multi-site capabilities are designed to manage a **single site** or site network with multiple localizations, variations, or sections running on one or more domains or subdomains. It can be used to manage translations, country-specific versions of a company site, and other similar use cases. _It is not intended to be used for multi-tenant applications._
template: page
id: fb20f2e0-3881-43e6-8507-3308a18c54b0
blueprint: page
pro: true
---
## Overview

Statamic can be configured to handle multiple "sites". A site is a way of managing a localized version of your content - whether another language, region, or even company/brand (think Proctor & Gamble).

Each site can have different base URLs:

- domains: `hello.com` and `bonjour.com`
- subdomains: `example.com` and `fr.example.com`
- subdirectories: `example.com` and `example.com/fr/`

[More details on how to convert to a multi-site setup](/tips/converting-from-single-to-multi-site)

## Configuration

Let's look at a full site configuration and then we'll explore all of its options.

``` php
# config/statamic/sites.php

return [
    'sites' => [
        'default' => [
            'name' => config('app.name'),
            'locale' => 'en_US',
            'url' => '/',
            'direction' => 'ltr',
        ]
    ]
];
```

### Sites
Every Statamic install needs at least one site. Building zero sites is a bad way to build a website and clients will probably challenge any invoices.

### Locale
Each site has a `locale` used to format region-specific data (like date strings, number formats, etc). This should correspond to a the server's locale. By default Statamic will use English – United States (`en_US`).

:::tip
To see the list of installed locales on your system or server, run the command `locale -a`.
:::

### Language
Statamic's control panel has been translated into more than a dozen languages. The language translations files live in `resources/lang`.

You may specify which language translation to be used for each site with the `lang` setting.

Note that both Statamic and Laravel don't ship with frontend language translations out of the box. You have to provide your own string files for this. There is a great package called [Laravel Lang](https://github.com/Laravel-Lang/lang) containing over 75 languages that can help you out with this.

### URL
URL is required to define the root domain Statamic will serve and generate all URLs relative to. The default `url` is `/`, which is portable and works fine in most typical sites. Statamic uses a little magic to work out what a full URL is be based on the domain the site is running on.

:::best-practice
It can be a good idea to change this to a **fully qualified, absolute URL**. This ensures that server/environment configurations or external quirks interfere with that "magic". Using an environment variable is an ideal solution here.

```php
'sites' => [
    'en' => [
        // ...
        'url' => env('APP_URL')
    ],
    'fr' => [
        // ...
        'url' => env('APP_URL').'fr/'
    ]
]
```

```env
# production
APP_URL=https://mysite.com/

# development
APP_URL=http://mysite.test/
```

:::

### Text Direction

All sites are Left-To-right (`ltr`) by default, and you may omit the setting entirely. But if any of your sites is in a `rtl` text direction (like Arabic or Hebrew), you may define the direction in the config and use it on your front-end wherever necessary.

```php
'sites' => [
    'en' => [
        'name' => 'English',
    ],
    'he' => [
        'name' => 'Hebrew',
        'direction' => 'rtl',
    ]
]
```

```
<html dir="{{ site:direction }}">
```

:::tip
Statamic's `direction` is `ltr` by default. You only need to set `direction` when your site is `rtl`.
:::

### Additional Attributes

You may also add an array of arbitrary attributes to your site's config, which can later be accessed with the [site variable](/variables/site) .

```php
'sites' => [
    'en' => [
        'name' => 'English',
        'attributes' => [
            'theme' => 'standard',
        ]
    ],
]
```

```
<body class="theme-{{ site:attributes:theme }}">
```

:::tip
Nothing fancy happens here, the values are passed along "as is" to your templates. If you need them to be editable, or store more complex data, you could use [Globals](/globals).
:::


## Adding a Site

To add another site to an existing multi-site installation, add another array to the `$sites` configuration array along with the desired settings.

```php
'sites' => [
    'en' => [
        'name' => 'English',
        //
    ],
    'de' => [
        'name' => 'German',
        //
    ],
];
```

## Renaming a Site

If you rename a site handle, you'll need to update a few folders and config settings along with it. Replace `{old_handle}` with the new handle in these locations:

**Content Folders**

- `content/collections/{old_handle}/`
- `content/globals/{old_handle}/`
- `content/trees/{old_handle}/`

**Collection Config YAML Files**
``` yaml
# content/collections/{collection}.yaml
sites:
- {old_handle}
- de
- fr
```

## Permissions

Within the Control Panel, you will not be able to access items in a particular site if you do not have permission.

You may grant permission for any of your sites by adding an `access {site_handle} site` to the appropriate role.

For example:

```yaml
permissions:
  - edit blog entries
  - access english site # [tl!++]
  - access french site  # [tl!++]
```

[Read more about permissions](/users#permissions)


## Per-Site Views {#views}

[Views](/views) can be organized into site directories.

If a requested view exists in a subdirectory with the same name as your site, it will load it instead. This allows you have site-specific views without any extra configuration.

``` php
# config/statamic/sites.php

'sites' => [
    'site_one' => [ /* ... */ ],
    'site_two' => [ /* ... */ ],
]
```

``` files theme:serendipity-light
resources/views/
    site_one/
        home.antlers.html
    home.antlers.html
    page.antlers.html
```

For example, given `template: home`, Statamic will load `site_one/home` because that view exists in the subdirectory. If you were to have `template: page`, it would load the one in the root directory because there's no site-specific variant.

:::tip
This feature can be combined with the [AMP](/amp) feature. You can nest an `amp` view subdirectory _inside_ a site subdirectory.
:::

## Template Snippets

Here are a few common features you'll likely need to template while building a multi-site.

### Building a Site Switcher {#site-switcher}

This will loop through your sites and indicate the current site as the active one. Check out all the [available variables inside the `sites` loop](/variables/sites).

```
{{ sites }}
  <a class="{{ site:handle === handle ?= 'active' }}" href="{{ url }}">
    {{ handle }}
  </a>
{{ /sites }}
```

### Declaring the Page Language

Indicate the current language of the site by setting the `lang` attribute on your `<html>` tag (most likely in your layout view), or the container element around translated content if the page mixes and matches languages.

```
<html lang="{{ site:short_locale }}">
```

## Static Caching

If your multi-site should use static caching, you will also need to add additional config parameters and different server rewrite rules. Please refer to the related section of the [static caching documentation](/static-caching#multisite) for the correct settings.

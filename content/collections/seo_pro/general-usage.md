---
id: 7f8eca1b-8d0c-4daf-99ce-b23a2ac44256
blueprint: seo_pro
title: 'General Usage'
---
SEO settings will cascade down from the global defaults, to the collection/taxonomy level, and finally to the entry/term level.

Empty meta tags will not be rendered, which allows you to optionally set your own tags with other means if you so choose.

## Site Defaults

Head to `Tools > SEO Pro > Site Defaults` and configure your default settings. The defaults will be used if you haven't set anything more specific at the collection or entry level.

> Values configured here will be saved into `content/seo.yaml`.

You may choose to pull data from other fields, enter hardcoded strings, or use Antlers templating. See [File Usage](/seo-pro/file-usage) for more details.

## Section Defaults

Each section may be configured independently at the Collection / Taxonomy level. Head to `Tools > SEO Pro > Section Defaults` to configure default settings at this level. You may opt to inherit values from the defaults and tweak as necessary.

> Values configured here will be saved into the seo array (within `inject`) in the respective section's yaml config.

You may disable a section by toggling the "Enabled" field when editing a section, or set `seo: false` within the inject array in that section's yaml config. Disabling a section will prevent it's items from being included in reports, the sitemap, and prevent the template tag from rendering anything.

## Entries and Terms

It's better to configure your collections and taxonomies to dynamically pull from fields. However, an SEO tab will be added to each item's publish page and you are free to override any values there.

> Values configured here will be saved into the `seo` array in the item's front-matter.

## Assets

If you wish to use assets in your meta, you can [publish the SEO Pro config](/seo-pro/advanced-configuration) and specify an asset container, as well as the glide preset to be used.

> You may disable the glide preset altogether by setting `'open_graph_preset' => false,` in your config.

## Custom Statamic Routes

In the case that you're loading a custom [Statamic Route](/routing#statamic-routes), you can pass SEO meta directly into the route data param. This allows you to define custom meta on a route-by-route basis in situations without a proper collection entry.

```php
Route::statamic('search', 'search/index', [
    'title' => 'Search',
    'description' => 'Comprehensive Site Search.',
    // ...
]);
```
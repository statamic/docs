---
id: 1917f8a1-4b89-410b-ba3d-20d85bcc9ded
blueprint: seo_pro
title: 'Advanced Configuration'
---
## Publishing Config

You can publish SEO Pro's config for modification by running the following:

```bash
php artisan vendor:publish --tag="seo-pro-config"
```

## Publishing Views

You can publish SEO Pro's `sitemap.xml` and `humans.txt` views for modification by running the following:

```bash
php artisan vendor:publish --tag="seo-pro-views"
```

These views will be published into your `resources/views/vendor/seo-pro` directory for modification.

You may also override the default `meta.antlers.html` view, though it is not published by default. ***Important Note***: Overriding this view will require you to be mindful of updates as it will not be automatically maintained for you.

## Sitemap.xml

A `sitemap.xml` route is automatically generated for you.

If you disable SEO on the section or item level, the relevant section/item will automatically be discluded from the sitemap.

If you wish to completely disable the sitemap, change it's URL, or customize it's cache expiry, you can [publish the SEO Pro config](/seo-pro/advanced-configuration) and modify these settings within `config/statamic/seo-pro.php`.

If you wish to customize the contents of the `sitemap.xml` view, you may also [publish the SEO Pro views](/seo-pro/advanced-configuration#publishing-views) and modify the provided antlers templates within your `resources/views/vendor/seo-pro` folder.

## Pagination Meta

By default, `canonical` URL meta will show pagination on `?page=2` and higher, with `rel="prev"` / `rel="next"` links when appropriate.

If you wish to customize or disable pagination, you can [publish the SEO Pro config](/seo-pro/advanced-configuration) and modify these settings within `config/statamic/seo-pro.php`.

## Twitter Card Meta

By default, `twitter:card` meta will be rendered using `summary_large_image`.

If you wish to change this to `summary`, you can [publish the SEO Pro config](/seo-pro/advanced-configuration) and modify your twitter card within `config/statamic/seo-pro.php`.
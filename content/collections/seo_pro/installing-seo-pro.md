---
id: 40678d50-2bca-427d-8c9a-5c1bd4cbe1f5
blueprint: seo_pro
title: 'Installing & Uninstalling'
---
## Installation

1. Install SEO Pro with Composer:

```bash
composer require statamic/seo-pro
```

2. Add the Antlers tag or Blade directive somewhere between your `<head>` tags.

* Antlers: `{{ seo_pro:meta }}`
* Blade `@seo_pro('meta')`

## Uninstalling

To uninstall, run:

```bash
composer remove statamic/seo-pro
```

If you've saved any blueprints while SEO Pro was installed, an `seo` field will have been added to them. You will need to manually remove the `seo` field from the corresponding blueprints.
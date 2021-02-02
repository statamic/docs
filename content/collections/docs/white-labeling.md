---
title: 'White Labeling'
intro: 'White Labeling allows you to customize the logo, visible name, and basic theme of the CMS throughout the control panel.'
template: page
stage: 'Needs Polish & Humor'
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1612297554
id: 5bd9426f-23cf-4196-9848-471dff67f5ea
---

## Configuration
Your White Label options are available in `config/statamic/cp.php` or through their corresponding .env variables.

> Keep in mind that according to the license terms you can only rebrand for personal, internal, or client usage. You cannot resell Statamic under another name.

### CP Theme

You can choose to switch the default "rad" login theme with a more vanilla (and boring) "business" theme.

``` php
'theme' => env('STATAMIC_THEME', 'rad'),
```

**Available options**:

- `rad`
- `business`

<div class="screenshot">
    <img src="/img/white-label-login.png" alt="Statamic White Label Theme">
    <div class="caption">Here's the "business" theme with a custom logo</div>
</div>

### Custom CMS Name

Set a custom name for the CMS.

``` php
'custom_cms_name' => env('STATAMIC_CUSTOM_CMS_NAME', 'Statamic'),
```

### Custom Logo

Swap out the logo with a URL to one of your own.

``` php
'custom_logo_url' => env('STATAMIC_CUSTOM_LOGO_URL', null),
```

### Custom Favicon

Swap out the favicon with a URL to one of your own.

``` php
'custom_favicon_url' => env('STATAMIC_CUSTOM_FAVICON_URL', null),
```
### Custom CSS

Set the path to a CSS file and easily add your own styles to the control panel.

``` php
'custom_css_url' => env('STATAMIC_CUSTOM_CSS_URL', null),
```

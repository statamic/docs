---
title: 'White Labeling'
intro: 'White Labeling allows you to customize the logo, visible name, and basic theme of the CMS throughout the control panel.'
template: page
blueprint: page
pro: true
id: 5bd9426f-23cf-4196-9848-471dff67f5ea
---

## Configuration

White Label options are available in `config/statamic/cp.php` or through corresponding [environment variables](configuration#environment-variables).

:::warning
Keep in mind that according to the license terms you can only rebrand for personal, internal, or client usage. You cannot resell Statamic under another name.
:::

### CP Theme

You can choose to switch the default "rad" login theme with a more vanilla (and boring) "business" theme.

``` php
'theme' => env('STATAMIC_THEME', 'rad'),
```

**Available options**:

- `rad`
- `business`

<figure>
    <img src="/img/white-label-login.png" alt="Statamic White Label Theme">
    <figcaption>Here's the "business" theme with a custom logo</figcaption>
</figure>

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

You may set different logos for inside and outside Control Panel (nav bar and login screen, respectively) by passing an array.

``` php
'custom_logo_url' => [
    'nav' => '/logo-white.png',
    'outside' => '/logo-dark.png'
],
```

You can also specify a different URL to be used when in Dark Mode:

``` php
'custom_logo_url' => '/logo-light-mode.png',

'custom_dark_logo_url' => '/logo-dark-mode.png',
```

### Custom Logo Text

Display a custom name in plain text in the control panel; automatically changes when in Dark Mode.

When defined, logo image URLs will take precedence over logo text.

``` php
'custom_logo_text' => env('STATAMIC_CUSTOM_LOGO_TEXT', null),
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

### Support URL

Set the location of the support link in the "Useful Links" header dropdown. Use `false` to remove it entirely.

```php
'support_url' => env('STATAMIC_SUPPORT_URL', 'https://statamic.com/support'),
```

### Documentation

Whether to show links to Statamic documentation throughout the Control Panel.

```php
'link_to_docs' => env('STATAMIC_LINK_TO_DOCS', true),
```

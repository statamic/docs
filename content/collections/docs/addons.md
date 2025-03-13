---
id: bc2ad29d-50c3-47fb-9213-8553bcb5a48a
blueprint: page
title: 'Addons Overview'
intro: 'Developers can easily build new features that are compatible with everyone’s Statamic installations. Addons can then be easily shared or sold to others to let them extend their Statamic installation.'
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1632424769
---
## Finding Addons

You can browse the [Statamic Marketplace](https://statamic.com/addons) to find addons, or use the "Addons" section inside your Statamic Control Panel.

## Installing Addons

You can use Composer to install any addon:

``` shell
composer require vendor/package
```

The command can be found on the addon's page in the Control Panel or the Statamic Marketplace.

:::tip
Some first party addons – such as the Static Site Generator or Eloquent Driver - have their own dedicated commands which will be noted on the same pages.

```shell
php please install:ssg 
```
:::

## Creating Addons

To learn how to create your own addon, as well as publishing it to the Statamic Marketplace, head over to the [Extending Statamic](/extending/addons) area.

## Licensing

Addons may require a license, which you can purchase at the [Marketplace](https://statamic.com/marketplace). Licenses may be attached to a site in your [account area](https://statamic.com/account/sites). Make sure that you have your site key entered into your Statamic project.

You can try out commercial addons locally for free. Be sure to purchase a license before deploying to production.

## Editions

An addon may have multiple editions, which may cost different amounts and provide different sets of features.

You can choose which edition is installed by entering it into your `config/statamic/editions.php` file:

``` php
'addons' => [
    'vendor/package' => 'pro', // e.g., 'jezzdk/statamic-google-maps' => 'pro'
]
```

Or, by choosing it from an addon's details view in the Control Panel.

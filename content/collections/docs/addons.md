---
title: Building Addons
id: 5bb3e677-8b9c-4e77-be24-5fefec9c1af0
intro: Developers can easily build new features that are compatible with everyone’s Statamic installations. Addons can then be easily shared or sold to others to let them extend their Statamic installation.
blueprint: page
---

## Finding Addons

You can browse the [Statamic Marketplace](https://statamic.com/addons) to find addons, or use the "Addons" section inside your Statamic Control Panel.

## Installing Addons

Within the Control Panel, you can install addons by browsing to the one you want and clicking install. Behind the scenes, the addon will be installed using Composer.

If you want to do it yourself, you can use Composer directly on the command line:

``` bash
composer require vendor/package
```

## Creating Addons

To learn how to create your own addon, as well as publishing it to the Statamic Marketplace, head over to the [Extending Statamic](/extending/addons) area.

## Licensing

Addons may require a license, which you can purchase at the [Marketplace](https://statamic.com/marketplace). Licenses may be attached to a site in your [account area](https://statamic.com/account/sites). Make sure that you have your site key entered into your Statamic project.

## Editions

An addon may have multiple editions, which may cost different amounts and provide different sets of features.

You can choose which edition is installed by entering it into your `config/statamic/editions.php` file:

``` php
'addons' => [
    'vendor/package' => 'pro',
]
```

Or, by choosing it from an addon's details view in the Control Panel.

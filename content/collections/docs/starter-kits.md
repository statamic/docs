---
id: 3a2e714c-57de-4b16-a916-7e7aba22de03
title: 'Starter Kits'
intro: 'Designers and developers can easily build starter kits to help people get up and running quickly with Statamic. Whether it''s a theme, an icon set, a pre-configured collection, or a set of re-usable blueprints, the sky is the limit! Starter kits can be easily shared or sold on the Statamic Marketplace.'
stage: 3
---
## Finding Starter Kits

You can browse the [Statamic Marketplace](https://statamic.com/marketplace) to find starter kits, or use the "Starter Kits" section inside your Statamic Control Panel.

## Installing Starter Kits

Within the Control Panel, you can install starter kits by browsing to the one you want and clicking install.

If you want to manually install into an existing site, you can run the following command directly on the command line:

``` bash
php please starter-kit:install vendor/starter-kit
```

If you are spinning up a new Statamic installation, you may also use the [Statamic CLI Tool](https://github.com/statamic/cli):

``` bash
statamic new my-site vendor/starter-kit
```

### Installing a paid starter kit

If you are installing a paid starter kit, you will be prompted to purchase and/or validate a single-use license. Once successfully installed, this license will be marked as used, and cannot be used on future Statamic sites.

### Clearing your site first

If you are installing into a fresh Statamic installation (a theme for example), you may wish to clear your site of any sample content first.

If you are installing a more modular starter kit into an existing Statamic site (an icon set for example), you will want to skip this step!

The installer should ask you if you wish to clear your site first, but you can also force clear by running with the `--clear-site` install option.

### Installing without dependencies

If you wish to install without bundled dependencies, you can run with the `--without-dependencies` install option.

## Creating Starter Kits

To learn how to create your own starter kit, as well as publishing it to the Statamic Marketplace, head over to the [Extending Statamic](/extending/starter-kits) area.

## Licensing

Some starter kits may require a license, which you can purchase at the [Marketplace](https://statamic.com/marketplace).

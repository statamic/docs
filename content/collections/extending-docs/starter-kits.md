---
id: c10e059a-58ad-4d70-b57e-1c2c00e20dbb
title: Starter Kits
template: page
updated_by: 42bb2659-2277-44da-a5ea-2f1eed146402
intro: 'A starter kit is pre-configured set of files and/or settings you intend to reuse, distribute, or sell, to get a Statamic site up and running quickly.'
stage: 1
---
## Overview

Starter kit development happens within a real instance of Statamic, as if you were developing a regular Statamic site using your normal preferred workflows. For example, maybe you are building a starter kit theme, the high-level workflow could look like this:

1. Create a new Statamic project.

2. Develop the theme as you normally would.

3. Export the theme to a separate repo for redistribution.
    ``` bash
    php please starter-kit:export ../kung-fury-theme
    ```

4. Publish to [Github](https://github.com/), [Gitlab](https://gitlab.com/), or [Bitbucket](https://bitbucket.org/).

5. Install into new Statamic projects.
    ``` bash
    php please starter-kit:install the-hoff/kung-fury-theme
    ```


## Creating a Starter Kit

The first step is to [create a new Statamic project](http://docs.test/installation#creating-a-new-statamic-project). This is essentially a throwaway sandbox that you will use to develop and test your starter kit.


## Exporting Files

When ready to export your Starter Kit, run the following command:

``` bash
php please starter-kit:export {export_repo_path}
```

If you are exporting for the first time, a new `starter-kit.yaml` config file will be created in your app's root, and you will be instructed to configure which paths you would like to export.

For example, the following config would tell Statamic to export sample content, along with related assets, config, blueprints, css, views, and front-end build config out for distribution on the Statamic Marketplace. Anything not configured in your `starter-kit.yaml` will not be exported; This way you don't have to maintain a full Statamic site, or any bootstrapping that is unrelated to your starter kit.

``` yaml
export_paths:
  - content
  - config/filesystems.php
  - config/statamic/assets.php
  - resources/blueprints
  - resources/css/site.css
  - resources/views
  - public/assets
  - public/css
  - package.json
  - tailwind.config.js
  - webpack.mix.js
```

Once your export paths are configured, re-run the above `starter-kit:export` command. Your files should now be available at your new export repo path.


## Exporting Dependencies

If you wish to bundle any of your installed Composer dependencies with your starter-kit, just `composer require` them in your sandbox project as you would into any app, then add them under a `dependencies` array in your `starter-kit.yaml` config file:

``` yaml
dependencies:
  - statamic/ssg
```

The exporter will automatically detect the installed versions and whether or not they are installed as dev dependencies, and export accordingly.

When [installing the starter kit](#installing-a-starter-kit), composer will install with the same version constraints as you had installed in your sandbox project during development.


## Publishing a Starter Kit

Once exported, you will notice that a sample `composer.json` file was created at your specified export repo path. Make sure you update the package's vendor name:

``` json
{
    "name": "the-hoff/kung-fury-theme",
    "extra": {
        "statamic": {
            "name": "Kung Fury Theme",
            "description": "Kung Fury Theme starter kit"
        }
    }
}
```

Now create a `README.md` file and push to [Github](https://github.com/), [Gitlab](https://gitlab.com/), or [Bitbucket](https://bitbucket.org/), as you would any PHP package. This is all that is required to publish a free starter kit!

> Unlike addons, you are not required to register on [Packagist](https://packagist.org/).

If you would like more exposure, or if you would like to charge for your starter kit, you can also [publish to the Statamic Marketplace](#publishing-to-the-marketplace).


## Publishing to the Marketplace

Once your starter kit is ready to be shared, you can publish it on the [Statamic Marketplace](https://statamic.com/marketplace) where it can be discovered by others.

Before you can publish your starter kit, you'll need a couple of things:

- Create a [statamic.com seller account](https://statamic.com/seller)
- If you're planning to charge for your starter kits, you'll need to link connect your bank details to your seller account.

In your seller dashboard, you can create a product. There you'll be able to link your Composer package that you created on Packagist, choose a price, write a description, and so on.

Products will be marked as drafts that you can preview and tweak until you're ready to go.

Once published, you'll be able to see your starter kit on the Marketplace and within the Starter Kits area of the Statamic Control Panel.


## Installing a Starter Kit

To install into an existing site, you can run the following command directly on the command line:

``` bash
php please starter-kit:install vendor/starter-kit
```

If you are spinning up a new Statamic installation, you may also use the [Statamic CLI Tool](https://github.com/statamic/cli):

``` bash
statamic new my-site vendor/starter-kit
```

More information on basic install options for the end-user [are explained here](/starter-kits#installing-starter-kits).


## Maintaining a Starter Kit

When making changes to your starter kit, just [re-export](#exporting-files) from your development repo and push your changes from your exported repo.

### Keeping up-to-date with Statamic and Laravel

Rather than maintaining your development repo as new Statamic and Laravel versions are released, you can always install your starter kit into a fresh Statamic instance by using the `--with-config` install option.

``` bash
statamic new kung-fury-dev the-hoff/kung-fury-theme --with-config
```

This will install your starter kit into a brand new Statamic project, along with your `starter-kit.yaml` config file for future exports.


## Addons vs. Starter Kits

Both addons and starter kits can be used to extend the Statamic experience, but they have different strengths and use cases:

### Addons

- Addons are installed via `composer`, like any PHP package
- Addons live within your app's `vendor` folder after they are installed
- Addons can be updated over time
- Addon licenses are tied to your site

> An example use case is a custom fieldtype maintained by a third party vendor. Though you would install and use the addon within your app, you would still rely on the vendor to maintain and update the addon over time.

### Starters Kits

- Starter kits are installed via `php please starter-kit:install`
- Starter kits install pre-configured files and settings into your site
- Starter kits do not live as updatable packages within your apps
- Starter kit licenses are not tied to a specific site, and expire after a successful install

> An example use case is a front end theme with sample content. This is the kind of thing you would install into your app once, and modify to suit your style. You would essentially own and maintain the installed files yourself.

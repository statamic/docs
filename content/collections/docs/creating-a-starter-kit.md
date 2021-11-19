---
id: 9c703f43-30de-4f65-98bb-2b89f80012b7
title: 'Creating a Starter Kit'
template: page
blueprint: page
intro: 'Thinking of creating your own Statamic Starter Kit? Here''s everything you need to know to get started.'
nav_title: Creating
---
## Overview

Starter kit development happens within a real instance of Statamic, just like developing any other Statamic site using your normal, preferred workflows.

A released Starter Kit package contains **only** the files relevant to the kit itself, and not a full Statamic/Laravel instance. Our Import/Export tools will allow you to maintain **only those relevant files**, without having to worry about maintaining the Statamic and underlying Laravel instances as they get updated over time.

The **Export** command will export all the files and directories you've created or configured to a new location. It's this directory that becomes the package, and is the thing you should version control, not the sandbox instance.

For example, maybe you are creating a pre-built, theme-style Starter Kit, the high-level workflow might look like this:

1. Create a new Statamic project.

2. Develop the theme as you normally would.

3. Export the theme to a separate repo for redistribution.
    ``` shell
    php please starter-kit:export ../kung-fury-theme
    ```

4. Publish to [Github](https://github.com/), [Gitlab](https://gitlab.com/), or [Bitbucket](https://bitbucket.org/).

5. Install into new Statamic projects.
    ``` shell
    php please starter-kit:install the-hoff/kung-fury-theme
    ```


## Creating the Starter Kit Project

The first step is to [create a new Statamic project](/installing#creating-a-new-statamic-project). This is essentially a throwaway sandbox that you will use to develop and test your starter kit.


## Exporting Files

When ready to export your Starter Kit, run the following command:

``` shell
php please starter-kit:export {export_repo_path}
```

If you are exporting for the first time, a new `starter-kit.yaml` config file will be created in your app's root, and you will be instructed to configure which `export_paths` you would like to export.

For example, the following config would tell Statamic to export sample content, along with related assets, config, blueprints, css, views, and front-end build config out for distribution on the Statamic Marketplace.

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

Anything not configured in your `starter-kit.yaml` **will not be exported**. This way you don't have to maintain a full Statamic site, or any bootstrap code that is unrelated to your Starter Kit.

Once your export paths are configured, re-run the above `starter-kit:export` command. Your files should now be available at your new export repo path.

### Avoiding Path Conflicts

If you have a filename conflict between your sandbox and your starter kit repo, you can use `export_as` to customize its export path.

For example, you may wish to export a `README.md` for installation into new sites that is separate from the `README.md` in your starter kit repo.

``` yaml
export_as:
  file-in-sandbox.md: file-in-exported-repo.md
  README.md: README-for-new-site.md
```

This will instruct `starter-kit:export` to rename each of those paths on export, and in reverse on `starter-kit:install` to match where you had them in your sandbox app.


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

Now create a `README.md` file and push to [Github](https://github.com/), [Gitlab](https://gitlab.com/), or [Bitbucket](https://bitbucket.org/), as you would any PHP package. This is all that is required to publish a free Starter Kit!

:::tip
Unlike addons, you are not required to register on [Packagist](https://packagist.org/).
:::

If you would like to share your kit, receive more exposure, or would like to charge for your Starter Kit, you should [publish it to the Statamic Marketplace](#publishing-to-the-marketplace).


## Publishing to the Marketplace

Once your Starter Kit is ready for the world, you can publish it on the [Statamic Marketplace](https://statamic.com/marketplace) where it can be discovered by others.

Before you can publish your Starter Kit, you'll need a couple of things:

- A [Statamic Seller Account](https://statamic.com/seller)
- A connected [Stripe](https://stripe.com) account _only if_ you're planning to sell your Starter Kits.

In your seller dashboard, you can create a product. There you'll be able to link your Composer package that you created on Packagist, choose a price, write a description, and so on.

Products will be marked as drafts that you can preview and tweak until you're ready to go.

Once published, you'll be able to see your Starter Kit on the Marketplace and within the Starter Kits area of the Statamic Control Panel.


## Installing from a Local Repo

To test install your Starter Kit from your local exported repo, you can add the repo's local path to your global Composer `config.json` file as a repository:

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "/Users/hasselhoff/kung-fury-theme"
        }
    ]
}
```

:::tip
If you are not sure where your `config.json` is located, run `composer config --global home` to see the location of your global Composer config.
:::

With your repo's local path added to your `config.json`, you should now be able to install using the `--local` cli option:

```
statamic new kung-fury-dev the-hoff/kung-fury-theme --local
```


## Maintaining a Starter Kit

When making changes to your Starter Kit, just [re-export](#exporting-files) from your development repo and push your changes from your exported repo.

### Keeping up-to-date with Statamic and Laravel

Rather than maintaining your development repo as new Statamic and Laravel versions are released, you can always install your Starter Kit into a fresh Statamic instance by using the `--with-config` install option.

``` shell
statamic new kung-fury-dev the-hoff/kung-fury-theme --with-config
```

This will install your Starter Kit into a brand new Statamic project, along with your `starter-kit.yaml` config file for future exports.


## Addons vs. Starter Kits

Both addons and Starter Kits can be used to extend the Statamic experience, but they have different strengths and use cases:

### Addons

- Addons are installed via `composer`, like any PHP package
- Addons live within your app's `vendor` folder after they are installed
- Addons can be updated over time
- Addon licenses are tied to your site

:::tip
An example use case is a custom fieldtype maintained by a third party vendor. Though you would install and use the addon within your app, you would still rely on the vendor to maintain and update the addon over time.
:::

### Starters Kits

- Starter kits are installed via `php please starter-kit:install`
- Starter kits install pre-configured files and settings into your site
- Starter kits do not live as updatable packages within your apps
- Starter kit licenses are not tied to a specific site, and expire after a successful install

:::tip
An example use case is a frontend theme with sample content. This is the kind of thing you would install into your app once and modify to fit your own style. You would essentially own and maintain the installed files yourself.
:::

## Related Reading

- [Starter Kit Overview](/starter-kits)
- [How to Install a Starter Kit](/starter-kits/installing-a-starter-kit)

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


## Optional Modules

You may also present an optional set of starter kit files, nested under `modules` in your `starter-kit.yaml` config file.

For example, here we'll configure an opt-in `seo` module.

```yaml
modules:
  seo:
    dependencies:
      - statamic/seo-pro
```

This presents a choice to the user, to confirm whether or not to install this module.

<figure class="mt-0 mb-8">
    <img src="/img/starter-kit-module-confirmation.png" alt="The user can confirm whether or not to install the `seo` module">
</figure>

These modules are compatible with the same config options that you use at the top level of your config file (ie. `export_paths`, `export_as`, `dependencies`, etc.).

```yaml
modules:
  seo:
    export_paths:
      - resources/css/seo.css
    export_as:
      README.md: README-for-seo.md
    dependencies:
      - statamic/seo-pro
```

### Customizing Prompt Text

If you don't like the default prompt text, you can customize it with custom `prompt` config.

```yaml
modules:
  seo:
    prompt: 'Would you like some awesome SEO with that!?'
    dependencies:
      - statamic/seo-pro
```

<figure class="mt-0 mb-8">
    <img src="/img/starter-kit-module-custom-prompt.png" alt="Starter kit custom prompt text">
    <figcaption>Would you also like fries with that?</figcaption>
</figure>

### Customizing Prompt Default Value

Setting `default: true` will ensure the module is installed by default if the user spams the enter key through the prompt, or the Starter Kit is installed non-interactively.

```yaml
modules:
  seo:
    default: true
    dependencies:
      - statamic/seo-pro
```

### Skipping Confirmation

Or maybe you wish to skip the user prompt and always install a given module, using modules to better organize larger Starter Kit configs. To do this, simply set `prompt` to false.

```yaml
modules:
  seo:
    prompt: false
```

### Selecting Between Modules

You may find yourself in a situation where you want the user to select only one of multiple module options. To do this, you may nest multiple module configs under an `options` object.

```yaml
modules:
  js:
    options:
      vue:
        export_paths:
          - resources/js/vue.js
      react:
        export_paths:
          - resources/js/react.js
      mootools:
        export_paths:
          - resources/js/mootools.js
```

<figure class="mt-0 mb-8">
    <img src="/img/starter-kit-select-module.png" alt="Starter kit select module">
</figure>

### Customizing Select Module Prompt Text

Of course, you can also customize `prompt` text, the first 'No' `skip_option` text, as well as each option `label`, as you see fit.

```yaml
modules:
  js:
    prompt: 'Would you care for some JS?'
    skip_option: 'No, thank you!'
    options:
      vue:
        label: 'VueJS'
        export_paths:
          - resources/js/vue.js
      react:
        label: 'ReactJS'
        export_paths:
          - resources/js/react.js
      mootools:
        label: 'MooTools (will never die!)'
        export_paths:
          - resources/js/mootools.js
```

<figure class="mt-0 mb-8">
    <img src="/img/starter-kit-select-module-customization.png" alt="Customizing starter kit select module">
    <figcaption>🐮🐮🐮</figcaption>
</figure>

### Customizing Select Module Default Value

Setting a `default` value will ensure a specific module option is installed by default if the user spams the enter key through the prompt, or the Starter Kit is installed non-interactively.

```yaml
modules:
  js:
    prompt: 'Would you care for some JS?'
    default: vue
    # ...
```

### Disabling Select Module Skip Option

If you want to force the user to select a module option, you can set `skip_option: false` to disable the 'No' skip option.

```yaml
modules:
  js:
    prompt: 'Would you care for some JS?'
    skip_option: false
    # ...
```

<figure class="mt-0 mb-8">
    <img src="/img/starter-kit-select-module-disable-skip-option.png" alt="Starter kit disable skip option">
</figure>


### Nesting Modules

Finally, you can also nest modules where it makes sense to do so. Simply nest a `modules` object within any module.

```yaml
modules:
  seo:
    prompt: 'Would you like some awesome SEO with that!?'
    dependencies:
      - statamic/seo-pro
    modules:
      sitemap:
        prompt: 'Would you like additional SEO sitemap features as well?'
        dependencies:
          - statamic/seo-pro-sitemap
```

In this example, the second `sitemap` module prompt will only be presented to the user, if they agree to installing the parent `seo` module.


## Post-Install Hooks

You may run additional logic after the starter kit is installed. For example, maybe you want to output some information.

To do so, you can create a `StarterKitPostInstall.php` file in the root of your starter kit. It should be a simple non-namespaced class with a `handle` method. You will be provided with an instance of the command so you can output lines, get input, and so on.

```php
<?php

class StarterKitPostInstall
{
    public function handle($console)
    {
        $console->line('Thanks for installing!');
    }
}
```

:::tip
Statamic will automatically export this file if it exists. You don't need to add it to export_paths.
:::


## Publishing a Starter Kit

Once exported, you will need to update the `name` property in the `composer.json` created at your specified export repo path. It should match your Composer/GitHub {Organization}/{Repo_Name} exactly.

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

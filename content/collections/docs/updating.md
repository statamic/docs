---
title: Updating
id: e6f05019-6bdd-488e-ba45-39ae7ea5cee7
blueprint: page
intro: Updates are handled by [Composer](https://getcomposer.org/), PHP's dependency manager. We recommend running all updates locally (not on production) via the command line.
---

:::best-practice
We recommend running **all updates** locally to eliminate downtime and any possibility of an unexpected change or timeout affecting your site.
:::
## Composer

If you installed with Composer, you can update your installation with the following command:
```
composer update statamic/cms --with-dependencies
```
 Note: You may prefer to run `composer update` to update _all_ of your dependencies.

 ## Statamic CLI

If you installed with [Statamic CLI](/cli), you can update your installation with the following command:
```
statamic update
```

## Control Panel

You can also run updates in the control panel in the **Tools &rarr; Updates** area.

When using the control panel updater, your `statamic/cms`  Composer version dependency will be fixed to whichever explicit version you choose. To go back to a constraint-style version, you'll need to update your `composer.json` file.

For example, if you update to `v3.3.1` in the control panel, this will be your Composer constraint.

```json
{
    "require": {
        "statamic/cms": "3.3.1",
    }
}
```

To go back to a more traditional version range constraint, you may want to replace it with this:

```json
{
    "require": {
        "statamic/cms": "^3.3",
    }
}
```

## Major Upgrades

Upgrading between major Statamic versions sometimes involves extra manual steps. Check out these guides for further details.

- [3.2 to 3.3](/upgrade-guide/3-2-to-3-3)
- [3.1 to 3.2](/upgrade-guide/3-1-to-3-2)
- [3.0 to 3.1](/upgrade-guide/3-0-to-3-1)
- [2.x to 3.x](/upgrade-guide/v2-to-v3)

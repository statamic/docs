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

The Control Panel will inform you when updates are available.

From within the **Tools &rarr; Updates** section, Statamic will provide you with the appropriate Composer commands to run.

If you choose to install a non-latest version, your `statamic/cms`  Composer version dependency will be fixed to whichever explicit version you choose. To go back to a constraint-style version, you'll need to update your `composer.json` file.

For example, if you chose `v4.0.1` in the control panel, this will be your Composer constraint.

```json
{
    "require": {
        "statamic/cms": "4.0.1",
    }
}
```

To go back to a more traditional version range constraint, you may want to replace it with this:

```json
{
    "require": {
        "statamic/cms": "^4.0",
    }
}
```

## Major upgrades

Upgrading between major Statamic versions sometimes involves extra manual steps. Check out [these guides](/upgrade-guide) for further details.

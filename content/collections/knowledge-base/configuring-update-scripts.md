---
id: 68dcd2ce-f10c-4363-8f8d-3c97d3264dd0
title: 'Configuring update scripts on older installations'
intro: 'Update scripts were introduced for Statamic 3.1. Learn about update scripts and how to configure them on older Statamic installations.'
template: page
categories:
  - development
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1622821009
---
## What are update scripts?

[Update scripts](/extending/addons#update-scripts) are used for automatically updating data when breaking changes are introduced by Statamic or by addons. This feature was introduced for Statamic 3.1, and new installations will have all of this preconfigured out-of-the-box. For older installations, you may need to manually configure update scripts in your app:

### Updating your composer.json

Add this `pre-update-cmd` under the `scripts` section of your `composer.json`:

``` json
"scripts": {
    "pre-update-cmd": [
        "Statamic\\Console\\Composer\\Scripts::preUpdateCmd"
    ],
    ...
}
```

### Running update scripts for the first time

If the above script was not already registered in your composer.json, you'll need to manually trigger update scripts in your app by running:

``` bash
php please updates:run 3.0
```

> This is a one-time thing, and will be automatically triggered by future Statamic updates.

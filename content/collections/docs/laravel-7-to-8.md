---
id: ec130472-4f44-4e7e-8dce-71d0c93e8fef
blueprint: page
title: 'Upgrade from Laravel 7 to 8'
intro: 'A guide for upgrading from Laravel 7 to 8'
template: page
---
A Statamic website is technically a Laravel website with Statamic installed into it.

Typically when you upgrade Statamic, you're _just_ upgrading Statamic. We don't automatically the Laravel side of things.

Certain versions of Statamic require newer versions of Laravel, and you may be forced to upgrade. It's a good idea to keep updated with Laravel anyway.

:::warning Disclaimer
**This guide is intended for "stock" Statamic sites.**

That is, a site where you installed Statamic and haven't really added any custom Laravel functionality. You may not have cared or even known that your site uses Laravel.

If you've added custom functionality, you can still follow this guide, but you should be aware of anything custom you may have added, and be careful not to remove it.
:::

:::warning Another Disclaimer
You should be performing your updates **locally**. Never update directly on production.
:::

1. Make sure you're using Git. You'll want to be able to roll back safely if you make a mistake. You can upgrade without Git, but you will need to be more careful.

1. Make sure all your Composer dependencies are up to date by running `composer update`.
   ```bash
   composer update
   ```

1. Do a `git commit` so you are working with a clean slate.
   ```bash
   git commit -am "Updated Composer dependencies"
   ```

1. Download a zip of a fresh `statamic/statamic` site.
   Head to the [3.2.7 GitHub release](https://github.com/statamic/statamic/releases/tag/v3.2.7), download `Source code (zip)`, and unzip it somewhere on your computer.

1. Delete (or move to trash) all the files and folders of your project _except for_ `composer.lock`, `content`, `public`, `resources`, `tests`, and `users`.

1. Copy all the files and folders _except for_ `content`, `public`, `resources`, `tests`, and `users` from the zip into your project.

1. Look through the Git changes to see if anything was removed that shouldn't have been.

   For example:
   - anything custom you may have added to the `app` directory
   - configuration values you may have changed in the `config` directory
   - additional dependencies in `composer.json`

1. Update your dependencies again now that you have an updated `composer.json`.
   ```bash
   composer update
   ```

1. Give your site a thorough test.

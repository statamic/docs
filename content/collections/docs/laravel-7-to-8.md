---
id: ec130472-4f44-4e7e-8dce-71d0c93e8fef
blueprint: page
title: 'Upgrade from Laravel 7 to 8'
intro: 'A quick guide for upgrading from Laravel 7 to 8.'
template: page
---
On a fundamental level, a Statamic website is a Laravel application with Statamic installed into it. When you upgrade Statamic, you're _just_ upgrading Statamic — Laravel is not automatically upgraded at the same time.

Major Statamic releases may require newer versions of Laravel, which result in the need to upgrade the Laravel site of the application. There are many benefits to staying up to date with the latest versions of Laravel — security, performance, and compatibility with a wider range of Composer packages to name a few.

:::warning Disclaimer
**This guide is intended for "stock" Statamic sites.**

That is, a site where you installed Statamic and haven't added or customized functionality on the Laravel side of the application (typically the `/app/` directory).

If you've added custom functionality, this guide will still be helpful, just be mindful of anything you may have added or modified and be sure to account for it.
:::

:::warning Another Disclaimer
You should be performing your updates **locally**. Never update directly on production.
:::

1. First your application should be version controlled with Git. These steps assume you'll be able to look at a git diff to make sure you don't remove important changes, dependencies, or routes.

1. Make sure all Composer dependencies are up to date by running `composer update`.
   ```bash
   composer update
   ```

1. Run a `git commit` to start a clean slate.
   ```bash
   git commit -am "Updated Composer dependencies"
   ```

1. Download a zip of a fresh `statamic/statamic` site.
   Head to the [3.2.7 GitHub release](https://github.com/statamic/statamic/releases/tag/v3.2.7), download `Source code (zip)`, and unzip it somewhere on your computer.

1. Delete (or move to trash) `app`, `bootstrap`, `config`, `routes`, `composer.json`, and `artisan`.

1. Copy `app`, `bootstrap`, `config`, `routes`, `composer.json`, and `artisan` from the zip into your project.

1. Look through the Git changes to see if anything was removed that shouldn't have been. For example:

   - anything custom you may have added to the `app` directory
   - configuration values you may have changed in the `config` directory
   - additional dependencies in `composer.json`
   - custom routes you may have configured in `routes/*`

1. Update your dependencies again now that you have an updated `composer.json`.
   ```bash
   composer update
   ```

1. Give your site a thorough test. For most sites, that'll do it!

If your site is more complex or is part of a larger Laravel Application, you can follow the [Laravel Upgrade guide](https://laravel.com/docs/8.x/upgrade) or use [Laravel Shift](https://laravelshift.com) to automate the upgrade for you.
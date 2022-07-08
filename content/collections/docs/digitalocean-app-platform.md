---
id: 4b468a3a-08c2-4114-9daa-47cf99125d27
blueprint: page
title: 'Deploying Statamic to DigitalOcean App Platform'
parent: c4f17d05-78bd-41bf-8e06-8dd52f6ec154
intro: 'DigitalOcean''s [App Platform](https://www.digitalocean.com/products/app-platform) allows you to deploy and scale apps without having to manage servers. You''re billed per-project, depending on the resources you need.'
---
## Overview

The best part of the serverless approach is that your site's resources and can scale up and down on demand, which can save you money and provide your users a better experience in the long run.

## Prepare your dependencies

App Platform uses [`heroku-php-apache2`](https://devcenter.heroku.com/articles/php-support) to run PHP applications. The default modules don't quite cover everything you might need while using Statamic, so we'll need to tell DigitalOcean to install them.

Add the following dependencies to your `composer.json` file's `require` block.

```json
{
    "require": {
        "ext-bcmath": "*",
        "ext-exif": "*",
        "ext-gd": "*",
        "ext-mbstring": "*",
    }
}
```

Be sure to commit those changes to your repo before you continue, or you'll have to traverse a painful platform-level cache clearing adventure later on.

:::tip
Learn more about [customizing your PHP extensions](https://devcenter.heroku.com/articles/php-support#extensions) with Heroku PHP Apache2.
:::

## Creating a New App

Assuming you have a [DigitalOcean](https://m.do.co/c/6469827e2269) account, let's get started by logging in. The first thing to do is to create a new application by going to **Apps** and clicking **Create App**.

<figure>
    <img src="/img/deploying/digital-ocean-app-platform/new-app-button.png" alt="Creating a new site with Digital Ocean's App Platform">
</figure>

Next, you'll need to connect your Github (or other Source Code provider) account and authorize DigitalOcean access to the desired repo or repos.

<figure>
    <img src="/img/deploying/digital-ocean-app-platform/creating-new-app.png" alt="Creating a new site with Digital Ocean's App Platform">
</figure>

Click on **Manage Access** and follow the steps to authorize the proper organization and repository.

<figure>
    <img src="/img/deploying/digital-ocean-app-platform/authorize-github.png" alt="Authorizing Github">
</figure>

Next, specify which branch you wish to deploy. This is usually `main` or `master`. If you want updates to this branch to be autodeployed, check the corresponding box.

<figure>
    <img src="/img/deploying/digital-ocean-app-platform/repo-and-branch.png" alt="Authorizing Github">
</figure>

## Edit Your Plan

Next, you'll want to edit your plan to make sure you're configuring the right resources and not over-paying for power you don't need. Click **Edit Plan**.

<figure>
    <img src="/img/deploying/digital-ocean-app-platform/resources.png" alt="App Resources">
</figure>

You'll need to be on **Pro** to run Statamic as an application (Static sites are free) and choose the appropriate size and number containers. For a new site without any high traffic needs the basic $12/mo size and a single container should do just fine.

<figure>
    <img src="/img/deploying/digital-ocean-app-platform/edit-plan.png" alt="Authorizing Github">
</figure>

## Environment

Click **Back**, then **Next** and let's set up your environment variables. Click **Edit** next to your repo and add `APP_KEY` and either generate a new key with `php artisan key:generate` or paste in the app key from your dev site.

<figure>
    <img src="/img/deploying/digital-ocean-app-platform/env-vars.png" alt="Authorizing Github">
</figure>

Click **Save** and then **Next**.

## Name your app and choose your Region

Here's where you can choose a better name than the randomly generated one (might we suggest `forbidden-crt-dreams`?). Then choose the most appropriate region for your audience in the next screen, and click **Next**.

<figure>
    <img src="/img/deploying/digital-ocean-app-platform/info-region.png" alt="Authorizing Github">
</figure>

## The Finish Line

The last screen will show you a review of everything you've configured. If you're happy with it, click **Create Resources**.

Congrats, that's it! You should now see your app's management screen where your first deploy is in progress. If everything goes smoothly, you should be able to see your site on the private URL DigitalOcean provides you (it would be something like `your-product-32rbu.ondigitalocean.com`).

## Customizing Your Build Script

You'll probably want to update your build script to add a `composer install` , cache clear, and any other front-end commands.

Navigate to the Settings tab of your application and add your commands to the Build Command field.

<figure>
    <img src="/img/deploying/digital-ocean-app-platform/build-command.png" alt="Authorizing Github">
</figure>

## Wrap-up

That should get you going! There's much more to learn and configure though, so be sure to check out the  [App Platform How-Tos](https://docs.digitalocean.com/products/app-platform/how-to/) section of the DigitalOcean docs!

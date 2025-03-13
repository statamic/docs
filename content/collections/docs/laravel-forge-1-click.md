---
id: 48c60d99-04e7-47f6-9576-aee1401fcb50
blueprint: page
title: 'How to Install Statamic on Laravel Forge'
nav_title: 'Laravel Forge'
intro: "A full tutorial on how to install Statamic with Forge's 1-Click Installer. For this walk-through, we'll assume you have a [Forge](https://forge.laravel.com) account with a server provisioned."
parent: ab08f409-8bbe-4ede-b421-d05777d292f7
---

The Laravel team have made this an exceedingly simple process. Follow these 3 steps, and you'll have a Statamic site running that you can log right into.

:::tip
If you _already have_ a Statamic site built, you should switch over to the [Deploying Statamic on Laravel Forge](/deploying/laravel-forge) guide.
:::


### 1. Create a new site

Set your domain name, use PHP/Laravel/Symfony as the project type.

<figure>
    <img src="/img/installing-forge-new-site.png" alt="Make a new site with Laravel Forge">
</figure>

### 2. Pick Statamic

Don't pick those other options. You want Statamic.

<figure>
    <img src="/img/installing-forge-pick-statamic.png" alt="Pick Statamic">
</figure>

### 3. Pick a Starter Kit

Now you can pick which Starter Kit you'd like to use. This Forge workflow only works with free/open source Starter Kits, so if you'd prefer one of the paid/commercial kits, you'll need to follow the [local install](/installing/laravel-herd) and [Deploy on Laravel Forge](/deploying/laravel-forge) guides.

Set your email address and super user password, and you're good to go.

<figure>
    <img src="/img/installing-pick-kit.png" alt="Pick your starter kit">
</figure>

### 4. Sign into your new Statamic site

Assuming you've pointed your DNS to this server, all that's left is to head to `yourdomain.com/cp` and sign into the Statamic control panel. The site is yours.

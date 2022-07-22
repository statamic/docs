---
id: cf38dba4-5cce-4b81-a2f5-e82665e4e11f
blueprint: page
title: 'Deploying Statamic with Ploi'
intro: |-
  Ploi provisions and deploys PHP applications on DigitalOcean,
  Linode, Vultr, Amazon, Hetzner and other hosting platforms. It's a piece of cake to deploy Statamic with it.
parent: c4f17d05-78bd-41bf-8e06-8dd52f6ec154
---
Assuming you have a [Ploi](https://ploi.io) account, the first thing to do is authorize your hosting provider of choice. In this walk-through we'll use [Hetzner](https://www.hetzner.com) as the example. This is a one-time step and will allow you to easily spin up and provision new server stacks anytime.

<figure>
    <img src="/img/deployment-ploi-hosting-setup.jpg" alt="Deployment hosting setup example">
</figure>

You will need to also authorize Github (or your preferred source control provider). This is another one-time process that allows you to quickly deploy new sites from this account.

<figure>
    <img src="/img/deployment-forge-source-control-setup.png" alt="Deployment source control setup example">
</figure>

## Spinning Up a New Server

Once you have connected to your hosting provider, the next step is to spin up a new server. Laravel Forge automatically tailors the server stack for Statamic and Laravel, so you only need to choose the server size most suitable for your project and you'll be billed accordingly by Digital Ocean.

<figure>
    <img src="/img/deployment-ploi-create-server.jpg" alt="Create server example">
</figure>

## Creating a New Site

The next step is to create a new site. This will scaffold out the directory structure and nginx config on the server, and further allow you to configure your site's environment variables, deployments, and so on.

<figure>
    <img src="/img/deployment-ploi-create-site.jpg" alt="Create site example">
</figure>

## Configuring Deployment

Finally, setup your deployment by pointing to your site to your source control repository. Laravel Forge will create a sensible deployment script for you for one-click deployments.

<figure>
    <img src="/img/deployment-forge-install-repo.png" alt="Install repo example">
</figure>

After doing this, you'll be able to customize the deployment script if needed. You can also enable "**quick deploy**", which will automatically trigger deployments when you push changes to your chosen branch.

<figure>
    <img src="/img/deployment-forge-script-example.png" alt="Deployment script example">
</figure>

The Deploy Script area is where you'd add commands to install Composer and NPM dependencies, compile CSS and JavaScript if you need to, and clear Statamic's cache. Most deploy scripts look like something like this:

``` shell
cd /home/forge/{example}.{tld}
git pull origin main
php please cache:clear
npm ci && npm run production
```

## Statamic specific features

Ploi offers some helpful features right from the dashboard that let you interact with your Statamic installtion without the need to log in to your server via ssh. This includes things like clearing the static cache or warming the stache.

## Advanced Control

Laravel Forge also offers advanced control of queue workers, cron jobs, SSL certificates, database access, etc.

<figure>
    <img src="/img/deployment-forge-advanced.png" alt="Advanced Laravel Forge features">
    <figcaption>Forge does a lot. It's worth it.</figcaption>
</figure>

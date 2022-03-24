---
title: 'Deploying'
intro: Statamic is a modern PHP application, built as a [Laravel](https://laravel.com) package, and is deployed like any standard Laravel application. Here are a few common deployment solutions.
template: page
blueprint: page
id: c4f17d05-78bd-41bf-8e06-8dd52f6ec154
---
## Overview

Deployments are the process of moving the Statamic site you've built — whether on your local computer or distributed across a team — to the production (aka "live") server for the whole world (wide web) to see.

At its most simple level, it's just the act moving files from your computer to another computer — the web server. There are many ways to do it, from a slow and painfully manual FTP upload (please don't), to a lightning quick git push with auto-deployment.

The deployment options available to you will depend on the type of hosting scenario you're using. Let's talk about servers first.

## Common Deployment Solutions

There are several popular ways to host and deploy a Statamic application to production, depending on your needs and expertise. Common solutions include:

### Managed VPS

**We recommend VPS hosting as the best all around solution for Statamic deployments.** A VPS gives you the ability to manage your own server instance, allowing for full SSH access and scalability, without the security risks of other customers on the same server doing Lord knows what (as with shared).

- [Digital Ocean](https://m.do.co/c/6469827e2269)
- [Linode](https://linode.gvw92c.net/statamic)
- [Vultr](https://www.vultr.com/)

We highly recommend combining VPS with a server management service to help you provision and configure your server. These services also help to make Statamic deployment _extremely easy_ using common Git push-to-deploy strategies. Yes, they cost a little extra, but they're worth every penny, Euro, rupee, or doubloon.

- [Laravel Forge](https://forge.laravel.com/)
- [Ploi.io](https://ploi.io/)
- [ServerPilot](https://serverpilot.io/)

### Jamstack

The [Jamstack](https://jamstack.org/) architecture has become quite popular in recent years. Hosting options are fairly cheap (or free), and static sites make for great performance and security. This can be a great option for small landing pages, blogs, and even for larger sites that don't depend heavily on dynamic or interactive server-side features.

- [Netlify](https://www.netlify.com/)
- [Vercel](https://vercel.com/)

Also check out our static site generator addon, which makes generating a static version of your Statamic site easy.

- [Statamic SSG](https://github.com/statamic/ssg)

Note that when hosting a static site, you lose the ability to login to the Control Panel in production, send mail from a traditional contact form, etc. That said, you can still author your content locally or setup a separate content authoring environment (often called a "staging server") for your clients. Mail forms can also be configured to post to third party mail services.

### Shared Hosting

Shared hosting providers often offer the cheapest rates, but the least flexibility and worst security. This is probably the least ideal option for Statamic, and your mileage may vary, though still very possible if its your only option.

For more info on shared web hosts that play well with Statamic, check out our [user notes](https://github.com/statamic/hosts).


## Getting Started

The general workflow for working with a managed VPS solution is pretty easy once you are setup. The first step is to choose the right services. We often recommend pairing [Digital Ocean](https://m.do.co/c/6469827e2269) with [Laravel Forge](https://forge.laravel.com/), though all of the options listed above are great! Understanding what these services do is important.

:::tip
If you are more interested in a Jamstack deployment, check out our [SSG package](https://github.com/statamic/ssg) for details on how to get started!
:::

### The Hosting Service

This is the company that actually hosts your site files. You pay them for your server instance, and they give you raw SSH access to setup your server stack. Many VPS hosting services also offer one-click installs of common stacks.

That said, you have to get your hands a bit dirty on the command line if you choose to configure and deploy to VPS without external help. That's where server management services come in...

### The Server Management Service

Imaging hiring a devops guru to do all the hard stuff for you, and all they ask is for you to buy them lunch once a month. Not a bad deal, right?

Subscribing to one of these services gives you access to a nice GUI for managing your VPS server instances. They simplify server stack setup, help you configure your environment, and make deployment extremely easy. They will also help you spin up new server instances, so you never really have to login to your hosting service except to manage billing.

## First Time Setup

The first thing you will need to do is authorize the server management service (ie. Laravel Forge) to connect to your hosting provider (ie. Digital Ocean). This is a one-time thing, and will allow you to easily spin up and provision new server stacks.

:::tip
We're going to assume you're using [Digital Ocean](https://m.do.co/c/6469827e2269), [Laravel Forge](https://forge.laravel.com), and [Github](https://github.com), for this walk-through.
:::

<figure>
    <img src="/img/deployment-hosting-setup.png" alt="Deployment hosting setup example">
</figure>

You will need to also authorize integration with your source control provider (ie. Github). Again, this is a one-time thing, and will allow you to quickly deploy new sites from this account.

<figure>
    <img src="/img/deployment-source-control-setup.png" alt="Deployment source control setup example">
</figure>

## Spinning Up a New Server

Once you have connected to your hosting provider, the next step is to spin up a new server. Laravel Forge automatically tailors the server stack for Statamic and Laravel, so you mainly need to choose the server size most suitable for your site, and will be billed accordingly by your hosting provider.

<figure>
    <img src="/img/deployment-create-server.png" alt="Create server example">
</figure>

## Creating a New Site

The next step is to create a new site. This will scaffold out the directory structure and nginx config on the server, and further allow you to configure your site's environment variables, deployments, and so on.

<figure>
    <img src="/img/deployment-create-site.png" alt="Create site example">
</figure>

## Configuring Deployment

Finally, setup your deployment by pointing to your site to your source control repository. Laravel Forge will create a sensible deployment script for you for one-click deployments.

<figure>
    <img src="/img/deployment-install-repo.png" alt="Install repo example">
</figure>

After doing this, you'll be able to customize the deployment script if needed. You can also enable 'quick deploy', which will automatically trigger deployments when you push changes to your chosen branch.

<figure>
    <img src="/img/deployment-script-example.png" alt="Deployment script example">
</figure>

The Deploy Script area is where you'd add commands to install Composer and NPM dependencies, compile CSS and JavaScript if you need to, and clear Statamic's cache. Most deploy scripts look like something like this:

``` shell
cd /home/forge/{example}.{tld}
git pull origin main
npm ci && npm run production
php please cache:clear
```

## Advanced Control

Services like Laravel Forge also offer advanced control of queue workers, cron jobs, SSL certificates, database access, etc.

<figure>
    <img src="/img/deployment-forge-advanced.png" alt="Advanced Laravel Forge features">
</figure>

## Deployment Workflow

Given a properly configured Laravel Forge (or similar) solution, your typical deployment workflow would look like this:

### As a solo developer

1. Make your changes locally
2. Git commit changes and push to `main`
3. Changes are automatically deployed to your server

### As a dev team

1. Make your changes locally
2. Git commit changes and push to a feature or bug branch (e.g. `feature/new-contact-form`)
3. Open a Pull Request to your `main` branch
4. Have a team member review the Pull Request and either request changes or approve
5. Merge branch to `main`
6. Changes are automatically deployed to your server

### Using a shared host

1. FTP all your files to the server
2. That's it — but it's error prone, will probably take a long time, and your site will probably be broken for a while.

## Additional Reading

- [Deploying Laravel to Digital Ocean](https://scotch.io/tutorials/deploying-laravel-to-digitalocean) – If you want to skip the server management portion, you can follow this guide and configure your own server. Just skip the MySQL part, you're not gonna need it.

- [Deploying Websites With a Tiny Git Hook](http://ryanflorence.com/deploying-websites-with-a-tiny-git-hook/) — Got a server already set up and just need to hook up the git part? This article will get you there. Yes, it's from 2010, but this is a tried and true approach.

- [Gitflow Workflow](https://www.atlassian.com/git/tutorials/comparing-workflows/gitflow-workflow) – When working with a team (and even when by yourself) it's a good practices to follow a standardized workflow for working with git. We recommend Gitflow.

- [Statamic Docker Containers](/installing/docker) – Want to use Docker container?

- [Zero Downtime Deployment Tips](/tips/zero-downtime-deployments#understanding-zero-downtime-deployment-file-structure) - If you play on using a zero downtime deployment tool like [Envoyer](https://envoyer.io/), [Deployer](https://deployer.org/), etc. be sure to read our tips & tricks guide.

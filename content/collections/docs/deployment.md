---
title: 'Deployment'
intro: Statamic is a modern PHP application, built as a [Laravel](https://laravel.com) package, and is deployed like any standard Laravel application. Here are a few common deployment solutions.
template: page
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1568748406
blueprint: page
id: c4f17d05-78bd-41bf-8e06-8dd52f6ec154
---
## Solutions Overview

There are several ways to host and deploy a Statamic application to production, depending on your needs and expertise. Common solutions include:

### Managed VPS

We recommend VPS hosting as the best all around solution for Statamic deployments. VPS gives you the ability to manage your own server instance, allowing for full SSH access and scalability should you need the extra horsepower.

- [Digital Ocean](https://m.do.co/c/6469827e2269)
- [Linode](https://www.linode.com/)
- [Vultr](https://www.vultr.com/)

We highly recommend combining VPS with a server management service to help you provision and configure your server. These services also help to make Statamic deployment extremely easy using common Git push-to-deploy strategies.

- [Laravel Forge](https://forge.laravel.com/)
- [Ploi.io](https://ploi.io/)
- [ServerPilot](https://serverpilot.io/)

### Jamstack

The [Jamstack](https://jamstack.org/) architecture has become quite popular in recent years. Hosting options are fairly cheap, and static sites make for great performance and security. This can be a great option for small landing pages, blogs, and for larger sites that require extreme scalability.

- [Netlify](https://www.netlify.com/)
- [Vercel](https://vercel.com/)

Also check out our static site generator addon, which makes exporting a static version of your Statamic site easy.

- [Statamic SSG](https://github.com/statamic/ssg)

Note that when hosting a static site, you lose the ability to login to the CP in production, send mail from a traditional contact form, etc. That said, you can still author your content locally or setup a separate content authoring environment for your clients. Mail forms can also be configured to post to third party mail services.

### Shared Hosting

Shared hosting providers often offer cheaper rates, but the least flexibility when it comes to managing your server stack. This is probably the least ideal option for Statamic, and your mileage may vary.

For more info on shared web hosts that play well with Statamic, check out our [user notes](https://github.com/statamic/hosts).


## Getting Started

The general workflow for working with a managed VPS solution is pretty easy once you are setup. The first step is to choose the right services. We often recommend pairing [Digital Ocean](https://m.do.co/c/6469827e2269) with [Laravel Forge](https://forge.laravel.com/), though all of the options listed above are great! Understanding what these services do is important.

> If you are more interested in a Jamstack deployment, check out our [SSG package](https://github.com/statamic/ssg) for details on how to get started!

### The Hosting Service

This is the company that actually hosts your site files. You pay them for your server instance, and they give you raw SSH access to setup your server stack. Many VPS hosting services also offer one-click installs of common stacks.

That said, you have to get your hands a bit dirty on the command line if you choose to configure and deploy to VPS without external help. That's where server management services come in...

### The Server Management Service

Imaging hiring a devops guru to do all the hard stuff for you, and all they ask is for you to buy them lunch once a month. Not a bad deal, right?

Subscribing to one of these services gives you access to a nice GUI for managing your VPS server instances. They simplify server stack setup, help you configure your environment, and make deployment extremely easy. They will also help you spin up new server instances, so you never really have to login to your hosting service except to manage billing.

## First Time Setup

The first thing you will need to do is authorize the server management service (ie. Laravel Forge) to connect to your hosting provider (ie. Digital Ocean). This is a one-time thing, and will allow you to easily spin up and provision new server stacks.

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

The next step is to create a new site. This will scaffold out the directory structure and nginx config on the server, and further allow you to configure your site's environment variables, configure deployments, etc.

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

## Advanced Control

Services like Laravel Forge also offer advanced control of queue workers, cron jobs, SSL certificates, database access, etc.

<figure>
    <img src="/img/deployment-script-example.png" alt="Deployment script example">
</figure>

---
id: 8fd95af9-f635-45bb-a3d1-1fa1db7be4a2
blueprint: page
title: 'Deploying Statamic with Laravel Forge'
intro: |-
  Laravel Forge provisions and deploys PHP applications on DigitalOcean,
  Linode, Vultr, Amazon, Hetzner and other hosting platforms. It's our favorite way to deploy Statamic.
parent: c4f17d05-78bd-41bf-8e06-8dd52f6ec154
---
Assuming you have a [Forge](https://forge.laravel.com) account, the first thing to do is authorize your hosting provider of choice. In this walk-through we'll use our preferred host, [Digital Ocean](https://m.do.co/c/6469827e2269) as the example. This is a one-time step and will allow you to easily spin up and provision new server stacks anytime.

<figure>
    <img src="/img/deployment-forge-hosting-setup.png" alt="Deployment hosting setup example">
</figure>

You will need to also authorize Github (or your preferred source control provider). This is another one-time process that allows you to quickly deploy new sites from this account.

<figure>
    <img src="/img/deployment-forge-source-control-setup.png" alt="Deployment source control setup example">
</figure>

## Spinning Up a New Server

Once you have connected to your hosting provider, the next step is to spin up a new server. Laravel Forge automatically tailors the server stack for Statamic and Laravel, so you only need to choose the server size most suitable for your project and you'll be billed accordingly by Digital Ocean.

<figure>
    <img src="/img/deployment-forge-create-server.png" alt="Create server example">
</figure>

## Creating a New Site

The next step is to create a new site. This will scaffold out the directory structure and nginx config on the server, and further allow you to configure your site's environment variables, deployments, and so on.

<figure>
    <img src="/img/deployment-forge-create-site.png" alt="Create site example">
</figure>

## Configuring Deployment

Finally, set up your deployment by pointing to your site to your source control repository. Laravel Forge will create a sensible deployment script for you for one-click deployments.

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
git pull origin $FORGE_SITE_BRANCH

$FORGE_COMPOSER install --no-dev --no-interaction --prefer-dist --optimize-autoloader

( flock -w 10 9 || exit 1
    echo 'Reloading PHP FPM...'; sudo -S service $FORGE_PHP_FPM reload ) 9>/tmp/fpmlock

php please cache:clear
npm ci && npm run production
```

Unless you're using the [Eloquent Driver](https://github.com/statamic/eloquent-driver), you may want to comment out the `$FORGE_PHP artisan migrate --force` command from your deployment script.

If you're planning on using the Git integration, you may want to prevent content changes from the Control Panel from triggering "full" deployments in Laravel Forge. Learn more about this on the [Git Automation](/git-automation#customizing-commits) page.

## Advanced Control

Laravel Forge also offers advanced control of queue workers, cron jobs, SSL certificates, database access, etc.

<figure>
    <img src="/img/deployment-forge-advanced.png" alt="Advanced Laravel Forge features">
    <figcaption>Forge does a lot. It's worth it.</figcaption>
</figure>

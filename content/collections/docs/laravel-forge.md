---
id: 8fd95af9-f635-45bb-a3d1-1fa1db7be4a2
blueprint: page
title: 'Deploying Statamic with Laravel Forge'
intro: Laravel Forge provisions and deploys PHP applications on DigitalOcean, Vultr, Akamai, AWS Hetzner and other hosting platforms. It's our favorite way to deploy Statamic.
parent: c4f17d05-78bd-41bf-8e06-8dd52f6ec154
---

Assuming you already have a [Laravel Forge](https://forge.laravel.com) account, the first thing to do is create a server.

## Creating a New Server

<figure>
    <img src="/img/deploying/forge/create-server-01.png" alt="Create new server">
</figure>

You can host your site on Laravel VPS (which is billed on top of your Forge subscription), [DigitalOcean](https://m.do.co/c/6469827e2269), AWS, Hetzner, or even your own fresh Ubuntu server.

<figure>
    <img src="/img/deploying/forge/create-server-02.png" alt="Configure new server">
</figure>

On the next size, you'll be asked to configure your server. 

For most Statamic sites, you'll want to leave the type as "App server". You should pick the region closest to your users and select a server size suitable for your project.

Once you've created your server, Forge will give you your server's sudo and database passwords. Keep these safe as you won't be able to retrieve them later.

## Creating a New Site

The next step is to create a new site. Make sure to select "Statamic" from the "New site" dropdown to take advantage of some Statamic-specific optimizations.

<figure>
    <img src="/img/deploying/forge/create-site.png" alt="Create site page">
</figure>

Select your Git repository, the branch you want to deploy, and configure a domain. If you don't have a domain yet, you can use a `.on-forge.com` subdomain.

:::tip Note
Zero downtime deployments are disabled by default for Statamic sites, due to the additional configuration required.

Before enabling, please review our [Zero Downtime Deployments](/tips/zero-downtime-deployments) guide.
:::

## Deploying

After creating your site, Forge will take a few seconds to configure the necessary services, like Nginx and PHP-FPM, then you'll be able to trigger your first deploy.

<figure>
    <img src="/img/deploying/forge/deployment.png" alt="Deployment logs">
</figure>

## Configuring Deployments

You can customize your deployment script under `Settings -> Deployments`. Your deploy script will look something like this:

```shell
cd /home/forge/forge-demo-znqnhr0d.on-forge.com

git pull origin $FORGE_SITE_BRANCH
$FORGE_COMPOSER install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Prevent concurrent php-fpm reloads...
touch /tmp/fpmlock 2>/dev/null || true
( flock -w 10 9 || exit 1
  echo 'Reloading PHP FPM...'; sudo -S service $FORGE_PHP_FPM reload ) 9</tmp/fpmlock

npm ci && npm run build

if [ -f artisan ]; then
    $FORGE_PHP artisan optimize
    $FORGE_PHP please stache:warm
    $FORGE_PHP please search:update --all
    # $FORGE_PHP please static:clear
    # $FORGE_PHP please static:warm --queue
fi
```

If you're using [Static Caching](/static-caching), you may want to uncomment the `static:clear` and `static:warm` commands.

If you're using the [Git Automation](/git-automation), you may want to [add this snippet](https://statamic.dev/git-automation#customizing-commits) to the very top of your deploy script to prevent Control Panel content changes triggering full deployments.

If you're using the [Eloquent Driver](https://github.com/statamic/eloquent-driver), you may want to comment out the `$FORGE_PHP please stache:warm` command and replace it with `$FORGE_PHP please cache:clear`.

If you want code changes to be deployed automatically when pushing to the site's branch, enable **push to deploy**.

## Configuring your environment

Under `Settings -> Environment`, you may configure your site's environment variables. You'll find Statamic's variables near the bottom, prefixed with `STATAMIC_`.

<figure>
    <img src="/img/deploying/forge/environment.png" alt=".env editor">
</figure>
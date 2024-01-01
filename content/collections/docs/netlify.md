---
id: 7f809a5e-e555-4ccc-8488-d7310ff8c89c
blueprint: page
title: 'Deploying Statamic to Netlify'
intro: |-
  Netlify is a Jamstack service and cloud provider that lets you deploy your Statamic site statically with blazing fast performance using its Edge CDN.
parent: c4f17d05-78bd-41bf-8e06-8dd52f6ec154
---
:::warning
Please note that by hosting your site statically with a service like Netlify or Vercel, **you can't access the Control Panel in production** and are **not able to use dynamic features** like Statamic's built-in forms or random sorting in your templates.
:::

Deployments are triggered by committing changes to your Git repository. Alternatively, you can also upload the locally generated files from Netlify's dashboard via drag and drop.

## Prerequisites

:::tip
Netlify **only supports PHP <=8.1** and defaults to PHP 8.0. You can [specify the PHP version](https://docs.netlify.com/configure-builds/manage-dependencies/#php) using the `PHP_VERSION` environment variable.
:::

- A [Netlify](https://netlify.com) account
- An account with one of Netlify's supported Git providers
- Have the `statamic/ssg` package installed and set up in your project
- Make sure you don't need or use any dynamic features, like forms or random sorting.
- To make things easier, add a new script to your project's `composer.json` file with the following commands:
```json
"scripts": {
    "build": [
        "npm run production",
        "@php -r \"file_exists('.env') || copy('.env.example', '.env');\"",
        "@php artisan key:generate",
        "@php please ssg:generate"
    ],
    // ...
}
```

Feel free to customize this to fit your needs. Netlify automatically installs npm and composer dependencies. So there is no need to manually run `npm ci` or `composer install`.

## Creating a New Site

To get started add a new site to your account. In this walk-through we'll assume you already have an existing project that you want to import since it's the most common use-case.

<figure>
    <img src="/img/deployment-netlify-import-project.jpg" alt="Netlify dashboard to import a project">
</figure>

Next, you will need to authorize Github (or another supported source control provider). This is a one-time process that allows you to quickly deploy new sites from this account.

<figure>
    <img src="/img/deployment-netlify-connect-git.jpg" alt="Choose a Git provider for your project">
</figure>

After you connected to your Git provider, pick the repo of the project you want to deploy to Netlify. So choose wisely 🧙‍♂️

<figure>
    <img src="/img/deployment-netlify-pick-repo.jpg" alt="Pick a repository from your chosen Git provider">
</figure>

The next step is to configure your site's settings and deployment configuration.

1. Choose the branch you want to deploy from. This could be the `main` branch or something like `production`, depending on your [Git workflow](/deploying/workflow).
2. Leave the base directory input empty, unless your Statamic project is part of a monorepo or lives in a subfolder.
3. Use `composer build` for the build command if you set up your `composer.json` like mentioned [above](#prerequisites).
    - Otherwise just use `php please ssg:generate`
4. Set the publish directory to `storage/app/static`

Instead of doing all of this manually, you can also use a `netlify.toml` file at the base of your project. Netlify automatically detects the file and sets everything up for you. Feel free to use [this one](https://gist.github.com/joshuablum/845d6af82c710a9b9d8f1a57618f213d) as a reference or starting point.

[More about file-based configuration in Netlify's docs](https://docs.netlify.com/configure-builds/file-based-configuration/).

<figure>
    <img src="/img/deployment-netlify-site-settings.jpg" alt="Site and deploy settings for the site">
    <figcaption>Quite some options, don't get lost.</figcaption>
</figure>

That's it! ✅

Depending on how large and complex your project is, the **deployment might take a few seconds or minutes**.

After this is done, you can visit your site via a URL provided by Netlify. It looks similar to this [https://thats-numberwang-47392.netlify.app](https://thats-numberwang-47392.netlify.app).

Be sure to have a look at Netlify's docs on [custom domains](https://docs.netlify.com/domains-https/custom-domains/), [enabling HTTPS](https://docs.netlify.com/domains-https/https-ssl/), and how [Netlify forms](https://docs.netlify.com/forms/setup/) work.

## SSG configuration for Netlify

After you have installed the `statamic/ssg` package, you can publish its configuration with the following command:

```php
php artisan vendor:publish --provider="Statamic\StaticSite\ServiceProvider"
```

This allows you to customize the behaviour of the package.

Let's say you have additional folders and files that you need for your site. Just add them to the copy array:

```php
'copy' => [
    public_path('css') => 'css',
    public_path('js') => 'js',
    public_path('assets') => 'assets',
    public_path('favicon.ico') => 'favicon.ico',
],
```

## Storing Assets in S3

If you are storing your assets in an S3 bucket, the `.env`s used will need to be different to the defaults that come with Laravel, as they are reserved by Netlify. For example, you can amend them to the following:

```sh
# .env
AWS_S3_ACCESS_KEY_ID=
AWS_S3_SECRET_ACCESS_KEY=
AWS_S3_DEFAULT_REGION=
AWS_S3_BUCKET=
AWS_URL=
```

Be sure to also update these in your `s3` disk configuration:

```php
// config/filesystems.php
's3' => [
    'driver' => 's3',
    'key' => env('AWS_S3_ACCESS_KEY_ID'),
    'secret' => env('AWS_S3_SECRET_ACCESS_KEY'),
    'region' => env('AWS_S3_DEFAULT_REGION'),
    'bucket' => env('AWS_S3_BUCKET'),
    'url' => env('AWS_URL'),
],
```

## Using SEO Pro

By default, the SEO Pro addon generates the `sitemap.xml` and `humans.txt` files dynamically and on the fly.

For both files to be part of your generated site, explicitly add their URLs to the array of the `Additional URLs` section in the configuration file:

```php
# config/statamic/ssg.php
'urls' => [
    '/sitemap.xml',
    '/humans.txt',
],
```

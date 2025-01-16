---
id: 01ab4b2b-bee2-4697-b3c6-cb129d783589
blueprint: page
title: 'Deploying Statamic with Vercel'
parent: c4f17d05-78bd-41bf-8e06-8dd52f6ec154
---

:::warning
Please note that by hosting your site statically with a service like Vercel or Netlify, **you can't access the Control Panel in production** and are **not able to use dynamic features** like Statamic's built-in forms or random sorting in your templates.
:::

Deployments are triggered by committing to Git and pushing to GitHub.

- Create a new file `build.sh` file in your project and paste from the [example code snippet](#example-build-script) below
- Run `chmod +x build.sh` on your terminal to make sure the file can be executed when deploying
- Import a new site in your [Vercel](https://vercel.com) account
- Link the site to your desired GitHub repository
- Set build command to `./build.sh`
- Set output directory to `storage/app/static`
- Add `APP_KEY` env variable, by running `php artisan key:generate` locally, and copying from your `.env`
    - ie. `APP_KEY` `your-app-key-value`
- Add `APP_URL` environment variable after your site has a configured domain
    - ie. `APP_URL` `https://thats-numberwang-47392.vercel.app`

#### Example Build Script

Add the following snippet to `build.sh` file to install PHP, Composer, and run the `ssg:generate` command:

```
#!/bin/sh

# Install PHP & WGET
dnf clean metadata
dnf install -y php8.2 php8.2-{common,mbstring,gd,bcmath,xml,fpm,intl,zip}
dnf install -y wget

# INSTALL COMPOSER
EXPECTED_CHECKSUM="$(wget -q -O - https://composer.github.io/installer.sig)"
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
ACTUAL_CHECKSUM="$(php -r "echo hash_file('sha384', 'composer-setup.php');")"

if [ "$EXPECTED_CHECKSUM" != "$ACTUAL_CHECKSUM" ]
then
    >&2 echo 'ERROR: Invalid installer checksum'
    rm composer-setup.php
    exit 1
fi

php composer-setup.php --quiet
rm composer-setup.php

# INSTALL COMPOSER DEPENDENCIES
php composer.phar install

# GENERATE APP KEY
php artisan key:generate

# BUILD STATIC SITE
php please stache:warm -n -q
php please ssg:generate
```

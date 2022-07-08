---
id: 01ab4b2b-bee2-4697-b3c6-cb129d783589
blueprint: page
title: 'Deploying Statamic with Vercel'
parent: c4f17d05-78bd-41bf-8e06-8dd52f6ec154
---
Deployments are triggered by committing to Git and pushing to GitHub.

- Create a new file called `./build.sh` and paste the code snippet below.
- Run `chmod +x build.sh` on your terminal to make sure the file can be executed when deploying.
- Import a new site in your [Vercel](https://vercel.com) account
- Link the site to your desired GitHub repository
- Add build command `./build.sh`
- Set output directory to `storage/app/static`
- Add environment variable in your project settings: `APP_KEY` `<copy & paste from dev>`

#### Code for build.sh
Add the following snippet to `build.sh` file to install PHP, Composer, and run the `ssg:generate` command:

```
#!/bin/sh

# Install PHP & WGET
yum install -y amazon-linux-extras
amazon-linux-extras enable php7.4
yum clean metadata
yum install php php-{common,curl,mbstring,gd,gettext,bcmath,json,xml,fpm,intl,zip,imap}
yum install wget

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
php please ssg:generate
---
id: c0009fa6-0f8f-4b45-8d65-0cb784d07031
blueprint: page
title: 'How to Install Statamic on Ubuntu'
breadcrumb_title: Ubuntu
intro: A full walk-through for installing, configuring and running Statamic on an Ubuntu server, perfect for production use.
parent: ab08f409-8bbe-4ede-b421-d05777d292f7
---
## Prerequisites

To install Statamic on an Ubuntu instance you will need the following:

- An Ubuntu 20.04 or 18.04 VPS with root access enabled or a user with Sudo privileges (you can follow our [Digital Ocean](/installing/digital-ocean) or [Linode](/installing/linode) guides to get yours set up)
- A server with at least 1GB memory
- A valid domain name pointed to your server and SSL certificate in place
- PHP 7.4+


## Update Packages

If this is the first time using `apt` in this session, you should sure package lists and installed packages are up to date.

``` shell
sudo apt-get update
sudo apt-get upgrade
```

## Install PHP & Required Modules

``` shell
sudo apt install php-common php-fpm php-json php-mbstring zip unzip php-zip php-cli php-xml php-tokenizer -y
```

## Install Composer

Install Composer with the following command:

``` curl
curl -sS https://getcomposer.org/installer | php
```

Next, you need to move the `composer.phar` file to a globally accessible directory and update its permissions.

``` shell
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer
```

Now you can check to make sure Composer is installed and configured correctly by running this command:

``` shell
composer
```


## Create a new Statamic Application

Now we'll create a new Statamic application using the `composer create-project` command.

First, navigate to the `/var/www` directory:

``` shell
cd /var/www
```

Next, run the following install command:

``` shell
composer create-project --prefer-dist statamic/statamic example.com
```

:::tip
Alternatively, you could git clone an **existing project** instead of installing a new empty site.
:::

## Set Permissions

Once Statamic is installed, you'll need to grant appropriate permissions to the non-root user so Statamic and Laravel can write to the necessary system directories.

``` shell
sudo chmod -R 755 /var/www/example.com
sudo chown -R www-data:www-data /var/www/example.com
sudo chown -R www-data:www-data /var/www/example.com/storage
sudo chown -R www-data:www-data /var/www/example.com/content
sudo chown -R www-data:www-data /var/www/example.com/bootstrap/cache
```


## Install & Configure Nginx

Next, install [Nginx](https://nginx.com) with the following command:

``` shell
sudo apt install nginx -y
```

After the install completes, Nginx will start automatically. You can verify the service by running the following the command:

``` shell
sudo systemctl status nginx
```

Next, let's set up the minimum recommended config file to serve your site. Create a new file with `vim` (or your command line editor of choice) at `/etc/nginx/sites-available/example.com`, making sure to replace `example.com` everywhere with your desired domain.


```php
server {
    listen 80;
    server_name example.com; // [tl! highlight:1]
    root /var/www/example.com/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    index index.html index.htm index.php;

    charset utf-8;

    location / {
        try_files /static${uri}_${args}.html $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

You can confirm that the configuration doesn’t contain any syntax errors with the following command:

``` shell
sudo nginx -t
```

You should see output similar to this:

``` shell
# Output
nginx: the configuration file /etc/nginx/nginx.conf syntax is ok
nginx: configuration file /etc/nginx/nginx.conf test is successful
```

Time to reload Nginx and apply these changes:

``` shell
sudo systemctl reload nginx
```

Now visit your IP Address or `https://example.com` (but like the actual domain) if you've pointed your domain's A Record and you should see the Statamic landing page.

<figure>
    <img src="/img/quick-start/installed-3.3.png" alt="The Statamic Welcome Page">
    <figcaption>If you see this, you have just won.</figcaption>
</figure>

## Conclusion

That's pretty much it. Time for you to take it from here.

If this is your production server, you'll probably want to add cache expiry headers and so on, but those rules and what you cache to the browser are all up to you.

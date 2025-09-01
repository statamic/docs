---
id: 79d022e5-8fb0-4d20-955d-801e0edafa61
published: false
blueprint: page
title: 'Deploying Statamic to Digital Ocean'
parent: c4f17d05-78bd-41bf-8e06-8dd52f6ec154
---
## Create a Droplet.
We’ll start by spinning up a new droplet – the DigitalOcean lingo for a cloud server. Go ahead and sign into your DigitalOcean account and create a new droplet.

<figure>
    <img src="/img/deploying/digitalocean/create-droplet.png" alt="Create a new Droplet" width="395">
</figure>

### 1-Click App

We’ll be making use of 1-Click Apps to quickly spin up our server. So under **Choose an image**, click on the Marketplace tab and search for `Laravel`, and select it from the result.

<figure>
    <img src="/img/deploying/digitalocean/laravel-droplet.png" alt="Laravel Droplet">
</figure>

:::tip
Learn more about the [Laravel droplet](https://marketplace.digitalocean.com/apps/laravel)!
:::

### Plan Selection

Next, choose the basic $5/month plan, which is suitable for most sites without large amounts of traffic.

<figure>
    <img src="/img/deploying/digitalocean/choose-plan.png" alt="Choose a Plan">
    <figcaption>You could get fancy with a Premium Intel SSD. That's up to you.</figcaption>
</figure>

### Datacenter Region

For the datacenter region, choose the location closest to your main audience. When in doubt, go with New York 1 or 3.

### SSH Key

If you've already added SSH keys to DigitalOcean before, you can choose from those. Otherwise, you'll need to click on the **New SSH Key** Button to add a new SSH key. You can copy your local SSH key to the clipboard by running the following command:

```shell
pbcopy < ~/.ssh/id_rsa.pub && echo Key copied! You look nice today, btw.
```

Paste the gibberish into to the SSH key content field, give it a name, and click **Add SSH Key**.

<figure>
    <img src="/img/deploying/digitalocean/add-ssh-key.png" alt="Add SSH Key">
</figure>

### Hostname

Finally, choose a hostname if you don't want the unimaginative random one provided for you. For example, `pour-some-ubuntu-on-me` is way more fun than `lemp42onubuntu2004-s-1vcpu-1gb-nyc1-01`. When yoy're ready, click the **Create Droplet** button.

Your droplet is now being created. It should take about 2 minutes. Maybe 3 minutes. Could be 4 minutes. They're all very real possibilities.

<!--
## Creating a Non-Root Admin

It's generally recommended to carry out tasks on a server as a non-root user with administrative privileges. So let's do that first before we get into the configuration process.

First, you'll need to login to the server as `root` via ssh, from your local terminal applicaton. You'll need to know the IP address, which should be visible in the DigitalOcean admin.

```bash
ssh root@IP_ADDRESS
```

Next, create the new user. You can call it anything you want, you don't have to name everything after 80s–90s icons like we do.

```bash
adduser hulkhogan
```

Next, give your user admin privileges. After this step, you'll be able to run `sudo` commands.

```bash
usermod -aG sudo hulkhogan
```

Next, set up the SSH key for the new user. Copy that local SSH public key again to your clipboard in a separate terminal window:

```shell
pbcopy < ~/.ssh/id_rsa.pub && echo Key copied! You still look nice, btw.
```

Back to your remote session, switch to the new user (if you weren't already, automatically).

```bash
su - hulkhogan
```

Now you can create a new directory to store the SSH key, and restrict permissions to it.

```bash
mkdir ~/.ssh
chmod 700 ~/.ssh
```

Within the `.ssh` directory, create a new file called authorized_keys:

```bash
touch ~/.ssh/authorized_keys
```

Open the file:

```bash
vim ~/.ssh/authorized_keys
```

And paste your public key in there. Hit `esc` to stop editing, then `:wq` and `ENTER`. Now you know vim, if you didn't already. Great job!

Next, restrict the permissions of the authorized_keys file with this command:

```bash
chmod 600 ~/.ssh/authorized_keys
```

Type `exit` command below to return to the root user, and now you can use SSH keys to log in as the new user. Let's make sure it works.

```bash
ssh hulkhogan@IP_ADDRESS
```

If you logged in successfully, you're in great shape. If you didn't, start Googling everything you can think of to fix it.

We'll use this new `hulkhogan` user for the rest of this walk-through.
-->
## Log Into the Server

Next, you'll need to login to the server from your local terminal application. You'll need to know the IP address, which is visible in the DigitalOcean admin.

```bash
ssh root@your_droplet_public_ipv4
```

If you did not add an SSH key when you created the Droplet, you’ll first be prompted to reset your root password.

Then, the interactive script that runs will first prompt you for your domain or subdomain:

```bash
--------------------------------------------------
This setup requires a domain name.  If you do not have one yet, you may
cancel this setup, press Ctrl+C.  This script will run again on your next login
--------------------------------------------------
Enter the domain name for your new Laravel site.
(ex. example.org or test.example.org) do not include www or http/s
--------------------------------------------------
Domain/Subdomain name:
```

The next prompt asks if you want to use SSL for your website via Let’s Encrypt, which we recommend.

:::tip
That the DNS for the domain you've specified will need to be configured before being able to issue an SSL cert.
:::

```bash
Next, you have the option of configuring LetsEncrypt to secure your new site.  Before doing this, be sure that you have pointed your domain or subdomain to this server's IP address.  You can also run LetsEncrypt certbot later with the command 'certbot --nginx'

Would you like to use LetsEncrypt (certbot) to configure SSL(https) for your new site? (y/n):
```


## Pulling in Statamic

Finally, the fun stuff! Let's pull in your Statamic site using git by cloning it inside `/var/www`.

```bash
cd /var/www
git clone https://github.com/statamic/demo.git
```

Next, install the Composer dependencies.

```bash
cd demo
composer install
```

Now let's set up your `.env` file so you can manage your environment-specific settings.

```bash
cp .env.example .env
```

Next, generate an `APP_KEY` env var.

```bash
php artisan key:generate
```

Finally, edit the `.env` file and set the site to production mode by finding and setting the following vars:

```env
APP_ENV=production
APP_DEBUG=false
...
STATAMIC_FILE_WATCHER=false
```

## Setting up Nginx

Now it's time to configure Nginx to serve the site. Create a new virtual host configuration file inside `/etc/nginx/sites-available:`

```bash
sudo vim /etc/nginx/sites-available/demo
```
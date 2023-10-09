---
id: 94c521e3-bacb-45e3-b385-00bad3cac401
blueprint: page
title: Deploying Statamic with fortrabbit
intro: fortrabbit is a managed PHP app hosting solution running on AWS. Well known since 2012.
parent: c4f17d05-78bd-41bf-8e06-8dd52f6ec154
---

[fortrabbit](https://www.fortrabbit.com) is a full service provider, no account with another hosting provider required. Just sign up at fortrabbit.

## Creating a New App

fortrabbit has a 'try before buy' model. Create your first free trial App with the fortrabbit Dashboard. The free trial is limited in time, but you can ask friendly human support to extend the trial time.

While creating an App, choose Laravel as the framework for pre-configuration. Note that this will not install software. It is anticipated that you have a local development environment running Statamic ([see here](/installing)) to be deployed to the fortrabbit platform.

## Choosing a Deployment Method

The fortrabbit hosting platform offers integrated Git deployment as well as classical SSH/SFTP access. Depending on your use case and skills pick what fit's you the most. In the following the most popular workflow is shown. Replace variables in curly braces with your settings as provided with the fortrabbit Dashboard:

## Deploying Statamic with Git + rsync

* Content changes are synced up and down via rsync
* Template and theme code is deployed via Git
* Composer dependencies are automatically installed during Git deployment

### Configuring

Exclude contents from Git in your `.gitignore` file:

```.gitignore
# Exclude stuff you are creating from Git in .gitignore
/content
/users
/resources/blueprints
/resources/fieldsets
/resources/forms
/resources/users
/storage/forms
/public/assets
```

### Deploying Code with Git

In your local terminal, with the root folder of your Statamic project execute:

```shell
# 1. Initialize Git
git init

# 2. Add your Apps Git remote to your local repo
git remote add fortrabbit {{appname}}@deploy.{{region}}.frbit.com:{{appname}}.git

# 4. Add changes to Git
git add -A

# 5. Commit changes
git commit -m 'My first commit'

# 6. Initial push and upstream
git push -u fortrabbit main

# From there on only
git push
```

### Deploying Content with rsync

Again, in your local terminal, with the root folder of your Statamic project execute:

```shell
# SYNC UP: from local to remote
$ rsync -avR ./content ./users ./resources/blueprints ./resources/fieldsets ./resources/forms ./resources/users ./storage/forms ./public/build ./storage/app  ./public/assets {{appname}}@deploy.{{region}}.frbit.com:~/
```

It also works down and for specific folders only as shown here:

```shell
# SYNC DOWN: from remote to local one by one examples
rsync -av '{{appname}}@deploy.{{region}}.frbit.com:~/content ./
rsync -av '{{appname}}@deploy.{{region}}.frbit.com:~/users ./
…
```

## Advanced

fortrabbit also offers MySQL resources, so you can run Statamic in database mode. The fortrabbit team really cares about Statamic. See [their extensive Statamic guides section](https://help.fortrabbit.com/#statamic) with multiple deployment articles or contact human support if you are hanging somewhere.

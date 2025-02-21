---
id: 68d936b0-b1b0-431d-bbe0-a8356decf251
blueprint: page
title: 'Deploying Statamic with Laravel Cloud'
duplicated_from: 8fd95af9-f635-45bb-a3d1-1fa1db7be4a2
parent: c4f17d05-78bd-41bf-8e06-8dd52f6ec154
---
Before deploying to Laravel Cloud, there's a few things you should do to prepare your Statamic site:

* Right now, the [Git automation](/git-automation) doesn't work on Laravel Cloud. To workaround this, you can either:
   * Move [content](/tips/storing-content-in-a-database) and [users](https://statamic.dev/tips/storing-users-in-a-database) to the database.
   * Disable the Control Panel on Laravel Cloud, and push up any content changes from your local environment. 
* You should move any assets from the local filesystem to Laravel Cloud's object storage feature.

If you don't want to move content to a database, we recommend using to a VPS-based solution, like [Laravel Forge](/deploying/laravel-forge).


## Creating your application

Once you've created your [Laravel Cloud](https://app.laravel.cloud) account, click "New application" to get started.

If its your first application, you'll be asked to connect your Git provider of choice (GitHub, GitLab or Bitbucket).

From there, select the repository you want to deploy, give it a name and pick the region you want your application to be deployed in.

<figure>
    <img src="/img/deployment-cloud-new-application.png" alt="New application modal">
</figure>

Upon creation, you can setup any "resources" needed for your application, like a database or object storage bucket.

<figure>
    <img src="/img/deployment-cloud-project-overview.png" alt="Application overview">
</figure>

Make sure to click "Save" after making changes to your app's resources.

### Creating a database

If you're storing content and users in the database, you'll obviously need to create a database in Laravel Cloud. 

_Note: At the moment, Laravel Cloud only supports Postgres databases._

Once you've created your database cluster, you will most likely want to import data from an existing database you might have, whether that be locally or on a staging server.

You can use a database GUI, like [TablePlus](https://tableplus.com/) to do this.

1. Open your existing database, select all of the tables, and right click "Export". Make sure to save your export as a `.sql` file.
2. Connect to your new Laravel Cloud database using the "View credentials" function.

	<figure>
    	<img src="/img/deployment-cloud-db-credentials.png" alt="Database credentials modal">
	</figure>

	If you're using TablePlus (or another GUI that supports it), you can open the database directly from the "Deeplink" tab.    
3. Finally, import your database by right-clicking the tables list and selecting "Import -> From SQL File". You can then select the `.sql` file you just exported.

<!--
### Creating an object storage bucket

TODO
-->


## Deploying your application

Once everything is setup, all thats left to do is trigger a deployment. 

If you're using Vite to build CSS/JS, make sure you uncomment the `npm` commands in your application's deployment settings.

For more information about Laravel Cloud, see its [documentation](https://cloud.laravel.com/docs).


## Troubleshooting

### Upstream sent too big header while reading response header from upstream

You may encounter this error when submitting a form on the frontend, or updating content in the Control Panel.

You can fix it by changing your application's session driver from `cookie` to another driver, like `database` or `redis`. 

More information about session drivers can be found on the [Laravel documentation](https://laravel.com/docs/12.x/session#introduction).
---
title: 'Storing Users in a Database'
intro: 'Sometimes you just gotta or wanna.'
id: 4c3f5caa-a861-4ffd-a856-1692cafeb870
---
## Overview
If you have a large amount of users, or you need to scale horizontally, it may make sense to store them in a database.

### From a fresh Statamic project

If you installed Statamic using the `statamic new` command, or created a project based on the `statamic/statamic` repo, it will be configured to store users in files.

Statamic comes with an Eloquent driver to make the transition as seamless as possible.

1. Ensure you have a [database configured](https://laravel.com/docs/5.7/database#configuration).
2. In `config/statamic/users.php`, change `repository` to `eloquent`.
3. Comment out the `users` store in `config/statamic/stache.php`.
4. Run the `php please auth:migration` command to generates the migration for the role and user group pivot tables.
5. If you've customized your `user` blueprint, edit the migration so it includes those fields as columns, or create a new migration to add them.
6. Run `php artisan migrate`
7. Run a command to migrate your file based users into the database.

### In an existing Laravel app

If you've installed Statamic into an existing Laravel app, it will already be configured to use the Eloquent driver.
You will need to run migrations to prepare your database for Statamic's user and permission setup.

``` bash
php please auth:migration
php artisan migrate
```

This will add some columns to the `users` table (like `super`, and `last_login`), and create the `role_user` and `group_user` pivot tables.

This assumes you are happy to use our opinionated setup. If you need something more custom you can [create your own user driver](#custom-user-storage).

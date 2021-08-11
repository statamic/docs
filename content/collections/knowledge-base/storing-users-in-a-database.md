---
id: 4c3f5caa-a861-4ffd-a856-1692cafeb870
title: 'Storing Users in a Database'
intro: 'If you have a large or unknown number of users, it can be a good idea to store them in a database instead of the filesystem for the sake of performance or scaling.'
template: page
categories:
  - development
  - database
  - laravel
  - performance
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1622821321
---

## From a fresh Statamic project

If you installed Statamic using the `statamic new` command, or created a project based on the `statamic/statamic` repo, it will be configured to store users in files.

Statamic comes with an Eloquent driver to make the transition as seamless as possible.

1. Ensure you have a [database configured](https://laravel.com/docs/database#configuration).
2. In `config/statamic/users.php`, change `repository` to `eloquent`.
3. In `config/statamic/stache.php`, comment out the `users` store.
4. In `config/auth.php`, comment out the `statamic` provider, and uncomment the `eloquent` provider.
5. Run the `php please auth:migration` command to generates the migration for the role and user group pivot tables.
6. If you've customized your `user` blueprint, edit the migration so it includes those fields as columns, or create a new migration to add them.
7. Run `php artisan migrate`
8. Run a command to migrate your file based users into the database.

## In an existing Laravel app

If you've installed Statamic into an existing Laravel app, it will already be configured to use the Eloquent driver.

You will need to run migrations to prepare your database for Statamic's user, password reset, and permission setup.

1. Configure the two separate password reset drivers. Unlike a regular Laravel installation, Statamic has a second table to track password _activations_ which are the same as resets, but last a little longer before they expire. This is optional.

   In `config/auth.php` add the following inside the `passwords` array:

    ```php
    'activations' => [
        'provider' => 'users',
        'table' => 'password_activations',
        'expire' => 4320,
        'throttle' => 60,
    ],
    ```

    In `config/statamic/users.php` change the `passwords` array to:

    ```php
    'passwords' => [
        'resets' => 'resets',
        'activations' => 'activations',
    ],
    ```

2. Create and run the migrations.

    This will add some columns to the `users` table (like `super`, and `last_login`), create the `role_user` and `group_user` pivot tables, and create the `password_activations` table.

    ``` bash
    php please auth:migration
    php artisan migrate
    ```

> When using `sqlite` or `mysql` as your database driver, make sure to `composer require doctrine/dbal`. We change the `users` table in our auth migrations and therefore [require](https://laravel.com/docs/master/migrations#modifying-columns) the `doctrine/dbal` to run the migrations without errors.


This assumes you are happy to use our opinionated setup. If you need something more custom you can [create your own user driver](/knowledge-base/storing-users-somewhere-custom).

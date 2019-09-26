---
title: Users
template: page
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1568645051
id: 6b691e04-8f28-4eb2-8288-b61433883fe4
blueprint: page
---
## User Storage {#storage}

Users can be stored in [files](#storing-in-files), in a [database](#storing-in-a-database), or really [anywhere else](#custom-user-storage).

## Storing Users in Files {#storing-in-files}

When creating new site using the `statamic` command or by cloning `statamic/statamic`, your Laravel application will be preconfigured
to store users as files. Nothing else is required!

If you've installed Statamic into an existing Laravel application, it will be expecting users to be stored in the database, but you can switch to the filesystem:

1. In `config/statamic/users.php`, change `repository` to `file`.
2. In `config/auth.php`, change the users provider driver to `statamic`.
   ``` php
    'providers' => [
        'users' => [
            'driver' => 'statamic',
        ],
    ],
   ```

## Storing Users in a Database {#storing-in-a-database}

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

## Custom User Storage

If you'd like to store your users somewhere outside the filesystem, and the included Eloquent implementation doesn't quite cut it for you,
you're free to write your own.

You will need to write implementations for all the contracts located in `Statamic\Contracts\Auth`. Of course, you may extend the native classes and override where appropriate, instead of writing everything from scratch.

In a service provider, use the `Statamic\API\User::repository()` method to define a custom repository driver:

``` php
Statamic\Facades\User::repository('custom', function ($app, $config) {
    return new CustomUserRepository;
});
```

After you've registered the driver using the `repository` method, you'll want to create a repository in `config/statamic/users.php` that uses the new driver:

``` php
'repositories' => [
    'custom' => [
        'driver' => 'custom',
    ]
]
```

Finally, set that repository as the one you want active:

``` php
'repository' => 'custom'
```
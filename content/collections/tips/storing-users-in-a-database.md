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
1. In your user model, cast the preferences column to json.
    ```php
    class User extends Authenticatable
    {
        protected function casts(): array // [tl! focus]
        { // [tl! focus]
            return [ // [tl! focus]
                'preferences' => 'json', // [tl! ++] [tl! focus]
            ]; // [tl! focus]
        }; // [tl! focus]

        // ...
    }
    ```
1. If you plan to import existing file based users, you'll need to use UUIDs for the primary key. You can do this by adding a trait to your user model:
    ```php
    class User extends Authenticatable
    {
        use \Illuminate\Database\Eloquent\Concerns\HasUuids; // [tl! ++] [tl! focus]

        // ...
    }
    ```
1. In `config/statamic/users.php`, use the Eloquent repository.
    ```php
    'repository' => 'file', // [tl! --]
    'repository' => 'eloquent', // [tl! ++]
    ```
1. In `config/auth.php`, use the Eloquent provider:
    ```php
    'providers' => [
        'users' => [
            'driver' => 'statamic', // [tl! --]
            'driver' => 'eloquent', // [tl! ++]
            'model' => App\Models\User::class, // [tl! ++]
        ]
    ]
    ```
1. Generate a migration for the role and user group pivot tables.
    ```cli
    php please auth:migration
    ```
    - If you're planning to import existing file based users, edit the migration to change the `id` & `user_id` columns to the `uuid` type.
        ```php
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('id')->change(); // [tl! ++] [tl! **]
            $table->boolean('super')->default(false);
            $table->string('avatar')->nullable();
            $table->json('preferences')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->string('password')->nullable()->change();
        });

        Schema::create('role_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');  // [tl! --] [tl! **]
            $table->uuid('user_id');  // [tl! ++] [tl! **]
            $table->string('role_id');
        });

        Schema::create('group_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');  // [tl! --] [tl! **]
            $table->uuid('user_id');  // [tl! ++] [tl! **]
            $table->string('group_id');
        });
        ```
    - If you've customized your `user` blueprint, edit the migration so it includes those fields as columns. You can also create a new migration file by running `php artisan make:migration`. You'll have to manually edit the migration file to reflect your changes. Read up on [Laravel database migrations here](https://laravel.com/docs/12.x/migrations).
        ```php
        $table->string('some_field');
        ```
1. Run the migrations:
    ```cli
    php artisan migrate
    ```
1. If you have existing file based users, import them:
    ```cli
    php please eloquent:import-users
    ```
1. If you are using the Statamic forgot password form, add the following method to your User model
    ```php
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \Statamic\Notifications\PasswordReset($token));
    }
    ```

## In an existing Laravel app

If you've installed Statamic into an existing Laravel app, it will already be configured to use the Eloquent driver.

You will need to run migrations to prepare your database for Statamic's user, password reset, and permission setup.

1. Configure the two separate password reset drivers. Unlike a regular Laravel installation, Statamic has a second table to track password _activations_ which are the same as resets, but last a little longer before they expire. This is optional.

   In `config/auth.php` add the following inside the `passwords` array:

    ```php
    'activations' => [
        'provider' => 'users',
        'table' => 'password_activation_tokens',
        'expire' => 4320,
        'throttle' => 60,
    ],
    ```

    In `config/statamic/users.php` change the `passwords` array to:

    ```php
    'passwords' => [
        'resets' => 'users',
        'activations' => 'activations',
    ],
    ```

2. Create and run the migrations.

    This will add some columns to the `users` table (like `super`, and `last_login`), create the `role_user` and `group_user` pivot tables, and create the `password_activations` table.

    ``` shell
    php please auth:migration
    php artisan migrate
    ```
4. Optional: If you are using the Statamic forgot password form, add the following method to your User model
    ```php
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \Statamic\Notifications\PasswordReset($token));
    }
    ```


This assumes you are happy to use our opinionated setup. If you need something more custom you can [create your own user driver](/tips/storing-users-somewhere-custom).

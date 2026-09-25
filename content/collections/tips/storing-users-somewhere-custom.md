---
id: 1ee69ba0-2fa4-4155-9b8d-82536ce95f99
title: 'Storing Users Somewhere Custom'
intro: 'Build a custom user repository when file or Eloquent storage does not fit how your users need to work.'
template: page
categories:
  - database
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1622821332
---
If you'd like to store your users somewhere outside the filesystem, and the included Eloquent implementation doesn't quite cut it for you,
you're free to write your own.

:::tip
Writing a user repository from scratch is a lot of work. If you only need a different model or table, or want to tweak a few behaviors, it's usually easier to [store users in a database](/tips/storing-users-in-a-database) and extend the Eloquent classes (`Statamic\Auth\Eloquent\UserRepository` and `Statamic\Auth\Eloquent\User`), overriding only what you need.
:::

A custom driver is made up of two main pieces: a **user repository** that finds, saves and deletes users, and a **user class** that wraps whatever your users are stored as.

The interfaces in `Statamic\Contracts\Auth` describe the basics, but Statamic relies on a number of methods that aren't part of those interfaces. The easiest way to get them is to extend the abstract base classes, `Statamic\Auth\UserRepository` and `Statamic\Auth\User`, rather than implementing the contracts from scratch.

The native implementations are the best reference for how everything fits together:

- `Statamic\Auth\Eloquent\UserRepository` and `Statamic\Auth\Eloquent\User`
- `Statamic\Stache\Repositories\UserRepository` and `Statamic\Auth\File\User`

## The repository

Your repository should extend `Statamic\Auth\UserRepository` and implement the methods from the `Statamic\Contracts\Auth\UserRepository` interface, along with a few more that Statamic expects:

``` php
use Statamic\Auth\File\RoleRepository;
use Statamic\Auth\File\UserGroupRepository;
use Statamic\Auth\UserCollection;
use Statamic\Auth\UserRepository as BaseRepository;
use Statamic\Contracts\Auth\Passkey as PasskeyContract;
use Statamic\Contracts\Auth\User as UserContract;

class CustomUserRepository extends BaseRepository
{
    protected $config;
    protected $roleRepository = RoleRepository::class;
    protected $userGroupRepository = UserGroupRepository::class;

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    public static function bindings(): array
    {
        return [
            UserContract::class => CustomUser::class,
            PasskeyContract::class => CustomPasskey::class,
        ];
    }

    public function query()
    {
        // Return a query builder for your users...
    }

    public function all(): UserCollection { /* ... */ }
    public function find($id): ?UserContract { /* ... */ }
    public function findByEmail(string $email): ?UserContract { /* ... */ }
    public function findOrFail($id): UserContract { /* ... */ }
    public function fromUser($user): ?UserContract { /* ... */ }
    public function save(UserContract $user) { /* ... */ }
    public function delete(UserContract $user) { /* ... */ }
}
```

A few of these deserve some explanation:

- **`bindings()`** is a static method that tells Statamic which classes to use for its user-related contracts. When your repository is resolved, each of these will be bound in the service container, which is how `User::make()` knows to return an instance of your user class. You'll need to bind `Statamic\Contracts\Auth\User`, and `Statamic\Contracts\Auth\Passkey` if you want to support passkeys.
- **`$roleRepository` and `$userGroupRepository`** are the classes used for roles and user groups. The file-based repositories above store them in `resources/users/roles.yaml` and `resources/users/groups.yaml`. If you'd prefer to store them in the database, have a look at `Statamic\Auth\Eloquent\RoleRepository` and `Statamic\Auth\Eloquent\UserGroupRepository`.
- **`query()`** should return a query builder. It's used by the Control Panel's user listing, the `users` tag, search, and anywhere else users are queried. If your users are Eloquent models, you can return an instance of `Statamic\Auth\Eloquent\UserQueryBuilder` wrapping your model's query. Just be aware that it converts results by calling `User::make()->model($model)`, so your user class will need a `model()` method that accepts the Eloquent model (or you can extend `Statamic\Auth\Eloquent\User`, which already has one).
- **`fromUser()`** receives whatever Laravel's authentication guard returns (e.g. `auth()->user()`) and should convert it into an instance of your user class, or return `null` if it isn't one of your users.

## The user class

Your user class should extend `Statamic\Auth\User`, which handles most of the Statamic-specific behavior (augmentation, permissions, password resets, two-factor authentication, etc.) for you.

On top of the methods in the `Statamic\Contracts\Auth\User` interface, you'll need to implement:

- The data methods: `id()`, `data()`, `get()`, `has()`, `set()`, `remove()` and `merge()`. Called without arguments, `data()` should return a collection. If you're keeping the user's data in an array, the `Statamic\Data\ContainsData` trait implements most of these for you. If you implement your own data methods, also use the `Statamic\Data\ContainsSupplementalData` trait, which augmentation relies on. `ContainsData` already includes it.
- The remember token methods required by Laravel's `Authenticatable` interface: `getRememberToken()`, `setRememberToken()` and `getRememberTokenName()`.
- `lastLogin()` and `setLastLogin()`, which are used to record when a user last logged in.
- `lastModified()`
- `getCurrentDirtyStateAttributes()`, which returns an array of the attributes used to track whether a user has unsaved changes.
- The preference methods. Statamic reads and writes each user's Control Panel preferences using `preferences()`, which you can add using the `Statamic\Preferences\HasPreferences` trait. The trait expects you to implement `getPreferences()`, `setPreferences()` and `mergePreferences()`.

``` php
use Statamic\Auth\User as BaseUser;
use Statamic\Preferences\HasPreferences;

class CustomUser extends BaseUser
{
    use HasPreferences;

    protected function getPreferences()
    {
        // Return an array of the user's preferences...
    }

    public function setPreferences($preferences)
    {
        // Replace the user's preferences...
    }

    public function mergePreferences($preferences)
    {
        // Merge the given preferences into the user's existing preferences...
    }

    // ...
}
```

:::tip
The `isSuper()`, `roles()`, `groups()` and `hasPermission()` methods determine what a user can do in the Control Panel. If your application already has its own concept of roles or super users, these are the methods you'd override to map them onto Statamic's.
:::

## Registering the driver

In a service provider, use the `extend` method on the `UserRepositoryManager` to define a custom repository driver:

``` php
app(\Statamic\Auth\UserRepositoryManager::class)->extend('custom', function ($app, $config) {
    return new CustomUserRepository($config);
});
```

After you've registered the driver using the `extend` method, you'll want to create a repository in `config/statamic/users.php` that uses the new driver:

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

## Authentication

Laravel needs to know how to retrieve your users when they log in. Statamic registers a `statamic` user provider which retrieves users using whichever repository is active, so you can point your guard's provider to it in `config/auth.php`:

``` php
'providers' => [
    'users' => [
        'driver' => 'statamic',
    ],
],
```

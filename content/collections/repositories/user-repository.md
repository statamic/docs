---
id: 1f89a175-5544-4151-9228-620f2c4f0925
blueprint: repositories
title: 'User Repository'
nav_title: Users
related_entries:
  - e7833062-e05c-42c9-ad35-dc5077f1f0b8
  - 0f8102b9-c948-4264-8cb8-cbfbd0415a04
  - 980c2496-c80a-44f2-8f28-39cfdeccc2c8
  - c5f70315-b897-4037-a599-ef298539b988
---
To work with the User Repository, use the following Facade:

```php
use Statamic\Facades\User;
```

## Methods

| Methods | Description |
| ------- | ----------- |
| `all()` | Get all Users |
| `current()` | Get current User |
| `find($id)` | Get User by `id` |
| `findByEmail($email)` | Get User by `email` |
| `findByOAuthID($provider, $id)` | Get User by an ID from an OAuth provider  |
| `query()` | Query Builder |
| `make()` | Makes a new `User` instance |

## Querying

#### Get a user by ID

```php
User::query()
    ->where('id', 'abc123')
    ->first();

// Or with the shorthand method
User::find('abc123');
```

#### Get a user by email

```php
User::query()
    ->where('email', 'hulk@hogan.com')
    ->first();

// Or with the shorthand method
User::findByEmail('hulk@hogan.com');
```

#### Get a user by OAuth ID

```php
User::findByOAuthId('github', '123');
```

#### Get all super users

```php
User::query()->where('super', true)->get();
```

#### Get the currently logged in user

```php
User::current();
```

## Creating

Start by making an instance of a user with the `make` method.
You need at least an email before you can save a user.

```php
$user = User::make()->email('john@smith.com');
```

You may call additional methods on the user to customize it further.

```php
$user
  ->password('plaintext') // it will be hashed for you
  ->data(['foo' => 'bar']) // an array of data (front-matter)
  ->preferences($prefs) // array of preferences
  ->roles($roles) // array of roles
  ->groups($groups); // array of groups
```

Finally, save it.

```php
$user->save();
```

### Roles & Groups

In the example above, it demonstrates passing roles & groups as arrays to the `->roles()` and `->groups()` methods.

However, Statamic also provides a few convenience methods for assigning/removing/checking individual roles & groups:

```php
$user->roles(); // Returns a collection of the user's roles
$user->roles(['role_1', 'role_2']); // Sets the user's roles (overrides any existing roles)
$user->assignRole('role_1'); // Assigns a role to the user
$user->removeRole('role_1'); // Removes a role from the user
$user->hasRole('role_2'); // Checks if the user has the provided role.

$user->groups(); // Returns a collection of the user's groups
$user->groups(['group_1', 'group_2']); // Sets the user's groups (overrides any existing groups)
$user->addToGroup('group_1'); // Adds the user to a group
$user->removeFromGroup('group_1'); // Removes the user from a group
$user->isInGroup('group_2'); // Checks if the user is part of a group
```

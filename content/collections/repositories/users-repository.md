---
id: 1f89a175-5544-4151-9228-620f2c4f0925
blueprint: repositories
title: 'Users Repository'
nav_title: Users
related_entries:
  - e7833062-e05c-42c9-ad35-dc5077f1f0b8
  - 0f8102b9-c948-4264-8cb8-cbfbd0415a04
  - 980c2496-c80a-44f2-8f28-39cfdeccc2c8
  - c5f70315-b897-4037-a599-ef298539b988
---
## Methods

| Methods | Description |
| ------- | ----------- |
| `all()` | Get all Users |
| `current()` | Get current User |
| `find($id)` | Get User by `id` |
| `findByEmail($email)` | Get User by `email` |
| `findByOAuthID($id)` | Get Entry by `oauth_id` |
| `query()` | Query Builder |


To work with the User Repository, use the following Facade:

```php
use Statamic\Facades\User;
```

#### Get a user by email

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
User::query()
    ->where('oauthid', 'github123')
    ->first();

// Or with the shorthand method
User::findByOAuthId('github123');
```

#### Get all super users

```php
User::query()->where('super', true)->get();
```

#### Get all users in a role

```php
User::query()->where('role', 'editor')->get();
```

#### Get all users in a group

```php
User::query()->where('group', 'newbies')->get();
```

#### Get the currently logged in user

```php
User::current();
```

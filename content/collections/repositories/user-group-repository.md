---
id: 980c2496-c80a-44f2-8f28-39cfdeccc2c8
blueprint: repositories
title: 'User Group Repository'
nav_title: 'User Groups'
related_entries:
  - e7833062-e05c-42c9-ad35-dc5077f1f0b8
  - 980c2496-c80a-44f2-8f28-39cfdeccc2c8
---
To work with the with `UserGroup` Repository, use the following Facade:

```php
use Statamic\Facades\UserGroup;
```

## Methods

| Methods | Description |
| ------- | ----------- |
| `all()` | Get all User Groups |
| `find($id)` | Get User Group by `id` |
| `queryUsers()` | Query Builder for Users in a Group |
| `make()` | Makes a new `UserGroup` instance |

## Querying

#### Examples {.popout}

#### Get a User Group

``` php
UserGroup::find('admin');
```

#### Get all users in a group

``` php
UserGroup::find('editors')
    ->queryUsers()
    ->get();
```

#### Find admins with an avatar
``` php
UserGroup::find('admin')
    ->queryUsers()
    ->where('avatar', true)
    ->get();
```

## Creating

Start by making an instance of a user group with the `make` method. You can pass the handle into it.

```php
$group = UserGroup::make('admin');
```

You may call additional methods on the group to customize it further.

```php
$group
    ->title('Administrators')
    ->roles($roles); // array of role handles
```

Finally, save it.

```php
$group->save();
```

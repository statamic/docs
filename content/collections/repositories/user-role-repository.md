---
id: c5f70315-b897-4037-a599-ef298539b988
blueprint: repositories
title: 'User Role Repository'
nav_title: 'User Roles'
related_entries:
  - e7833062-e05c-42c9-ad35-dc5077f1f0b8
  - 0f8102b9-c948-4264-8cb8-cbfbd0415a04
  - 6b691e04-8f28-4eb2-8288-b61433883fe4
---
To work with the with `Role` Repository, use the following Facade:

```php
use Statamic\Facades\Role;
```

## Methods

| Methods | Description |
| ------- | ----------- |
| `all()` | Get all User Roles |
| `find($id)` | Get User Roles by `id` |
| `make()` | Makes a new `Role` instance |

:::tip
The `id` is the same as `handle` while using the default Stache driver.
:::


## Creating

Start by making an instance of a user role with the `make` method. You can pass the handle into it.

```php
$role = Role::make('editors');
```

You may call additional methods on the role to customize it further.

```php
$role
    ->title('Editors')
    ->permissions($permissions); // array of permissions
```

Finally, save it.

```php
$role->save();
```

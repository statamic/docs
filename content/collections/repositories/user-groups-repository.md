---
id: 980c2496-c80a-44f2-8f28-39cfdeccc2c8
blueprint: repositories
title: 'User Groups Repository'
nav_title: 'User Groups'
related_entries:
  - e7833062-e05c-42c9-ad35-dc5077f1f0b8
  - 980c2496-c80a-44f2-8f28-39cfdeccc2c8
---
## Methods

| Methods | Description |
| ------- | ----------- |
| `all()` | Get all User Groups |
| `find($id)` | Get User Group by `id` |
| `queryUsers()` | Query Builder for Users in a Group |

### Examples {.popout}

#### Get a User Group

``` php
Statamic\Facades\UserGroup::find('admin')->get();
```

#### Get all users in a group

``` php
Statamic\Facades\UserGroup::find('editors')
    ->queryUsers()
    ->get();
```

#### Find admins with an avatar
``` php
Statamic\Facades\UserGroup::find('admin')
    ->queryUsers()
    ->where('avatar', true)
    ->get();
```

---
title: Permissions
template: page
updated_by: 42bb2659-2277-44da-a5ea-2f1eed146402
updated_at: 1569347255
id: ff397ebf-4b53-4dbd-b81b-0dec839e0e5f
---
Permissions are the abilities that can be assigned to [Roles](/guide/authorization.html#roles). 

Out of the box, Statamic has its own set of permissions that you can choose from to configure your roles. However, you are free to add your own that can be used throughout your project, or included with addons.

## Basic Permissions

You can register a basic permission in a service provider by specifying the string.

``` php
use Statamic\API\Permission;

public function boot()
{
    $this->app->booted(function () {
        Permission::register('manage stuff')
                  ->withLabel('Manage Custom Stuff');
    });
}
```

This will add an option to the permissions list when editing a role in the Control Panel.

If selected, this will add the permission string to the role:

``` yaml
permissions:
  - manage stuff
```

## Nested Permissions

It could be useful to only allow some permissions if others have already been granted. For example:

Notice that "Edit entries" is selectable, however the two child items are not.
They would become selectable once you check it.

This can be achieved using the `withChildren` method on the permission:

``` php
Permission::register('view blog entries', function ($permission) {
    $permission->withChildren([
        Permission::make('edit blog entries')->withChildren([
            Permission::make('create blog entries'),
            Permission::make('delete blog entries')
        ]);
    ]);
});
```

The second argument of the `register` method accepts a closure that allows you to modify the permission.


## Policy based permissions

When dealing with a permission that could apply to a variable number of items, it makes more sense to use a [Policy](https://laravel.com/docs/5.7/authorization#creating-policies).

You may combine your policy with a wildcard permission. A new permission will be created for each item you require.

For example, Statamic creates a `view {collection} entries` permission for each collection that exists.

It does this by using a `withReplacements` method to return a list of items to determines the replacements. It should return an array of arrays where `value` is the string to be inserted into the permission, and optionally a `label` to be inserted into the label.

``` php
Permission::register('view {collection} entries', function ($permission) {
    $permission
        ->withLabel('View :collection entries')
        ->withReplacements('collection', function () {
            return Collection::all()->map(function ($collection) {
                return [
                    'value' => $collection->handle(),
                    'label' => $collection->title()
                ];
            });
    });
});
```

To use your policy permissions, you should write the authorization checks from within a Policy class. For example:

``` php
class EntryPolicy
{
    public function edit($user, $entry)
    {
        return $user->hasPermission("view {$entry->collectionName()} entries");
    }
}
```

Finally, you may combine policy wildcard permissions with nested permissions.

``` php
Permission::register('view {collection} entries', function ($permission) {
    $permission
        ->withReplacements('collection', function () { /* ... */ });
        ->withChildren([
            Permission::make('edit {collection} entries')->withChildren([
                Permission::make('create {collection} entries')
                Permission::make('delete {collection} entries')
            ])
        ])
});
```
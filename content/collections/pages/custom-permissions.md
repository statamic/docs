---
title: 'Custom Permissions'
intro: 'Register your own permissions for apps and addons with `Permission::register` — nested trees, wildcards, policies, and groups.'
template: page
updated_by: 42bb2659-2277-44da-a5ea-2f1eed146402
updated_at: 1784057408
id: ff397ebf-4b53-4dbd-b81b-0dec839e0e5f
related_entries:
  - 11434ba8-33f6-4229-b5d7-e4c9c3ea867e
  - 5da3761e-cbf9-4faa-bc69-3cc0fab4ff29
  - 6b691e04-8f28-4eb2-8288-b61433883fe4
---
:::tip
Looking for roles or the built-in permission matrix? Start at [Roles](/roles) and [Permissions](/permissions). This page is the developer API for registering new abilities.
:::

Permissions are the abilities that can be assigned to [roles](/roles).

Out of the box, Statamic has its own set of [native permissions](/permissions#native-permissions) that you can choose from when configuring roles. You can also add your own for use throughout your project, or ship them with an addon.

## Basic permissions

You can register a basic permission in a service provider by specifying the string. Make sure to surround any permission registrations in a `Permission::extend` closure.

``` php
use Statamic\Facades\Permission;

public function boot()
{
    Permission::extend(function () {
        Permission::register('manage stuff')
                  ->label('Manage Custom Stuff');
    });
}
```

This will add an option to the permissions list when editing a role in the Control Panel.

If selected, this will add the permission string to the role:

``` yaml
permissions:
  - manage stuff
```

## Nested permissions

It could be useful to only allow some permissions if others have already been granted. For example, you want a tree like this:

``` files theme:serendipity-light
view blog entries
    edit blog entries
        create blog entries
        delete blog entries
```

Initially, only the `view` option will be selectable. When you check it, then the `edit` option becomes selectable.
Check that, and the `create` and `delete` options become selectable.

This can be achieved by passing an array of permissions to the `children` method on the parent permission:

``` php
Permission::register('view blog entries', function ($permission) {
    $permission->children([
        Permission::make('edit blog entries')->children([
            Permission::make('create blog entries'),
            Permission::make('delete blog entries')
        ])
    ]);
});
```

The second argument of the `register` method accepts a closure that allows you to modify the permission.

## Hiding permissions covered by a broader one

Sometimes a broader permission already grants everything a more specific one does — for example, `configure asset containers` already grants every ability `view {container} assets` guards. Rather than show redundant checkboxes for both, you can hide a permission behind one or more others with `hiddenBy`:

``` php
Permission::register('view {container} assets', function ($permission) {
    $permission->hiddenBy('configure asset containers');
});
```

When any of the hiding permissions are checked in the roles UI, this permission — and its children — disappear. Unchecking brings them back, with their checked state intact.

You may pass an array to hide a permission behind more than one:

``` php
Permission::register('edit {form} form', function ($permission) {
    $permission->hiddenBy(['configure forms', 'edit forms']);
});
```

:::tip
`hiddenBy` only affects the roles UI. Unlike `children`, it doesn't grant anything or establish a hierarchy — it just keeps the checkbox out of sight once a broader permission already covers it.
:::

## Policy based permissions

When dealing with a permission that could apply to a variable number of items, it makes more sense to use a [Policy](https://laravel.com/docs/authorization#creating-policies).

You may combine your policy with a wildcard permission. A new permission will be created for each item you require.

For example, Statamic creates a `view {collection} entries` permission for each collection that exists.

It does this by using a `replacements` method to return a list of items to determines the replacements. It should return an array of arrays where `value` is the string to be inserted into the permission, and a `label` to be inserted into the label.

``` php
Permission::register('view {collection} entries', function ($permission) {
    $permission
        ->label('View :collection entries')
        ->replacements('collection', function () {
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
        ->label('View :collection entries')
        ->replacements('collection', function () { /* ... */ })
        ->children([
            Permission::make('edit {collection} entries')->children([
                Permission::make('create {collection} entries'),
                Permission::make('delete {collection} entries')
            ])
        ])
});
```

:::tip
When using replacements, ensure your `label` string contains a placeholder prefixed with a colon.
:::

## Groups

You can put your permissions in your own group. Give it a name, a label, and then any permissions created inside
the callback will be added to that group.

``` php
Permission::group('myaddon', 'My Addon', function () {
    Permission::make(...);
});
```

If you want to add permissions to an existing group (eg. the core ones like collections, taxonomies, etc.) you can
just leave out the label argument:

``` php
Permission::group('collections', function () {
    Permission::make(...);
});
```

## Adding to the core permissions

It's possible to add to the built-in permission tree if you need to.

For example, maybe you want to add a permission to send tweets once an entry is published. You might want to jam
that in every collection's permission tree under its 'edit' permission.

You can use the `addChild` method on an existing permission to inject it at that position.

``` php
Permission::extend(function () {
    Permission::get('edit {collection} entries')->addChild(
        Permission::make('tweet {collection} entries')
    );
});
```


## Overriding Policies

You may override policies by registering a binding in your AppServiceProvider.

```php
public function register()
{
    $this->app->bind(
        \Statamic\Policies\EntryPolicy::class, 
        \App\Policies\CustomEntryPolicy::class
    );
}
```

```php
class CustomEntryPolicy extends \Statamic\Policies\EntryPolicy
{
    public function edit($user, $entry)
    {
        // ...
    }
}
```

Keep in mind that most of Statamic policies will grant access earlier if the user is a super user. If you need to disable or override the super user logic, you will need to also adjust the `before` method. For example:

```php
class CustomEntryPolicy extends \Statamic\Policies\EntryPolicy
{
    public function before($user, $ability) // [tl! **:start]
    {
        if ($ability === 'edit') {
            // Returning null here will allow the method to be called.
            return null;
        }
        
        return parent::before($user, $ability);
    } // [tl! **:end]
    
    
    public function edit($user, $entry)
    {
        // ...
    }
}
```

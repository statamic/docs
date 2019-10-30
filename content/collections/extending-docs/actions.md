---
title: Actions
template: page
updated_by: 42bb2659-2277-44da-a5ea-2f1eed146402
updated_at: 1569347227
id: ba2e6172-b4dc-443b-8230-b770dec1423c
intro: Actions allow you perform tasks on one or more items. You can trigger actions by selecting multiple items in a listing, or using each item's contextual menu.
---

## Defining an action

You may create an action using the following command, which will generate a class in the `App\Actions` namespace.

``` bash
php please make:action
```

The most basic action should have a `run` method.

``` php
use Statamic\Actions\Action;

class Delete extends Action
{
    public function run($items, $values)
    {
        $items->each->delete();
    }
}
```

The `run` method is for executing the task. You will be provided with a collection of `$items`, and any submitted `$values` (more about those later).

## Registering an Action

Any action classes that exist in the `App\Actions` namespace will be automatically registered.

If you would like to store them elsewhere, you can manually register an action in a service provider by calling the static `register` method on your action class.

``` php
public function boot()
{
    Your\Action::register();
}
```

## Filtering Actions

You may limit which items an action can be applied to using the `filter` method. For example, if you want your action to only be used by entries, you can return a boolean like this:

``` php
use Statamic\Contracts\Entries\Entry;

public function filter($item)
{
    return $item instanceof Entry;
}
```

> Don't include authorization in your filter method. Instead, use the authorize method below.

## Authorizing Actions

Before any actions are run, Statamic will make sure the user is allowed to run them. You can return a boolean like this:

``` php
public function authorize($user, $item)
{
    return $user->can('edit', $item);
}
```

By default, there is no authorization.

## Dangerous Actions

You can mark an action as dangerous, which will give it red text and more sinister looking confirmation dialog.

``` php
protected $dangerous = true;
```

## Context

Each action may have additional contextual data passed to it depending on which listing its being used within. For example, you may find
the collection handle when used inside an entry listing, or the asset container handle when used in an asset listing

``` php
$this->context; // ['collection' => 'blog']
```

You may find this useful when building confirmation dialog fields:

## Adding Fields

By default, an action will prompt you with an "Are you sure?" dialog.

However, you're free to add fields to the action that'll be displayed in that confirmation dialog. Do that by adding a `$fields` property with a fieldset-style definition.

``` php
protected $fields = [
    'message' => [
        'type' => 'text',
        'validate' => 'required|min:40',
    ]
];
```

If you need more control over the fields, you can use the `fieldItems` method instead. Within this method, you can use `$this->context`. Then return the same array as described above.

``` php
protected function fieldItems()
{
    return [
        'message' => ['type' => 'text'],
    ];
}
```

The values entered into these fields when a user runs the action will be passed into the `run` method.

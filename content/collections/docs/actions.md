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

The most basic action should have `visibleTo` and `run` methods.

``` php
use Statamic\Actions\Action;

class Delete extends Action
{
    public function visibleTo($key, $context)
    {
        return true;
    }

    public function run($items, $values)
    {
        $items->each->delete();
    }
}
```

The `visibleTo` method defines whether the action should be visible on a given listing.
The listing will have a unique `$key` (for example, `entries` when viewing a list of entries in a collection).
It may also provide a `$context` array with some extra values (for example, the entries listing will provide the `collection` handle).

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

## Dangerous Actions

You can mark an action as dangerous, which will give it red text and more sinister looking confirmation dialog.

``` php
protected $dangerous = true;
```

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

---
title: 'Query Scopes'
template: page
updated_by: 42bb2659-2277-44da-a5ea-2f1eed146402
updated_at: 1569347415
id: 290e9a74-7c6b-4fd0-a90a-23f7ac38d0c5
intro: Query Scopes allow you to narrow down query results using custom conditions.
---
You may create scopes that can be used in various places, such as inside the collection tag or inside control panel listings.

## Creating a Scope

Any scope classes located within `app/Scopes` will be automatically registered.

You may create a scope class by running `php please make:scope`, which will give you a class with a few methods for you to implement, for example:

``` php
<?php

namespace App\Scopes;

use Statamic\Query\Scopes\Scope;
use Statamic\Query\Scopes\Filter;

class Featured extends Scope
{
    public function apply($query, $values)
    {
        $query->where('featured', true);
    }
}
```

The `apply` method will give you a query builder instance, allowing you to modify it how you see fit.

It will also give you `$values`, which will be an array of contextual values. For example, when [using the scope on a collection tag](), you will get all the parameter values. When used as a [filter](#filters) inside the control panel, you will get all of your filter's field values.

## Filters

Filters are UI based scopes that will be displayed in listings inside the Control Panel.

You're able to attach any number of fields to it to allow your users to refine their listings.

To create a filter, you can create a scope with `php please make:scope`, and modify `extends Scope` to `extends Filter`:

``` php
<?php

namespace App\Scopes;

use Statamic\Query\Scopes\Scope;
use Statamic\Query\Scopes\Filter;

class Featured extends Filter
{
    protected $field = [
        'type' => 'toggle',
        'display' => 'Featured',
        'instructions' => 'Only display featured items',
    ];

    public function apply($query, $values)
    {
        $query->where('featured', $values['value']);
    }

    public function visibleTo($key)
    {
        return $key === 'entries'
            && $this->context['collection'] == 'blog';
    }
}
```

The `$field` property lets you define what will be displayed, just like a field inside a Blueprint.
If you want multiple fields, you can use a `$fields` property instead, which expects a multidimensional array.
For extra control, use the `fieldItems` method rather than the properties.

``` php
protected $fields = [
    'featured' => [
        'type' => 'toggle',
        'display' => 'Featured',
        'instructions' => 'Only display featured items',
    ],
    'mine' => [
        'type' => 'toggle',
        'display' => 'My Featured items',
        'instructions' => 'Only display items that I authored',
    ]
];
```

The `visibleTo` method allows you to control in which listings this filter will be displayed. You will be given a key that represents the type of listing. For example, an author filter might be appropriate for the `entries` listing but not `users`. You may also be given an array of contextual data which will vary depending on the listing. For instance, the `entries` listing will also provide the collection.

---
title: 'Query Scopes & Filters'
template: page
updated_by: 42bb2659-2277-44da-a5ea-2f1eed146402
updated_at: 1569347415
intro: Query scopes and filters allow you to narrow down query results using custom conditions.
stage: 1
id: 290e9a74-7c6b-4fd0-a90a-23f7ac38d0c5
---
You may create scopes that can be used in various places, such as inside the collection tag or inside control panel listings.

## Scopes

Any scope classes located within `app/Scopes` will be automatically registered.

You may create a scope class by running `php please make:scope`, which will give you a class with a few methods for you to implement, for example:

``` php
<?php

namespace App\Scopes;

use Statamic\Query\Scopes\Scope;

class Featured extends Scope
{
    public function apply($query, $values)
    {
        $query->where('featured', true);
    }
}
```

The `apply` method will give you a query builder instance, allowing you to modify it how you see fit.

It will also give you `$values`, which will be an array of contextual values. For example, when [using the scope on a collection tag](/tags/collection#custom-query-scopes), you will get all the parameter values. When used as a [filter](#filters) inside the control panel, you will get all of your filter's field values.

## Filters

Filters are UI based [scopes](#scopes) that will be displayed in listings inside the Control Panel.

You're able to configure any number of fields to a filter to allow your users to refine their listings.

You may create a filter class by running `php please make:filter`, which will give you a class with a few methods for you to implement, for example:

``` php
<?php

namespace App\Scopes;

use Statamic\Query\Scopes\Filter;

class Featured extends Filter
{
    public function fieldItems()
    {
        return [
            'featured' => [
                'type' => 'radio',
                'options' => [
                    'featured' => __('Featured'),
                    'not_featured' => __('Not Featured'),
                ]
            ]
        ];
    }
    
    public function autoApply()
    {
        return [
            'featured' => 'not_featured',
        ];
    }

    public function apply($query, $values)
    {
        $query->where('featured', $values['featured'] === 'featured');
    }

    public function badge($values)
    {
        return $values['featured'] === 'featured'
            ? __('is featured')
            : __('not featured');
    }

    public function visibleTo($key)
    {
        return $key === 'entries';
    }
}
```

The `fieldItems` method lets you define which filter fields will be displayed, just like a field inside a Blueprint.

The `apply` method works exactly as it would in a standard [scope](#scopes).

The `badge` method lets you define the badge text to be used when the filter is active on a listing.

The `visibleTo` method allows you to control in which listings this filter will be displayed. You will be given a key that represents the type of listing. For example, an author filter might be appropriate for the `entries` listing but not `users`. You may also be given an array of contextual data which will vary depending on the listing. For instance, the `entries` listing will also provide the collection.

The `autoApply` method lets you define a default value to apply.

You may also pin your filters to the right side of the search bar by setting the `$pinned` class property:

```php
public $pinned = true;
```

---
title: 'Relationship Fieldtypes'
template: page
updated_by: 42bb2659-2277-44da-a5ea-2f1eed146402
updated_at: 1569347303
id: 06813e5d-158e-4318-aa4a-b29fd87d107f
intro: The [Relationship fieldtype](/fieldtypes/relationship) is one of the more powerful fields in Statamic's core. So powerful, in fact, that it earns its very own page in the docs. This is that page.
---
By default, the relationship fieldtype lets you select entries from various collections as well as create and edit items on the fly from _within_ the field.

You can create your own relationship fields that provide the ability to select all different sorts of items from anywhere.

## Example

To illustrate that you can get items from anywhere — even remote APIs — we'll build a field where you can select tweets from a given user.

In your blueprints, you'll be able to use `type: tweets` (whatever you name your fieldtype) and all the options that the relationship field would normally give you, like `max_items`:

``` yaml
fields:
  handle: tweets
  field:
    type: tweets
    max_items: 3
```

## Creating the Fieldtype

You will need to create the fieldtype – no Vue component necessary – so you can skip it with the <nobr>`--php`</nobr> flag:

``` bash
php please make:fieldtype Tweets --php
```

Then instead of extending `Fieldtype`, you'll extend the existing `Relationship` fieldtype:

``` php
use Statamic\Fieldtypes\Relationship;

class Tweets extends Relationship
{
    //
}
```

There are a handful of methods and properties inside the `Relationship` class, and you can override them to control how it functions.

There are two main areas you will want to customize. The index items and the selected item data.

## Index Items

The index items are what you'll see in the item selector stack.

You can either override the `getIndexQuery` method if you're dealing with items being retrieved through the Statamic API. You'll need to return a QueryBuilder.

``` php
public function getIndexQuery($request)
{
    return Entry::query()->whereIn('collection', $request->collections);
}
```

Or, you can override `getIndexItems` for full control. We'll use this for our Twitter example.

``` php
use Carbon\Carbon;

public function getIndexItems($request)
{
    $tweets = Twitter::getUserTimeline([
        'screen_name' => $this->config('screen_name')
    ]);

    return $this->formatTweets($tweets);
}

protected function formatTweets($tweets)
{
    return collect($tweets)->map(function ($tweet) {
        $date = Carbon::parse($tweet->created_at);

        return [
            'id'            => $tweet->id_str,
            'text'          => $tweet->text,
            'date'          => $date->timestamp,
            'date_relative' => $date->diffForHumans(),
            'user'          => $tweet->user->screen_name,
        ];
    });
}
```

You can customize which columns will be used in the selector by overriding the `getColumns` method:

``` php
use Statamic\CP\Column;

protected function getColumns()
{
    return [
        Column::make('text'),
        Column::make('user'),
        Column::make('date')->value('date_relative'),
    ];
}
```

## Selected Item Data

Once you select items, their `id` values will be used as the value for your field. If you were to hit save, you would see
something like this in your content files:

``` yaml
tweets:
  - 54376134
  - 89473529
```

In order to convert those values into something useful, you'll either need to override the `getItemData` method or the `toItemArray` method. For our example, we'll use the former:

``` php
public function getItemData($values, $site = null)
{
    $tweets = Twitter::getStatusesLookup(['id' => implode(',', $values)]);

    return $this->formatTweets($tweets);
}
```

## Creating Items

Todo.

To disable creation of items, you can add the canCreate property.

``` php
protected $canCreate = false;
```


## Searching

By default, the search bar will be visible in the selector stack. When a user types into it, its value will be submitted in the `search` query parameter. You can tweak your logic to account for searching in your `getIndexItems` method. For example:

``` php
public function getIndexItems($request)
{
    return $request->search
        ? $this->searchTweets($request->search)
        : $this->userTweets();
}
```

To disable searching, you can add the canSearch property.

``` php
protected $canSearch = false;
```


## Customizing the view

By default, the fieldtype will show the standard draggable block, with the `title` as the text. You may provide your
own Vue component to the `itemComponent` property to replace it.

``` php
protected $itemComponent = 'TwitterRelationshipItem';
```

``` js
Vue.component('TwitterRelationshipItem', require('./TwitterRelationshipItem.vue'));
```

``` vue
<template>
    <div class="item mb-1 ">
        <div class="item-move">&nbsp;</div>
        <div class="item-inner">
            <div class="p-3">
                <p class="text-lg mb-2">{{ item.text }}</p>
                <p class="text-grey">{{ item.user }} – {{ item.date_relative }}</p>
            </div>
        </div>
        <dropdown-list class="pr-1">
            <ul class="dropdown-menu">
                <li class="warning"><a @click.prevent="$emit('removed')" v-text="__('Unlink')"></a></li>
            </ul>
        </dropdown-list>
    </div>
</template>

<script>
export default {
    props: {
        item: Object
    }
}
</script>
```

An `item` prop will be passed to your component which will contain one the objects provided by the `getItemData` method.

In order to allow your users to remove their selection, you should emit a `removed` event, as shown above.

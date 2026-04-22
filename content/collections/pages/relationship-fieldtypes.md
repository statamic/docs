---
title: 'Relationship Fieldtypes'
template: page
updated_by: 42bb2659-2277-44da-a5ea-2f1eed146402
updated_at: 1569347303
intro: The Relationship fieldtype is one of the more powerful fields in Statamic's core. So powerful, in fact, that it earns its very own page in the docs. This is that page.
id: 06813e5d-158e-4318-aa4a-b29fd87d107f
---
By default, the relationship fieldtype lets you select entries from various collections as well as create and edit items on the fly from _within_ the field.

You can create your own relationship fields that provide the ability to select all different sorts of items from anywhere.

## Example

To illustrate that you can get items from anywhere — even remote APIs — we'll build a field where you can select GitHub repositories for a given user.

In your blueprints, you'll be able to use `type: repos` (whatever you name your fieldtype) and all the options that the relationship field would normally give you, like `max_items`:

``` yaml
fields:
  handle: repos
  field:
    type: repos
    max_items: 3
```

## Creating the Fieldtype

You will need to create the fieldtype – no Vue component necessary – so you can skip it with the <nobr>`--php`</nobr> flag:

``` shell
php please make:fieldtype Repos --php
```

Then instead of extending `Fieldtype`, you'll extend the existing `Relationship` fieldtype:

``` php
use Statamic\Fieldtypes\Relationship;

class Repos extends Relationship
{
    //
}
```

There are a handful of methods and properties inside the `Relationship` class, and you can override them to control how it functions.

There are three main areas you will want to customize. The index items, the selected item data, and the listing data.

## Index Items

The index items are what you'll see in the item selector stack.

You can either override the `getIndexQuery` method if you're dealing with items being retrieved through the Statamic API. You'll need to return a QueryBuilder.

``` php
public function getIndexQuery($request)
{
    return Entry::query()->whereIn('collection', $request->collections);
}
```

Or, you can override `getIndexItems` for full control. We'll use this for our GitHub example.

``` php
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

public function getIndexItems($request)
{
    $repos = Http::github()
        ->get("/users/{$this->config('username')}/repos")
        ->json();

    return $this->formatRepos($repos);
}

protected function formatRepos($repos)
{
    return collect($repos)->map(function ($repo) {
        $updated = Carbon::parse($repo['updated_at']);

        return [
            'id'               => $repo['id'],
            'name'             => $repo['name'],
            'description'      => $repo['description'],
            'stars'            => $repo['stargazers_count'],
            'updated'          => $updated->timestamp,
            'updated_relative' => $updated->diffForHumans(),
            'owner'            => $repo['owner']['login'],
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
        Column::make('name'),
        Column::make('description'),
        Column::make('stars'),
        Column::make('updated')->value('updated_relative'),
    ];
}
```

## Selected Item Data

Once you select items, their `id` values will be used as the value for your field. If you were to hit save, you would see
something like this in your content files:

``` yaml
repos:
  - 54376134
  - 89473529
```

In order to convert those values into something useful, you'll either need to override the `getItemData` method or the `toItemArray` method. For our example, we'll use the former:

``` php
public function getItemData($values)
{
    $repos = collect($values)->map(fn ($id) => Http::github()->get("/repositories/{$id}")->json());

    return $this->formatRepos($repos);
}
```

### Listing Data

When field data is to be displayed in a listing view (eg. in the entries listing table or the entry fieldtype), you may customize the display by overwriting the `preProcessIndex` method.

In our GitHub field, let's show only the repo names:

```php
public function preProcessIndex($data)
{
    return collect($data)
        ->map(fn ($id) => Http::github()->get("/repositories/{$id}")->json('name'))
        ->join(', ');
}
```

## Hints

Hints are short bits of secondary text shown next to selected items and dropdown options. They're useful when multiple items could share the same title and you need a way to disambiguate them — like an entry titled "About" that could exist in several collections.

Override the `getItemHint` method to return a string (or `null` for no hint):

``` php
public function getItemHint($item): ?string
{
    return $item['owner'];
}
```

The built-in `Entries` and `Terms` fieldtypes use this to show the collection or taxonomy title when more than one is configured.

## Creating Items

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
        ? $this->searchRepos($request->search)
        : $this->userRepos();
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
protected $itemComponent = 'GithubRepoRelationshipItem';
```

``` js
import GithubRepoRelationshipItem from './GithubRepoRelationshipItem.vue';

Statamic.$components.register('GithubRepoRelationshipItem', GithubRepoRelationshipItem);
```

``` vue
<script setup>
defineProps({
    item: Object,
});
</script>

<template>
    <div class="mb-1 item">
        <div class="item-move">&nbsp;</div>
        <div class="item-inner">
            <div class="p-3">
                <p class="mb-2 text-lg">{{ item.name }}</p>
                <p class="text-grey">{{ item.owner }} – ★ {{ item.stars }} –  {{ item.updated_relative }}</p>
            </div>
        </div>
        <dropdown-list class="pr-1">
            <ul class="dropdown-menu">
                <li class="warning"><a @click.prevent="$emit('removed')" v-text="__('Unlink')"></a></li>
            </ul>
        </dropdown-list>
    </div>
</template>
```

An `item` prop will be passed to your component which will contain one the objects provided by the `getItemData` method.

In order to allow your users to remove their selection, you should emit a `removed` event, as shown above.

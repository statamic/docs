---
id: d0668b6e-915b-46da-863e-51fec54b02e2
blueprint: page
title: Dictionaries
template: page
intro: 'Dictionaries add options to the [Dictionary](/fieldtypes/dictionary) fieldtype.'
---
## Overview

Dictionaries come in two "flavors" depending on which class you extend from.

With a `BasicDictionary`, you only really need to define the items. The options, searching, and GraphQL behavior is all handled automatically.

If you need more control, you can either override methods, or extend the base `Dictionary` class and do it yourself.

:::tip
You might not even need a custom dictionary. The native [File dictionary](/fieldtypes/dictionary#file) allows you simply provide a JSON, YAML, or CSV file to use a source of options.
:::


## Basic Dictionaries

You may create a dictionary using the following command, which will generate a class in the `App\Dictionaries` namespace.

```shell
php please make:dictionary
```

You may generate it into an addon using the `--addon=vendor/package` option, which will generate it into your addon's `Dictionaries` namespace.

```php
<?php

namespace App\Dictionaries;

use Statamic\Dictionaries\BasicDictionary;

class States extends BasicDictionary
{
    protected function getItems(): array
    {
        return [
            ['label' => 'Alabama', 'value' => 'AL', 'capital' => 'Montgomery'],
            ['label' => 'Alaska', 'value' => 'AK', 'capital' => 'Juneau'],
            ['label' => 'Arizona', 'value' => 'AZ', 'capital' => 'Phoenix'],
            // ...
        ];
    }
}
```

### Item data

In the example above, you can see that each item has a `label` and `value`. These will be used in the dropdown field. Any additional keys will be available within templates.

Here we are returning a hardcoded array. But in reality you may be getting options from somewhere like a file, database, or an API:

```php
protected function getItems(): array
{
    return Product::all()->toArray();
}
```


### Values and Labels

By default, the `value` and `label` keys will be used. However, you may remap them:

```php
protected function getItems(): array
{
    protected string $valueKey = 'abbr';
    protected string $labelKey = 'name';
    
    return [
        ['name' => 'Alabama', 'abbr' => 'AL', 'capital' => 'Montgomery'],
        // ...
    ];
}
```


If you require more logic, you can override the `getItemValue` and/or `getItemLabel` methods:

```php
protected function getItemLabel(array $item): string
{
    return $item['name'] . ' (' . $item['label'] . ')'; // "Alabama (AL)"
}
```

### Basic Search

By default, when a user searches the field, a basic search will be performed by checking against each item's values.

You may use the `searchable` property to narrow down which fields should be searched.

```php
protected array $searchable = ['name', 'abbr'];
```

Alternatively, you may customize how the match is performed by overriding the `matchesSearchQuery` method:

```php
protected function matchesSearchQuery(string $query, Item $item): bool
{
    return str_contains($item['name'], $query);
}
```

## Options

The `options` method controls what is selectable within the fieldtype. This method should return an array of value/label pairs.  

```php
public function options(?string $search = null): array
{
    return [
        'one' => 'Option One',
        'two' => 'Option Two',
    ];   
}
```

This array's keys define what will be stored in the content.

### Search

The `options` method will be passed a `$search` string if the user is searching within the fieldtype. You should filter your options based on this search term.

## Items

The `get` method accepts a value (one of the option's keys) and should return an `Item` instance.

An `Item` requires the value, label, and optionally an array of any additional data.

In the following example we assume a product ID was saved to the content, the product name is the label, and price/sku is extra.

```php
public function get(string $key): ?Item
{
    $product = Product::find($key);

    return new Item($key, $product->name, [
        'price' => $product->price,
        'sku' => $product->sku,
    ]);
}
```

## Config

You may define config fields in order for the user to customize functionality of your dictionary. For example, if you are providing products, you may want to allow the user to select a category to narrow down the options.

```php
protected function fieldItems()
{
    return [
        'category' => [
           'type' => 'select',
           'options' => ['clothing', 'accessories']
        ]
    ];
}
```

The user's configuration values will be available in your class within the `config` property.

```php
$this->config['category'];
```

## GraphQL

A dictionary will automatically get a GraphQL type named `Dictionary_YourClass`. Within it, you're able to query the item's fields, like so:

```graphql
your_dictionary_field {
  id
  price
}
```

By default, the base `Dictionary` class will provide the GraphQL schema for nested fields automatically. It does this by looking up the first item. You may wish to override this and provide your own schema.

```php
protected function getGqlFields(): array
{
    return [
        'id' => [
            'type' => GraphQL::nonNull(GraphQL::string()),
            'resolve' => fn (Item $item, $args, $context, $info) => $item['id'];
        ],
        'price' => [
            'type' => GraphQL::nonNull(GraphQL::int()),
            'resolve' => fn (Item $item, $args, $context, $info) => $item['price'];
        ],
        // ...
    ];
}
```

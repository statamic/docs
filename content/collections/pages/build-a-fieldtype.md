---
id: 83786f60-def6-11e9-aaef-0800200c9a66
blueprint: page
title: 'Build a Fieldtype'
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1568643872
intro: "Fieldtypes determine the user interface and storage format for your [fields](/fields). Statamic includes 40+ fieldtypes to help you tailor the perfect intuitive experience for your authors, but there's always room for _one more_."
---
## Prerequisites

Fieldtypes have a JavaScript component, so you will need to have a JavaScript entry file that gets loaded in the Control Panel. We recommend using [Vite](https://github.com/statamic/cms/pull/12533) for this.

Throw an `alert('It works!')` into your JS file. Once you see that appear in the browser, you're ready to build your fieldtype!  

## Registering

Once created (we'll get to that in a moment), a fieldtype will need to be registered.

Any fieldtype classes inside the `App\Fieldtypes` namespace will be automatically registered.

To store them elsewhere, manually register an action in a service provider by calling the static `register` method on your fieldtype's class.

``` php
public function boot()
{
    Your\Fieldtype::register();
}
```

## Creating

Fieldtypes have a PHP component and JS component. You can use a command to generate both pieces:

``` shell
php please make:fieldtype TogglePassword
```


## Vue component
The Vue component is responsible for the view and data binding. It's what your user will be interacting with.

The `make:fieldtype` command would have generated a Vue component into `resources/js/components/fieldtypes/TogglePassword.vue`.

You should register this Vue component within your JS entry file (`cp.js`):

``` js
import UppercaseFieldtype from './components/fieldtypes/Uppercase.vue';

Statamic.booting(() => {
    // Should be named [snake_case_handle]-fieldtype
    Statamic.$components.register('uppercase-fieldtype', UppercaseFieldtype);
});
```

Your component should use our `Fieldtype` composable for defining props & emits, updating the field value and accessing meta.

Other than that, your component can do whatever you like!

:::best-practice
**Do not** modify the `value` prop directly. Instead, call `update(value)` (or `updateDebounced(value)`) from the composable and let Statamic handle the update appropriately.
:::


### Example Vue component

For this example we will create an input field with a button to make the text uppercase:

<figure>
    <img src="/img/uppercase-fieldtype-example.gif" alt="An example fieldtype with a button to make the text uppercase" class="p-4 bg-white" width="477">
    <figcaption>Follow along and you could make this!</figcaption>
</figure>


``` vue
<script setup>
import { Fieldtype } from '@statamic/cms';
import { Input, Button } from '@statamic/cms/ui';

const emit = defineEmits(Fieldtype.emits);
const props = defineProps(Fieldtype.props);
const { expose, update } = Fieldtype.use(emit, props);
defineExpose(expose);

function makeItUppercase() {
    update(props.value.toUpperCase());
}
</script>

<template>
    <div>
        <Input :model-value="value" @update:model-value="update" />
        <Button @click="makeItUppercase">Make it upper case!</Button>
    </div>
</template>
```

#### What's happening?

1. The `Fieldtype` composable is providing the `emits` and `props` we need to define, as well as the `expose, update` and `updateDebounced` methods.
2. When you type into the text field, an `update` method is called which emits an event. Statamic listens to that event and updates the `value` prop.

Those are the two requirements satisfied. ✅

In addition to that, when the button is clicked, we're converting the string to uppercase and calling `update` in our function.

## PHP Class

The PHP class can be very barebones. At the most basic level, it just needs to exist in order to let Statamic know about it.

```php
<?php

namespace App\Fieldtypes;

use Statamic\Fields\Fieldtype;

class TogglePassword extends Fieldtype
{
    //
}
```

Of course, you may add functionality to it, outlined below.

## Fieldtype icon

You can use an existing SVG icon from Statamic's `resources/svg` directory by passing its name into an `$icon` class variable, by returning a full SVG as a string, or returning it as a string from the `icon()` method.

```php
<?php

class CustomFieldtype extends Fieldtype
{
    protected $icon = 'tags';
    // or
    protected $icon = '<svg> ... </svg>';
    // or
    function icon()
    {
        return file_get_contents(resource_path('svg/left_shark.svg'));
    }
}
```

## Fieldtype categories

When using the blueprint builder inside the control panel, your fieldtype will be listed under the `special` category by default. To move your fieldtype into a different category, define the `$categories` property on your class:

```php
<?php

class CustomFieldtype extends Fieldtype
{
    public $categories = ['number'];
}
```

You can select from any of the keys available in the `FieldtypeSelector`:
- `text`
- `controls`
- `media`
- `number`
- `relationship`
- `structured`
- `special`


## Fieldtype keywords

You may specify keywords to be used when searching in the fieldtype selector.

For example: if you search for "rich text" or "gutenberg", the [Bard fieldtype](/fieldtypes/bard) will be returned as a result.

```php
<?php

class CustomFieldtype extends Fieldtype
{
    protected $keywords = ['file', 'files', 'image', 'images', 'video', 'videos', 'audio', 'upload'];
}
```

## Configuration fields

You can make your fieldtype configurable with configuration fields. These fields are defined by adding a `configFieldItems()` method on your PHP class that returns an array of fields.

``` php
protected function configFieldItems(): array
{
    return [
        'mode' => [
            'display' => 'Mode',
            'instructions' => 'Choose which mode you want to use',
            'type' => 'select',
            'default' => 'regular',
            'options' => [
                'regular' => __('Regular'),
                'enhanced' => __('Enhanced'),
            ],
            'width' => 50
        ],
        'secret_agent_features' => [
            'display' => 'Enable super secret agent features',
            'instructions' => 'Can you even handle these features?',
            'type' => 'toggle',
            'default' => false,
            'width' => 50
        ],
    ];
}
```

The configuration values can be accessed in the Vue component using the `config` property.

``` js
return this.config.mode; // regular
```

### Options

| Key | Definition |
|---|---|
| **display** | The field's display label |
| **instructions** | Text shown underneath the display label. Supports Markdown. |
| **type** | Name of the fieldtype used to manage the config option. |
| **default** | An optional default value. |
| **width** | The field's width. |
| ***other*** | Some fieldtypes have additional configuration options available. |

:::tip
A little code diving will reveal all the possible config options for each field type. Look for the `configFieldItems()` method in each class here: <https://github.com/statamic/cms/tree/6.x/src/Fieldtypes>
:::

### Adding configuration fields to existing fieldtypes

Sometimes you may want to add a config field to another fieldtype rather than creating a completely new one.

You can do this using the `appendConfigField` or `appendConfigFields` methods on the respective fieldtype.

```php
use Statamic\Fieldtypes\Text;

// One field...
Text::appendConfigField('group', [
  'type' => 'text',
  'display' => 'Group',
]);

// Multiple fields...
Text::appendConfigFields([
  'group' => ['type' => 'text', 'display' => '...',],
  'another' => ['type' => 'text', 'display' => '...',],
]);
```

You can also append a config field to _all_ fieldtypes via the `Fieldtype` class:

```php
use Statamic\Fields\Fieldtype;

Fieldtype::appendConfigField('group', [
    'type' => 'text',
    'display' => 'A new group',
]);
```

## Processing

You may need to modify the data going to and from the browser.

The `preProcess` method allows you to modify the original value into what the Vue component requires.
The `process` method does the opposite. It takes the Vue component's value and allows you to modify it for what gets saved.

For example, the YAML fieldtype stores its value in content as an array but the field needs it as a string in order for it to be editable:

```php
public function preProcess($value)
{
    return YAML::dump($value); // dump a yaml string from an array
}
```

In the other direction, it takes the YAML string and needs to convert it back to an array when saving:

```php
public function process($value)
{
    return YAML::parse($value); // parses a yaml string into an array
}
```

_(These snippets are simplified for example purposes.)_

## Meta Data

Fieldtypes can preload additional "meta" data from PHP into JavaScript. This can be anything you want, from settings to eager loaded data.

``` php
public function preload()
{
    return ['foo' => 'bar'];
}
```

This can be accessed in the Vue component using the `meta` prop.

``` js
return props.meta; // { foo: bar }
```

If you have a need to update this meta data on the _JavaScript side_, use the `updateMeta` method. This will persist the value back to Vuex store and communicate the update to the appropriate places.

``` js
const props = defineProps(Fieldtype.props);
const { updateMeta } = Fieldtype.use(emit, props);

updateMeta({ foo: 'baz' });
props.meta; // { foo: 'baz' }
```

### Example use cases -

Here are some reasons why you might want to use this feature:

- The assets and relationship fieldtypes only store IDs, so they will fetch item data using AJAX requests. If you have many of these fields in one form, you'd have a bunch of AJAX requests fire off when the page loads. Preload the item data to avoid the initial AJAX requests.
- Grid, Bard, and Replicator fields all preload values for what a new row/set contains, plus the recursive meta values of any nested fields.


## Replicator preview

When [Replicator](/fieldtypes/replicator) (or [Bard](/fieldtypes/bard)) sets are collapsed, Statamic will display a preview of the values within it.

By default, Statamic will do its best to display your fields value. However, if you have a value more complex than a simple string or array, you may want to customize it.

You may customize the preview text by calling `defineReplicatorPreview` from your Vue component. For example:

``` js
const { defineReplicatorPreview } = Fieldtype.use(emit, props);

defineReplicatorPreview(() => props.value.join('+'));
```

:::tip
This _does_ support returning an HTML string so you could display image tags for a thumbnail, etc. Just be aware of the limited space.
:::

## Index fieldtypes

In listings (collection indexes in the Control Panel, for example), string values will be displayed as a truncated string and arrays will be displayed as JSON.

You can adjust the value before it gets sent to the listing with the `preProcessIndex` method:

``` php
public function preProcessIndex($value)
{
    return str_repeat('*', strlen($value));
}
```

If you need extra control or functionality, fieldtypes may have an additional "index" Vue component.


``` js
import UppercaseIndexFieldtype from './UppercaseIndexFieldtype.vue';

// Should be named [snake_case_handle]-fieldtype-index
Statamic.$components.register('toggle_password-fieldtype-index', UppercaseIndexFieldtype);
```

``` vue
<script setup>
import { IndexFieldtype } from '@statamic/cms';

const props = defineProps(IndexFieldtype.props);

const numberOfUppercaseCharacters = computed(() => {
    return [...props.value].filter(char => char >= 'A' && char <= 'Z').length;
});
</script>

<template>
    <div>String contains {{ numberOfUppercaseCharacters }} uppercase characters.</div>
</template>
```

The `IndexFieldtype` composable will provide you with a `value` prop so you can display it however you'd like. Continuing our example above, we will calculate how many characters of the given string are uppercase.

## Augmentation

By default, a fieldtype will not perform any augmentation. It will just return the value as-is.

You can customize how it gets augmented with an augment method:

``` php
public function augment($value)
{
    return strtoupper($value);
}
```

[Read more about augmentation](/extending/augmentation)

## Accessing other fields

If you find yourself needing to access other form field values, configs, etc., you can reach into the publish form store from within your Vue component: 

```js
import { injectPublishContext } from '@statamic/ui';
const { values } = injectPublishContext();

// Do what you need to with values
console.log(values.value.title)
```
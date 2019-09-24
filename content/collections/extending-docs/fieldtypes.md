---
title: Fieldtypes
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1568643872
id: 83786f60-def6-11e9-aaef-0800200c9a66
intro: Fieldtypes determine the user interface and storage format for your [fields](/fields). Statamic includes 40+ fieldtypes to help you tailor the perfect intuitive experience for your authors.
---

## Registering a Fieldtype

Any fieldtype classes that exist in the `App\Fieldtypes` namespace will be automatically registered.

If you would like to store them elsewhere, you can manually register an action in a service provider by calling the static `register` method on your action class.

``` php
public function boot()
{
    Your\Fieldtype::register();
}
```

## Creating a fieldtype

Fieldtypes are comprised of two pieces:

  - A PHP class that handles things like data processing and validation
  - A Vue component that handles the view

For this example, we will create a typical password field with a "show" toggle option:

![](https://docs.statamic.com/assets/examples/password-fieldtype.gif)

Create a fieldtype PHP class and Vue component by running the following command:

``` bash
php please make:fieldtype TogglePassword
```

``` php
<?php

class TogglePassword extends \Statamic\Fields\Fieldtype
{
    //
}
```

Create a Vue component in [one of your loaded javascript files](/guide/extending/addons.html#assets-css-stylesheets-and-javascript) and register it as `[handle]-fieldtype`.

In order for a fieldtype component to work, it needs to do two things:
- Expect a `value` prop.
- Emit an `input` event whenever you want your fieldtype's value to be reflected in the form.

Since these two core tasks will be done by every fieldtype, Statamic provides you with a `Fieldtype` mixin to reduce boilerplate code in your component.

``` js
import Fieldtype from './TogglePasswordFieldtype.vue';

// Should be named [snake_case_handle]-fieldtype
Statamic.$components.register('toggle_password-fieldtype', Fieldtype);
```

``` vue
<template>
    <div>
        <text-input :type="inputType" :value="value" @input="update">
        <label><input type="checkbox" v-model="show" /> Show Password</label>
    </div>
</template>

<script>
export default {
    mixins: [Fieldtype],
    data() {
        return {
            show: false
        };
    },
    computed: {
        inputType() {
            return this.show ? 'text' : 'password';
        }
    }
};
</script>
```

What's happening here is:
- The `Fieldtype` mixin is providing an `value` prop containing the initial value of the field.
- The `text-input` component emits an `input` event whenever you type into it. Our component is listening for that event and calls the `update` method.
- The `Fieldtype` mixin is providing that `update` method. All it's doing is emitting the required `input` event. This is how the parent component is detecting changes in your fieldtype.

You should **not** modify the `value` prop directly. Be sure to call `this.update(value)` instead so that the Vuex store is updated appropriately.

### Meta Data

Fieldtypes can preload additional "meta" data from PHP into JavaScript. This can be anything you want, from settings to eager loaded data.

``` php
public function preload()
{
    return ['foo' => 'bar'];
}
```

This can be accessed in the Vue component using the `meta` property.

``` js
return this.meta; // { foo: bar }
```

If you have a need to update this meta data on the JavaScript side, rather than updating the prop, you should use the `updateMeta` method. This will persist the value back to Vuex store and communicate the update to the appropriate places.

``` js
this.updateMeta({ foo: 'baz' });
this.meta; // { foo: 'baz' }
```

Some use cases - to illustrate how or why you might want to use this feature:

- The assets and relationship fieldtypes only store IDs, so they will fetch item data using AJAX requests. If you have many of these fields in one form, you'd have a bunch of AJAX requests fire off when the page loads.
  To get around this, the fieldtypes will preload the item data to avoid the initial AJAX requests.
- Grid, Bard, and Replicator fields all preload values for what a new row/set contains, plus the recursive meta values of any nested fields.

## Index Fieldtypes

In listings, fieldtype values will be displayed as a truncated string by default. Arrays will be displayed as JSON.

You may want to adjust the value before it gets sent to the listing. You can do this with the `preProcessIndex` method:

``` php
public function preProcessIndex($value)
{
    return str_repeat('*', strlen($value));
}
```

If you need extra control over the HTML (or even functionality), fieldtypes may have an additional "index" Vue component.


``` js
import Fieldtype from './TogglePasswordIndexFieldtype.vue';

// Should be named [snake_case_handle]-fieldtype-index
Statamic.$components.register('toggle_password-fieldtype-index', Fieldtype);
```

``` vue
<template>
    <div v-html="bullets" />
</template>

<script>
export default {
    mixins: [IndexFieldtype],
    computed: {
        bullets() {
            return '&bull;'.repeat(this.value.length);
        }
    }
}
</script>
```

The `IndexFieldtype` mixin will provide you with a `value` prop allowing you to display it however you want. Continuing our example above, we will simply output the value replaced by bullets.


## Updating a v2 fieldtype to v3

In v2, we pass a `data` prop that you can modify directly. You might be doing something like this:

``` html
<input type="text" v-model="data" />
```

You should now pass the value _down_ in a prop (it's now `value`), and pass the modified value _up_ by emitting an `input` event.

``` html
<!-- Using a standard HTML input field: -->
<input type="text" :value="value" @input="$emit('input', $event.target.value)">

<!-- Using the "Fieldtype" mixin's `update` method to emit the event for you: -->
<input type="text" :value="value" @input="update($event.target.value)">

<!-- Using a Statamic input component to clean it up even further: -->
<text-input :value="value" @input="update">
```

An alternate solution could be to add a `data` property, initialize it from the new `value` prop, then emit the event whenever the `data` changes. This way, you won't have to modify your template or the rest of your JS logic. You can just continue to modify `data`.

``` vue
<template>
    <input type="text" v-model="data" />
</template>
<script>
export default {
    mixins: [Fieldtype],
    data() {
        return {
            data: this.value,
        }
    },
    watch: {
        data(data) {
            this.update(data);
        }
    }
}
</script>
```

The PHP file should require no changes.

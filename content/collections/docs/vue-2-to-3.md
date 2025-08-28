---
id: c3553d05-d1a8-453a-a59b-7e67dd2412a4
blueprint: page
title: 'Upgrade from Vue 2 to Vue 3'
intro: 'A guide for upgrading Vue 2 to 3.'
template: page
---
## Overview

As part of the Statamic 6 release, Vue was upgraded to version 3. 


## Vite

`package.json`:

```json
{
    "scripts": {
        "dev": "vite", // [tl! --]
        "dev": "vite build --watch", // [tl! ++]
        "build": "vite build"
    },
    "devDependencies": {
        "@vitejs/plugin-vue2": "^6.0.1", // [tl! --]
        "@statamic/cms": "file:./vendor/statamic/cms/resources/js/package" // [tl! ++]
    }
}
```

`vite.config.js`:

```js
import vue from '@vitejs/plugin-vue2'; // [tl! --]
import laravel from 'laravel-vite-plugin';
import statamic from '@statamic/cms/vite-plugin'; // [tl! ++]
import { defineConfig } from 'vite';

export default defineConfig({
    plugins: [
        statamic(), // [tl! ++]
        laravel({
            refresh: true,
            input: ['resources/js/cp.js']
        }),
    ],
});
```

## Laravel Mix

If you are still using Laravel Mix, you will need to switch to Vite.

## Composition API

Converting your components to the Composition API **is not required**.

However, since it is now supported, you might love it. We recommend it. It could greatly clean up your components. Check out this example component written using the Options API:

```vue
<script>
import { FooComponent, BarComponent } from './components';
import { Button, Card } from '@statamic/cms/ui';

export default {
    components: {
        FooComponent,
        BarComponent,
        Button,
        Card
    },
    data() {
        return {
            firstName: 'John',
            lastName: 'Smith',
        }   
    },
    computed: {
        fullName() {
            return `${this.firstName} ${this.lastName}`;
        }  
    },
    methods: {
        changeName(first, last) {
            this.firstName = first;
            this.lastName = last;
        }
    },
    watch: {
        fullName(newName) {
            console.log(`Name changed to ${newName}`);
        }
    }
}
</script>
```

And now converted to the Composition API:

```vue
<script setup>
import { FooComponent, BarComponent } from './components';
import { Button, Card } from '@statamic/cms/ui';
import { ref, computed, watch } from 'vue';

const firstName = ref('John');
const lastName = ref('Smith');
const fullName = computed(() => `${firstName.value} ${lastName.value}`);

function changeName(first, last) {
    firstName.value = first;
    lastName.value = last;
}

watch(fullName, (newName) => console.log(`Name changed to ${newName}`));
</script>
```

## Imports

You should be importing components and other files from `@statamic/cms`. You may have been previously importing explicit files straight from the vendor directory. This is not supported.

```js
import Something from '../../../vendor/statamic/cms/resources/js/Something.vue'; // [tl! --]
import { Something } from '@statamic/cms'; // [tl! ++]
```


## Fieldtypes

### Mixins

Mixins will now need to be explicitly imported. Assuming you've updated `vite.config.js` explained above, you should be able to add the following to your fieldtype:

```js
import { FieldtypeMixin as Fieldtype } from '@statamic/cms'; // [tl! ++]

export default {
    mixins: [Fieldtype],
    data() {
        return {
            //
        }
    }
}
```

### Events

If you are manually emitting an `input` event from within a fieldtype, you should change it to `update:value`.

```js
this.$emit('input', foo); // [tl! --]
this.$emit('update:value', foo); // [tl! ++]
```

::: tip
You should be using `this.update()` if possible anyway.

```js
this.$emit('input', foo); // [tl! --]
this.update(foo); // [tl! ++]
```
:::



## Props, events, and v-model

Vue 3 changes how v-model works.


### Fieldtypes
To avoid needing to change all references to the `value` prop, we've kept the prop as-is. If you are using `v-model` directly on a fieldtype component, you will need to specify `:value` now.

Note that this is only if you are _using a fieldtype component_ from within another component.

```vue
<my-fieldtype
    v-model="foo" <!-- [tl! --] -->
    v-model:value="foo" <!-- [tl! ++] -->
/>
```

### Components that no longer support v-model

If you were using `v-model`, you must change to the appropriate prop and event:

```vue
<my-component
    v-model="foo" <!--[tl! --]-->
    :value="foo"  <!--[tl! ++]-->
    @input="foo = $event" <!--[tl! ++]-->
/>
```

| Component               | Prop      | Event       |
|-------------------------|-----------|-------------|
| `<slugify>`             | `to`     | `@slugified` |
| `<publish-container>`   | `values` | `@updated`  |

### Components that support v-model
If you were *not* using `v-model` and instead using the `value` prop and `input` event, you will need to change to `model-value` and `@update:model-value`.

```vue
<component
  :value="foo" <!--[tl! --]-->
  @input="foo = $event" <!--[tl! --]-->
  :model-value="foo" <!--[tl! ++]-->
  @update:model-value="foo = $event" <!--[tl! ++]-->
/>
```

| Component      | Notes                                |
|----------------|--------------------------------------|
| `<form-group>` |                                      |
| `<v-select>`   | This is from the vue-select package. |

## Slots

The slot syntax changed. If you were previously using `slot-scope`, you should change to `v-slot`:

Default slot:

```html
<component><!-- [tl! --:start] -->
    <div slot-scope="{ ... }"></div>
</component><!-- [tl! --:end] -->
<component v-slot="{ ... }"><!-- [tl! ++:start] -->
    <div></div>
</component><!-- [tl! ++:end] -->
```

Named slots:

```html
<component>
    <template slot="something" slot-scope="{ ... }"></template><!-- [tl! --] -->
    <template v-slot:something="{ ... }"></template><!-- [tl! ++] -->
</component>
```

You can also use the shorthand:

```html
<template v-slot:something="{ ... }"><!-- [tl! --] -->
<template #something="{ ... }"><!-- [tl! ++] -->
```

## Bard

Since the `$on`, `$off`, and `$once` methods have been removed from Vue 3, Bard events need to work differently. They have been moved into an event bus on the bard component.

You might be using these methods if you have a custom Bard toolbar button (via `this.bard`) or Prosemirror mark/node element (via `vm`).

```js
bard.$on(...); // [tl! --]
bard.$off(...); // [tl! --]
bard.$once(...); // [tl! --]
bard.events.on(...); // [tl! ++]
bard.events.off(...); // [tl! ++]
bard.events.once(...); // [tl! ++]
```

## Components

Components should be registered using the `$components` API rather than directly through `Statamic`:

```js
Statamic.component('my-fieldtype', MyFieldtype); // [tl! --]
Statamic.$components.register('my-fieldtype', MyFieldtype); // [tl! ++]
```

## Vuex to Pinia

### Publish Components
The primary reason for Statamic including Vuex at all was for the Publish components. These no longer use Vuex (or Pinia). If you were using `$store` in your code it's probably for those.

```js
import { publishContextKey } from '@statamic/cms/ui'; // [tl! ++]

export default {
    inject: [ // [tl! --:start]
        'storeName',
    ],// [tl! --:end]
    inject: { // [tl! ++:start]
        publishContext: { from: publishContextKey },
    },// [tl! ++:end]
    methods: {
        getValue(handle) {
            return this.$store.state.publish[this.storeName].values[handle]; // [tl! --]
            return this.publishContext.values.value[handle]; // values is a ref() so you need .value to unwrap it. [tl! ++]
        },
        setValue(handle, newValue) {
            this.$store.dispatch(`publish/${this.storeName}/setFieldValue`), newValue); // [tl! --]
            this.publishContext.setFieldValue(newValue); // [tl! ++]
        }
    }
}
```

The most common place for the store to be accessed like this is in a fieldtype, so they automatically get the publish context injected as `injectedPublishContainer` and have all the refs unwrapped as `publishContainer`.

```js
export default {
    mixins: [Fieldtype],
    inject: [ // [tl! --:start]
        'storeName',
    ],// [tl! --:end]
    methods: {
        getValue(handle) {
            return this.$store.state.publish[this.storeName].values[handle]; // [tl! --]
            return this.publishContainer.values[handle]; // [tl! ++]
        },
        setValue(handle, newValue) {
            this.$store.dispatch(`publish/${this.storeName}/setFieldValue`), newValue); // [tl! --]
            this.publishContainer.setFieldValue(newValue); // [tl! ++]
        }
    }
}
````

### Custom Stores
If you _were_ adding your own Vuex stores, you should switch to Pinia. Rather than registering to a global Vuex store, you define your own store and use it directly in your components.

Use the provided `$pinia` helper rather than trying to import from your own version of Pinia.

```js
// In bootstrapping... [tl! --:start]
Statamic.$store.registerModule(['publish', 'myStore'], {
    state: { foo: 'bar' },
    mutations: {
        doSomething(payload) {
            //
        }
    },
    actions: {
        doSomething(context, payload) {
            context.commit('doSomething', payload);
        }
    }
}); 

// In component...
const foo = this.$store.state.publish.myStore.foo;
this.$store.dispatch('publish/myStore/doSomething', 'example'); // [tl! --:end]


// mystore.js... [tl! ++:start]
const useMyStore = Statamic.$pinia.defineStore('myStore', {
    state: { foo: 'bar' },
    actions: {
        doSomething() {
            //
        }
    }
});

// In component...
import { useMyStore } from './mystore';
const store = useMyStore();
const foo = store.foo;
store.doSomething('example'); // [tl! ++:end]
```

## Bard Tiptap API

Previously you would be able to access Tiptap components directly through the Bard API. They will now be provided to you when using the various callbacks. For example:

```js
const { Node, Mark, Extension } = Statamic.$bard.tiptap.core; // [tl! --:start]

Statamic.$bard.addExtension(() => {
    return [
        Node.create({...}),
        Mark.create({...}),
        Extension.create({...}),
    ]
}) // [tl! --:end]

Statamic.$bard.addExtension(({ tiptap }) => { // [tl! ++:start]
    const { Node, Mark, Extension } = tiptap.core;
    
    return [
        Node.create({...}),
        Mark.create({...}),
        Extension.create({...}),
    ]
}) // [tl! ++:end]
```

If you were importing/exporting the component, you should change to a "factory" function that accepts the Tiptap API and returns the component. For example:

```js
import TextColor from './TextColor.js'; // [tl! --:start]
Statamic.$bard.addExtension(() => TextColor);

// TextColor.js
const { Mark } = Statamic.$bard.tiptap.core;
export default Mark.create({}); // [tl! --:end]

import TextColor from './TextColor.js'; // [tl! ++:start]
Statamic.$bard.addExtension(({ tiptap }) => TextColor(tiptap));

// TextColor.js
export default function (tiptap) {
    const { Mark } = tiptap.core;
    return Mark.create({});
} // [tl! ++:end]
```

## Component Substitutions

With the introduction of the [UI component library](/ui-components), a number of components have been replaced by more modern versions.

### Publish

If you were building a custom publish form using `publish-*` components, they have been replaced by newer equivalents through the UI component library.

You would have previously needed to set up "prop- and event-ception". Now the `PublishContainer` becomes the source of truth and you can define the child components as needed (or not!). 

Before:

```html
<publish-container
    :blueprint="blueprint"
    :values="values"
    :meta="meta"
    :errors="errors"
    @updated="values = $event"
    v-slot="{ setFieldValue, setFieldMeta }"
>
    <publish-tabs
        @updated="setFieldValue"
        @meta-updated="setFieldMeta"
    />
</publish-container>
```

After:

```vue
<script>
import { PublishContainer } from '@statamic/cms/ui';
</script>
<template>
    <PublishContainer
        :blueprint="blueprint"
        :meta="meta"
        :errors="errors"
        v-model="values"
    />
</template>
```

View the [Publish component docs page](/ui-components/publish) for more details.


### Listing

If you were building custom listings using the `data-list` components, they have been replaced by newer equivalents.

Before, you probably grabbed our listing mixin, added the necessary properties to make it work, and added a bunch of components to your template, each of them with a bunch of props.

```vue
<script>
import Listing from '../../../../vendor/statamic/cms/resources/js/components/Listing.vue';

export default {
    mixins: [Listing],
    data() {
        return {
            requestUrl: '/cp/my-listing-url',
        }
    }
}
</script>
<template>
    <data-list
      :rows="items"
      :columns="columns"
      :sort="false"
      :sort-column="sortColumn"
      :sort-direction="sortDirection"
      v-slot="{ hasSelections }"
    >
        <data-list-filter-presets ... />
        <data-list-search ... />
        <data-list-filters ... />
        <data-list-bulk-actions ... />
        <data-list-table>
            <template slot="cell-title" slot-scope="{ row }">...</template>
            <template slot="cell-another" slot-scope="{ row }">...</template>
            <template slot="actions" slot-scope="{ row }">...</template>
        </data-list-table>
        <data-list-pagination ... />
    </data-list>
</template>
```

After, you can use the new `Listing` component, pass in a URL, some props, and not worry about any nested components. The layout will figure itself out. 

```vue
<script>
import { Listing } from '@statamic/cms/ui';

export default {
    data() {
        return {
            requestUrl: '/cp/my-listing-url',
        }
    }
}
</script>
<template>
    <Listing
        :url="requestUrl"
        :columns="columns"
        :filters="filters"
        :action-url="actionUrl"
    >
        <template #cell-title="{ row }">...</template>
        <template #cell-another="{ row }">...</template>
        <template #prepended-row-actions="{ row }"></template>
    </Listing>
</template>
```

View the [Listing component docs page](/ui-components/listing) for more details.



### Dropdown List

The `dropdown-list` component has been replaced by the `Dropdown` UI component.

```html
<dropdown-list>
    <template v-slot:trigger>
        <button>Click me</button>
    </template>
    <dropdown-item redirect="/somewhere">Text</dropdown-item>
</dropdown-list>
```

```vue
<script>
import { Dropdown, DropdownMenu, DropdownItem } from '@statamic/cms';
</script>
<template>
    <Dropdown>
        <template #trigger>
            <button>Click me</button>
        </template>
        <DropdownMenu>
            <DropdownItem href="/somewhere" text="Text" />
        </DropdownMenu>
    </Dropdown>
</template>
```

You can also forgo the imports and just use `ui-dropdown`, `ui-dropdown-menu`, and `ui-dropdown-item` respectively.

### Inputs

Input components such as `<text-input>`, `<textarea-input>`, `<select-input>`, and `<toggle-input>` have been removed in favor of [Input](/ui-components/input), [Textarea](/ui-components/textarea), [Combobox](/ui-components/combobox), [Switch](/ui-components/switch) UI components respectively. 

```vue
<script>
import { Input, Textarea, Combobox, Switch } from '@statamic/cms/ui'; // [tl! ++]
</script>
<template>
    <text-input v-model="textValue" /> <!-- [tl! --] -->
    <textarea-input v-model="textValue" /> <!-- [tl! --] -->
    <select-input v-model="textValue" /> <!-- [tl! --] -->
    <toggle-input v-model="textValue" /> <!-- [tl! --] -->
    <Input v-model="textValue" /> <!-- [tl! ++] -->
    <Textarea v-model="textareaValue" /> <!-- [tl! ++] -->
    <Combobox v-model="comboboxValue" /> <!-- [tl! ++] -->
    <Switch v-model="switchValue" /> <!-- [tl! ++] -->
</template>
```

## Vue Devtools

Vue Devtools is no longer automatically enabled during local development. To use it, you'll need to use our opt-in dev build.

Your app must have debug mode enabled:
```env
APP_DEBUG=true
```

The dev build must be either published or symlinked:
```bash
# Published
php artisan vendor:publish --tag=statamic-cp-dev

# Symlinked
ln -s /path/to/vendor/statamic/cms/resources/dist-dev public/vendor/statamic/cp-dev
```

You shouldn't commit this to your repo or use this in production.

## Removals

A number of items have been removed. If you feel they shouldn't have been removed, please contact us and we can evaluate bringing them back.

- We had a `String.includes()` polyfill that has been removed since it's widely supported now.
- Underscore.js mixins `objMap`, `objFilter`, and `objReject` have been removed.
- `resource_url` and `file_icon` methods are no longer available in Vue templates but are still available as global functions.
- The deprecated `$slugify` function has been removed in favor of the `$slug` API.
- The `v-focus` directive has been removed.
- The `store`/`storeName` are no longer included field action payloads. 
- The `vue-select` package has been removed. If you're using `<v-select>` you should change to the [Combobox UI component](/ui-components/combobox).

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

```shell
npm remove @vitejs/plugin-vue2
npm install -D @vitejs/plugin-vue
npm install -D vite-plugin-externals
```

```js
import path from 'path'; // [tl! ++]
import laravel from 'laravel-vite-plugin'
import { defineConfig, loadEnv } from 'vite'
import vue from '@vitejs/plugin-vue2'; // [tl! --]
import vue from '@vitejs/plugin-vue'; // [tl! ++]
import { viteExternalsPlugin } from 'vite-plugin-externals' // [tl! ++]

export default defineConfig(({ command, mode }) => {
    const env = loadEnv(mode, process.cwd(), '');
    return {
        plugins: [
            laravel({
                refresh: true,
                input: ['resources/js/cp.js']
            }),
            vue(),
            viteExternalsPlugin({vue: 'Vue', pinia: 'Pinia'}) // [tl! ++] 
        ],
        resolve: { // [tl! ++:start]
            alias: {
                'statamic': path.resolve(__dirname, './vendor/statamic/cms/resources/js/exports.js'),
            },
        } // [tl! ++:end]
    }
});
```

## Fieldtypes

### Mixins

Mixins will now need to be explicitly imported. Assuming you've added `resolve.alias.statamic` to your `vite.config.js` explained above, you should be able to add the following to your fieldtype:

```js
import { Fieldtype } from 'statamic'; // [tl! ++]

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

Tip: you should try to instead use `this.update()`.

```js
this.$emit('input', foo); // [tl! --]
this.update(foo); // [tl! ++]
```



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


## Dropdown List

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

## Fieldtypes

Components should be registered using the `$components` API rather than directly through `Statamic`:

```js
Statamic.component('my-fieldtype', MyFieldtype); // [tl! --]
Statamic.$component.register('my-fieldtype', MyFieldtype); // [tl! ++]
```

## Vuex to Pinia

Vuex has been removed in favor of Pinia. The `store` itself will now be provided to components.

```js
{
    inject: [
        'storeName', // [tl! --]
        'store', // [tl! ++]
    ],
    methods: {
        myMethod() {
            const values = this.$store.state.publish[this.storeName].values; // [tl! --]
            const values = this.store.values; // [tl! ++]
        }
    }
}
```

If you were dispatching actions or committing mutations, you will now call methods on the `store` directly.

```js
this.$store.dispatch(`publish/${this.storeName}/doSomething`), arg); // [tl! --]
this.store.doSomething(arg); // [tl! ++]


this.$store.commit(`publish/${this.storeName}/doSomething`), arg); // [tl! --]
this.store.doSomething(arg); // [tl! ++]
```

If you were adding your own Vue stores, you should switch to Pinia. Rather than registering to a global Vuex store, you define your own store and use it directly in your components.

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
import { defineStore } from 'pinia'; 
const useMyStore = defineStore('myStore', {
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

### Field actions

Similarly, field actions were previously provided with the Vuex store through the `store` property. Now it will be an instance of the Pinia store itself.

```js
Statamic.$fieldActions.add('text-fieldtype', {
    title: 'Example',
    run: ({ store, storeName }) => {
        const values = store.state.publish[storeName].values; // [tl! --]
        const values = store.values; // [tl! ++]
    }
})
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

## Removals

A number of items have been removed. If you feel they shouldn't have been removed, please contact us and we can evaluate bringing them back.

- We had a `String.includes()` polyfill that has been removed since it's widely supported now.
- Underscore.js mixins `objMap`, `objFilter`, and `objReject` have been removed.
- `resource_url` and `file_icon` methods are no longer available in Vue templates but are still available as global functions.
- The deprecated `$slugify` function has been removed in favor of the `$slug` API.
- The `v-focus` directive has been removed.

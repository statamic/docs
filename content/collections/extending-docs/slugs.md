---
title: Slugs
stage: 1
id: d84613d5-2b2b-465d-8f02-c71b6d2aadf1
---
## Slugify Vue Component

You can use the `<slugify>` component to generate a slug based off another property:

``` html
<slugify :from="title" v-model="slug">
    <input slot-scope="{}" :value="slug" @input="slug = $event.target.value" />
</slugify>
```

When the value of the `from` prop changes (i.e. the `title` property), it will update the `slug` property.

If you update the slug manually (i.e. by typing in the field), the component will realize, and prevent any further automatic slug generation.

If you want underscores instead of dashes, you can pass in `separator="_"`.


## JavaScript API

### Basic Slugs
You may also create slugs programmatically.

```js
Statamic.$slug.create('Hello World'); // hello-world
```

You may also define the separating character:

```js
Statamic.$slug.separatedBy('_').create('Hello World'); // hello_world
```

You may use the `str_slug` and `snake_case` global methods respectively as aliases for both of these:

```js
str_slug('Hello World'); // hello-world
snake_case('Hello World'); // hello_world
```

:::tip
When you're within a Vue component, you may use `this.$slug` instead of `Statamic.$slug`.
:::

### More Oomph

When you need more accurate slugs, you can leverage PHP's more powerful slug logic. By calling `async`, the `create` method will become Promise-based as it requests slugs from the server:

```js
Statamic.$slug.async().create('Hello World').then(slug => {
    console.log(slug); // 'hello-world'
})
```

This is particularly useful when you need to provide the language:

```js
Statamic.$slug.in('zh').async().separatedBy('_')
        .create('你好世界')
        .then(slug => console.log(slug)); // ni_hao_shi_jie
```

:::tip
If you don't provide a language, the language of the selected site in the control panel will be used.
:::

### Debouncing

If you will be calling this repeatedly, such as via user's keystrokes, debouncing is useful to prevent excess calls to the server.

Debouncing will be automatically handled as long as you call `create` on the same instance:

```js
const slugger = Statamic.$slug.async().separatedBy('_');

slugger.create('one').then(slug => console.log(slug));
slugger.create('two').then(slug => console.log(slug));
slugger.create('three').then(slug => console.log(slug));

// console: 'three'
```

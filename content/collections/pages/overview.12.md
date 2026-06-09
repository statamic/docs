---
id: b80820bb-c2e8-475f-98bd-8ea0ef9f5339
blueprint: page
title: 'Vue Components Overview'
overview: "Here's how you can add your own Vue 3 components to the Statamic Control\_Panel."
nav_title: Overview
---
## Registering Components

In order to use a custom Vue component, it needs to be registered. You should do this inside the `Statamic.booting()` callback.

Once registered, you (or Statamic) will be able to use the component.

``` vue
<script setup>
defineProps(['hello']);
</script>

<template>
    <div>...</div>
</template>
```

``` js
import MyComponent from './Components/MyComponent.vue';

Statamic.booting(() => {
    Statamic.$components.register('my-component', MyComponent);
});
```

## Appending Components

Registered components may also be appended to the end of the page at any point.

``` js
const component = Statamic.$components.append('publish-confirmation', {
    props: { foo: 'bar' }
});
```

This will return an object _representing_ the component. On this object, you have access to a number of methods to interact with the Vue component.

### Updating props

``` js
component.prop('prop-name', newValue);
```

### Adding event listeners

It works just like Vue's `$on` method:

``` js
// inside component
this.$emit('event-name', { foo: 'bar' });
```

``` js
component.on('event-name', (payload) => {
    console.log(payload); // { foo: 'bar' }
});
```

### Destroying the component

```js
component.destroy();
```
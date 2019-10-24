---
title: 'Publish Components'
id: e2577828-504b-490b-a8b6-10991ae8a0b6
intro: |
  The components that power [Publish forms](/extending/publish-forms) throughout Statamic.
---

## Overview

Statamic provides a handful of Vue components that can be used like building blocks to create forms. To read about the general "publish form" concept, including how
to do all the server-side bits, [check out the publish forms page](/extending/publish-forms).

### Basic Forms

If you're creating a basic form, there's a [pre-built form component](#form) that could work for the 80% use case. <mark>This is probably enough for you!</mark>

### Complex Forms

For more complex forms, you can use the underlying components to build out the functionality you need. You'll need to have a Vue 
component responsible for your form's logic. At a minimum, it needs to hold values and submit them somewhere.

``` blade
<my-form-component
    :blueprint='@json($blueprint)'
    :meta='@json($meta)'
    :initial-values='@json($values)'
></my-form-component>
```

``` vue
<template>
    <publish-container ...>
        <div>
            <div>
                <h1>My Form</h1>
                <button @click="submit">Submit</button>
            </div>

            <!-- Render the fields -->
        </div>
    </publish-container>
</template>
<script>
export default {
    props: ['blueprint', 'meta', 'initialValues'],
    data() {
        return {
            values: this.initialValues,
        }
    },
    methods: {
        submit() {
            this.$axios.post('/somewhere', this.values).then(() => {
                //
            });
        }
    }
}
</script>
```

The `publish-container` example above is intentionally simplified. If you'd like to see a complete working example, you can take
a look at `components/publish/PublishForm.vue` inside the Statamic codebase. Otherwise, we can dive into the component itself...

## Form

The `PublishForm` component is an opinionated wrapper around the various subcomponents that make up "a publish form".
This will provide you with all the basics to make a simple and functional form.

- Renders a form based on a blueprint
- Inline validation messages
- AJAX submission handling
- Tracks the [dirty state](/extending/dirty-state-tracking)

### Usage

You can use it in Blade or in another Vue component.

``` blade
<publish-form
    title="My Form"
    action="{{ cp_route('test.update') }}"
    :blueprint='@json($blueprint)'
    :meta='@json($meta)'
    :values='@json($values)'
/>
```

### Props

| Prop | Type | Description |
|------|------|-------------|
| `blueprint`* | object | The blueprint contents. Use `$blueprint->toPublishArray()`
| `meta`* | object | The blueprint fields' meta data. Use `$fields->meta()`
| `values`* | object | The field values. Use `$fields->values()`
| `title`* | string | The title of the form.
| `action` | string | The URL where the form will be submitted.
| `method` | string | The submit request method. Either `patch` or `post`. Defaults to `post`.
| `breadcrumbs` | array | Array of [breadcrumb](/extending/breadcrumbs) objects.
| `name` | string | The name the [publish container](#container) will use. Only really necessary if you have multiple forms on a page. Defaults to `base`.

### Events

| Event | Description |
|-------|-------------|
| `saved` | When the request is finished after clicking the submit button. The payload will contain the Axios response object. Use `response.data` to get its contents.


## Container

The `PublishContainer` component is the workhorse. Among other things, it'll spin up a dedicated Vuex store and maintain the state of 
all the values when modified in fieldtypes, emit events, and manage the "dirty state" of the page.

Since it's renderless, you will typically want to wrap your entire component with it. That will let everything be able
to communicate where appropriate.

### Usage

``` html
<template>
    <publish-container
        ref="container"
        name="base"
        :blueprint="blueprint"
        :meta="meta"
        v-model="values"
        v-slot="{ setFieldValue, setFieldMeta }"
    >
        <div>
            <div>
                <h1>My Form</h1>
                <button @click="submit">Submit</button>
            </div>

            <publish-sections
                @updated="setFieldValue"
                @meta-updated="setFieldMeta" />
        </div>
    </publish-container>
</template>
```

The [`PublishSections` component](#sections) will handle rendering the sections and their fields. It will be able to get the blueprint,
field values, and whatever else it needs from the Vuex store that the publish container created. You just need to connect the wires for the data
bubbling back upwards.

The publish container's `default` slot will provide a couple of functions (`setFieldValue` and `setFieldMeta`) which you can just wire up like the
example above. Doing it this way (rather than just updating your `values` property, for example) will let the container component automatically manage
things like the dirty state and events.

### Props

| Prop | Type | Description |
|------|------|-------------|
| `name`* | String | The identifying name of the form. A Vuex store will be created using this as for the namespace. 
| `blueprint`* | object | The blueprint contents. Use `$blueprint->toPublishArray()`
| `meta`* | object | The blueprint fields' meta data. Use `$fields->meta()`
| `values`* | object | The field values. This is the prop used by `v-model`. Populate it with `$fields->values()`
| `errors` | object | An object containing Laravel validation errors. In an Axios `catch` callback for a 422 response, this would be `e.response.data.errors`.

### Events

| Event | Description |
|-------|-------------|
| `updated` | Whenever the values have changed. ie. When a field is edited. The payload contains all the values. This event is used by `v-model`.

### Methods

| Method | Description |
|--------|-------------|
| `saved()` | Informs the container to perform post-save logic, like clearing the dirty state.
| `setFieldValue(handle, value)` | Updates a field's value in the Vuex store.
| `setFieldMeta(handle, value)` | Updates a field's fieldtype meta data in the Vuex store.
| `clearDirtyState()` | Clears the dirty state, so you no longer get a warning when navigating away.


## Sections

The `PublishSections` component will render all the section of a blueprint, and all the fields in each section.
It **must** be inside a `PublishContainer` component. It will fetch the blueprint and all the values from the Vuex store
without needing to manually provide props.

### Props

| Prop | Type | Description | 
|------|------|-------------|
| `readOnly` | bool | Whether the fields should be read only. `false` by default.
| `enableSidebar` | bool | Shows the sidebar. `true` by default.
| `syncable` | bool | Whether syncing features shoud be enabled. `false` by default.

### Events

| Event | Description |
|-------|-------------|
| `updated` | When a field is updated. The handle and value of the field will be provided.
| `meta-updated` | When a field's meta value is updated. The handle and meta value of the field will be provided.

### Slots

#### actions

Allows you to insert extra items into the top of the sidebar, and will be responsively moved if there's not enough room for a sidebar.

``` html
<publish-sections>
    <template #actions>
        <div> ... </div>
    </template>
</publish-sections>
```

## Fields

The `PublishFields` component will display a list of fields - what you'd see inside one blueprint section.

Normally, you should just use the [`PublishSections` component](#sections). But, if you want more manual
control, this is available to you.
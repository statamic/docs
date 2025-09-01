---
id: f38a3e52-10ba-4bfa-9298-0c95b324c662
blueprint: page
title: 'UI Components'
---
When building custom areas of the Control Panel, you should aim to use the UI components as much as possible.

These will allow you to write UIs that match the design of Statamic without needing to worry about styles or Tailwind classes. It also allows you to keep your UIs in sync with our design system without having to do any additional work. In short, they're here to make your life easier.

You can treat these components like an extension of HTML itself. They should *just work*.

For example, if you need a card, don't use `<div class="bg-white p-4 rounded border shadow-sm">`, use the `<ui-card>` component!

## Syntax

All of the components are available with their kebab-cased name prefixed with `ui-`. For example:

```blade
<ui-card>
    <ui-heading text="A lovely card" />
    <ui-button @click="doSomething" text="Click me" />
</ui-card>
```

This syntax works in Blade _and_ Vue, which is especially handy for those times when you're bouncing back and forth between them.

## Importing

You can optionally import the UI components and namespace them, which gives your IDE the ability to autocomplete, link to the original components, and other useful dev-centric workflows. You import them from `@statamic/cms/ui`.

```vue
<script setup>
import { Card, Heading, Button } from '@statamic/cms/ui';
</script>
<template>
    <Card>
        <Heading text="A lovely card" />
        <Button @click="doSomething" text="Click me" />
    </Card>
</template>
```

## Anatomy of a Component

Most of our components use [Reka](https://reka-ui.com/) under the hood, and are built with Vue.js's [composition API](https://vuejs.org/api/composition-api-setup).

We utilize [Class Variariance Authority](https://cva.style/docs) to dynamically assemble our classes and styles based on variants and props.

:::tip
These docs are a work in progress during the Alpha. We're doing some major reorganizing of the docs for the v6 launch and will have complete documentation sometime between now and then. In the meantime, [explore the components themselves](https://github.com/statamic/cms/tree/master/resources/js/components/ui) to see what exists and what props/events are avilable.
:::

## Components

### Auth Card
TODO

### Badge
Highlight contextual information, like status, count, or related data. You can pass text through a `text` prop or use it like an HTML tag pair.

```html
<ui-badge color="green" size="lg">New</ui-badge>
<ui-badge color="green" size="lg" text="Few" />
```

#### Sizes

Badges are available in two sizes via the `size` prop.

```html
<ui-badge size="sm">Small</ui-badge>
<ui-badge>Default</ui-badge>
<ui-badge size="lg">Large</ui-badge>
```

#### Colors
Use the `color` attribute to change the badge's color.
```html
<ui-badge>Default</ui-badge>
<ui-badge color="white">White</ui-badge>
<ui-badge color="black">Black</ui-badge>
<ui-badge color="red">Red</ui-badge>
<ui-badge color="orange">Orange</ui-badge>
<ui-badge color="amber">Amber</ui-badge>
<ui-badge color="yellow">Yellow</ui-badge>
<ui-badge color="lime">Lime</ui-badge>
<ui-badge color="green">Green</ui-badge>
<ui-badge color="emerald">Emerald</ui-badge>
<ui-badge color="teal">Teal</ui-badge>
<ui-badge color="cyan">Cyan</ui-badge>
<ui-badge color="sky">Sky</ui-badge>
<ui-badge color="blue">Blue</ui-badge>
<ui-badge color="indigo">Indigo</ui-badge>
<ui-badge color="violet">Violet</ui-badge>
<ui-badge color="purple">Purple</ui-badge>
<ui-badge color="fuchsia">Fuchsia</ui-badge>
<ui-badge color="pink">Pink</ui-badge>
<ui-badge color="rose">Rose</ui-badge>
```

#### Variants
Use the `variant` prop to change the badge's style and shape. Flat badges are in slightly taller than default ones to account for the optical perception of borders and shadows.

```html
<ui-badge size="lg">Default</ui-badge>
<ui-badge variant="flat" size="lg">Flat</ui-badge>
```

#### Sub-Text
Use the `sub-text` prop to add supporting text, perfect for counts or numbers.

```html
<ui-badge color="black" sub-text="42">Events</ui-badge>
<ui-badge color="purple" sub-text="21">Updates</ui-badge>
```

#### Icons
Badges can contain icons through the use of slots or by using the `icon` prop to pass the name of an icon.

```html
<ui-badge icon="mail">david@hasselhoff.com</ui-badge>
```

#### Pills
Use the `pill` prop to round out the badge.

```html
<ui-badge pill>Pill</ui-badge>
```

#### As a link
Badges can be used as links by passing an `href` prop.

```html
<ui-badge pill variant="flat" size="lg" href="https://statamic.dev/">
	<p>Go read the <b>docs</b></p>
</ui-badge>
```

### Buttons
TODO

### Calendar
TODO

### Card
TODO

### Character Counter
TODO

### Checkbox
TODO

### Code Editor
TODO

### Combobox
TODO

### CommandPalette
TODO

Related to [Command Palette](/extending/command-palette) stuff here.

### Context
TODO

### Create Form
TODO

### DataTable
TODO

### DatePicker
TODO

### DateRangePicker
TODO

### Description
TODO

### Drag Handle
TODO

### Dropdowns
TODO

### Editable
TODO

### Error Message
TODO

### Empty State
TODO

### Field
TODO

### Header
TODO

### Heading
TODO

### Icon
TODO

### Input
TODO

### Label
TODO

### Listings

You can create a fully fledged listing using the aptly named `Listing` component with search, filters, column customization, etc.

In most cases, you can use the self-closed component and control the behavior using props.

```vue
<script setup>
import { Listing } from '@statamic/cms/ui';
</script>
<template>
    <Listing :items="..." />
</template>
```

| Prop                          | Description                                                                                  |
|-------------------------------|----------------------------------------------------------------------------------------------|
| url                           | The URL from which to retrieve results. Either use this or `items`.                          |
| items                         | If no URL is provided, you can provide an array of items to populate the table.              |
| allowPresets                  | Lets you disable presets.                                                                    |
| allowBulkActions              | Lets you disable bulk actions.                                                               |
| actionUrl                     | The URL from which to retrieve actions.                                                      |
| actionContext                 | The extra data to pass to the server when using actions.                                     |
| allowActionsWhileReordering   | Enables the action twirldown while reordering is enabled.                                    |
| reorderable                   | Adds drag handles to the rows.                                                               |
| preferencesPrefix             | Any preferences (preferred columns, etc) will be saved nested under this.                    |
| columns                       | The columns to display. Can be array of string or column definitions. v-modelable.           |
| allowCustomizingColumns       |                                                                                              |
| sortColumn                    | Defines the sort column. v-modelable                                                         |
| sortDirection                 | Defines the sort direction. Defaults to asc for most fields, desc for dates. v-modelable     |
| sortable                      |                                                                                              |
| selections                    | Array of checked items. v-modelable.                                                         |
| maxSelections                 |                                                                                              |
| pushQuery                     | Adds the parameters to the current URL.                                                      |
| additionalParameters          | Extra data to send to the ajax URL.                                                          |
| allowSearch                   |                                                                                              |
| searchQuery                   | v-modelable                                                                                  |
| filters                       | You can get this by doing `Scope::filters($name, $context)`                                  |
| filtersForReordering          | A function that returns array of filter values to be activated when reordering is enabled.   |
| perPage                       |                                                                                              |
| showPaginationTotals          | Shows the totals in the paginator. e.g. "1-5 of 10"                                          |
| showPaginationPageLinks       | Shows the page links. e.g. 1,2,3,4. With this disabled you'll just get the prev/next arrows. |
| showPaginationPerPageSelector | Shows the per page dropdown.                                                                 |

| Event                | Description                                                                                                                                                                                                               |
|----------------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| update:columns       | Emits the column definitions when the column customizer is used.                                                                                                                                                          |
| update:sortColumn    | Emits the sort column when a table header is clicked.                                                                                                                                                                     |
| update:sortDirection | Emits the sort direction when a table header is clicked.                                                                                                                                                                  |
| update:selections    | Emits the selected IDs when checkboxes are used.                                                                                                                                                                          |
| update:searchQuery   | Emits the search query when the input is used.                                                                                                                                                                            |
| requestCompleted     | Emits the response when the AJAX request is completed.                                                                                                                                                                    |
| reordered            | Emits an array of IDs after a row has been moved.                                                                                                                                                                         |
| refreshing           | Emitted when the listing should refresh, for example when an action is completed. Useful when using the `items` prop. Not useful when using the `url` prop as the listing will refresh automatically by making a request. |

| Slot                  | Description                                                                                                                                                     |
|-----------------------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------|
| initializing          | Displayed when the listing is getting its initial data. Defaults to a loading spinner.                                                                          |
| default               | Allows overriding the entire listing's contents. By default, the sub-components of the listing will be used. Useful if you wanted something other than a table. |
| cell-*                | Allows customization of specific table cells. The slot name will use the column name. e.g. `cell-my_field`.                                                     |
| prepended-row-actions | Allows adding to the action twirldown in each row. You should only add `DropdownItem` components.                                                               |


### Live Preview
TODO

### Modals
TODO

### Pagination
TODO

### Panels
TODO

### Popovers
TODO

### Publish Forms

You can create a form using the publish components.

The required components depends on the complexity of what you're building.

- Very simple forms may not need any Vue or JavaScript at all, and could simply use the `PublishForm` class directly from your controller.
- If you need JavaScript or Vue, the `PublishContainer` component can be paired with blueprint data to render an entire form.
- The PublishContainer component can have its contents overridden if you need more control over the layout or behavior of the form.


#### PublishForm

For very simple forms ...


#### PublishContainer

The `PublishContainer` component is the workhorse. For a basic form, you can use it self-closed with some props, and it will render exactly what you need.

```vue
<script setup>
import { PublishContainer, Button } from '@statamic/cms/ui';
</script>
<template>
    <Button @click="save" text="Save" />
    <PublishContainer
        v-model="values"
        :blueprint="blueprint"
        :meta="meta"
        :errors="errors"
    />
</template>
```

Based on the provided `blueprint`, it will render any tabs, sections, and fields appropriately.

You may customize the layout of the form by providing slot content.

```html
<PublishContainer>
    <Tabs /> etc
</PublishContainer>
```

#### Save Pipeline

The save pipeline pairs with a PublishContainer to save your data, render validation errors, fire hooks, etc.

The data from your publish container will be sent `through` the steps. The only required step is the `Request`.

You provide the pipeline class with a reference to the publish container, the saving state, and errors, and it will update them for you appropriately.

You may provide additional steps, such as the `AfterSaveHooks` here.

Once everything is done, the `then` callback will be run, like a promise.

Any errors can be caught in the `catch` callback. If the pipeline is intentionally stopped, `e` will be an instance of `PipelineStopped`.

```vue
<script setup>
import { Pipeline, Request, AfterSaveHooks } from '@statamic/cms/save-pipeline';
import { ref, useTemplateRef } from 'vue';

let saving = ref(false);
let errors = ref({});
let container = useTemplateRef('container');

function save() {
    new Pipeline()
        .provide({ container, errors, saving })
        .through([
            new Request(url, method),
            new AfterSaveHooks(name, payload)
        ])
        .then((response) => {
            //
        })
        .catch((e) => {
            //
        });
}
</script>
<template>
    <template v-if="saving">Saving...</template>
    <Button @click="save" text="Save" />
    <PublishContainer ref="container" :errors="errors" />
</template>
```

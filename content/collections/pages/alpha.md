---
id: 4e65fea6-e056-43c9-800d-f5ded4c6061b
blueprint: page
title: 'Statamic 6 Alpha'
overview: Goodies you can find in Statamic 6.
---
## JS/Vue approach

In addons and custom code, when using Statamic's JS components, importing directly from files located in the vendor directory is not supported as not everything is intended for public usage.

Usable items will be exported for you and available through the pseudo-package:

```js
import something from '../../vendor/statamic/cms/resources/js/somewhere/something.js'; // [tl! --]
import something from '@statamic/cms/something'; // [tl! ++]
```


## UI Components

When building custom areas of the Control Panel, you should aim to use the UI components as much as possible.

These will allow you to write UIs that match the design of Statamic without needing to worry about styles or Tailwind classes.

For example, need a card? Don't use `<div class="bg-white p-4 rounded border shadow-sm">`, use the `Card` component!

### Importing

To use a component in your Vue files, you can import them from `@statamic/cms/ui`.

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

### Global Components

When using Blade (or if you don't like all the benefits your editor can give you when you import) you can use the global components.

They will be available at the kebab-cased name prefixed with `ui-`. For example:

```blade
<ui-card>
    <ui-heading text="A lovely card" />
    <ui-button @click="doSomething" text="Click me" />
</ui-card>
```


## Listings

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


## Publish Forms

You can create a form using the publish components.

The required components depends on the complexity of what you're building.

- Very simple forms may not need any Vue or JavaScript at all, and could simply use the `PublishForm` class directly from your controller.
- If you need JavaScript or Vue, the `PublishContainer` component can be paired with blueprint data to render an entire form.
- The PublishContainer component can have its contents overridden if you need more control over the layout or behavior of the form.


### PublishForm

For very simple forms ...


### PublishContainer

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

### Save Pipeline

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

## Command Palette

The command palette provides handy access to many places in the Control Panel without having to leave your keyboard. Make friends with the `⌘K` shortcut.

Out of the box, a number of items will be already added, for example:
- Everything you can find in the navigation
- Content in your search index
- Contextual items, like buttons and actions on the current page.

You may add items to the command palette in a number of ways.

### PHP

In PHP, you can add basic links.

```php
use Statamic\CommandPalette\Category;
use Statamic\Facades\CommandPalette;

CommandPalette::add(
    text: ['Search', 'Ancient', 'Hotbot'], // Array will add separators "Search > Ancient > Hotbot"
    url: 'https://hotbot.com',
    openNewTab: true,
    trackRecent: false,
    icon: 'sexy-robot',
    category: Category::Actions,
);
```

### JavaScript

In JavaScript, you can add links too, but you the main benefit over PHP is that you can define functionality.

```js
import throwConfetti from 'confetti';

Statamic.$commandPalette.add({
    text: ['Silliness', 'Celebrate'],
    icon: 'star',
    action: () => {
        throwConfetti();
    },
});
```

### Vue Component

There's a Vue component that will add a command based on props. The props are exposed back to you through the slot so you don't have to define things twice.

A great example of when to use this would be if you have a button on the page that you want to also be accessible through the command palette.

```vue
<script setup>
import { CommandPaletteItem, Button } from '@statamic/cms/ui';
</script>
<template>
    <CommandPaletteItem
        text="Go Somewhere"
        url="/somewhere"
        v-slot="{ text, url }"
    >
        <Button :text="text" :href="url" />
    </CommandPaletteItem>
</template>
```

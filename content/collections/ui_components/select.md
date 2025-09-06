---
id: 398b249d-b785-4f85-962a-1c355f58ca6b
blueprint: ui_component
title: Select
intro: Displays a list of options for the user to pick from—triggered by an input style button.
---
 ```component
 <ui-select
    label="Favorite band"
    :options="[
        { label: 'The Midnight', value: 'the_midnight' },
        { label: 'The 1975', value: 'the_1975' },
        { label: 'Sunglasses Kid', value: 'sunglasses_kid' }
    ]"
/>
```

## Data Format

Pass data into the select with the `options` prop as an array of objects. The objects must contain a `value` and a `label`, but can contain any other day you would like as well.


## Sizes

Use the `size` prop to control the input's height and type scale. The scales match the button sizes to make sure everything lines up nicely.

```component
<ui-select
    label="Favorite band"
    size="sm"
    :options="[
        { label: 'The Midnight', value: 'the_midnight' },
        { label: 'The 1975', value: 'the_1975' },
        { label: 'Sunglasses Kid', value: 'sunglasses_kid' }
    ]"
/>
```


## Variants

Use the `variant` prop to change the appearance of the select.

```component
<ui-select
    label="Favorite band"
    :options="[
        { label: 'The Midnight', value: 'the_midnight' },
        { label: 'The 1975', value: 'the_1975' },
        { label: 'Sunglasses Kid', value: 'sunglasses_kid' }
    ]"
/>
<ui-select
    label="Favorite band"
    variant="filled"
    :options="[
        { label: 'The Midnight', value: 'the_midnight' },
        { label: 'The 1975', value: 'the_1975' },
        { label: 'Sunglasses Kid', value: 'sunglasses_kid' }
    ]"
/>
<ui-select
    label="Favorite band"
    variant="ghost"
    :options="[
        { label: 'The Midnight', value: 'the_midnight' },
        { label: 'The 1975', value: 'the_1975' },
        { label: 'Sunglasses Kid', value: 'sunglasses_kid' }
    ]"
/>
<ui-select
    label="Favorite band"
    variant="subtle"
    :options="[
        { label: 'The Midnight', value: 'the_midnight' },
        { label: 'The 1975', value: 'the_1975' },
        { label: 'Sunglasses Kid', value: 'sunglasses_kid' }
    ]"
/>
```


## Clearable

Add a clear button to your select by setting the `clearable` prop.

 ```component
 <ui-select
    label="Favorite band"
    :clearable="true"
    :options="[
        { label: 'The Midnight', value: 'the_midnight' },
        { label: 'The 1975', value: 'the_1975' },
        { label: 'Sunglasses Kid', value: 'sunglasses_kid' }
    ]"
/>
```


# Icon

Adds an icon to your select box.

 ```component
 <ui-select
    icon="money-bag-dollar"
    label="Currency"
    :options="[
        { label: 'U.S. Dollar', value: 'usd' },
        { label: 'Euro', value: 'euro' },
        { label: 'Gold Doubloon', value: 'gold_doublon' }
    ]"
/>
```


## Custom List Items

You can customize the markup and display of the list items inside of an `#options` slot, with full access to whatever data is passed into the select.

```component
<ui-select label="Author" :options="[
    { label: 'Tyler Lyle', image: '/assets/tyler.jpg' },
    { label: 'Tim McEwan', image: '/assets/tim.jpg' },
    { label: 'Nikki Flores', image: '/assets/nikki.jpg' },
]">
    <template #option="{ label, image }">
        <img :src="image" class="size-5 rounded-full" />
        <span v-text="label" />
    </template>
</ui-select>
```

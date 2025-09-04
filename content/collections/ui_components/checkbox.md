---
id: 4c4c3f7a-7a78-4472-8722-e7835609ea63
blueprint: ui_component
template: ui-component
title: Checkbox
intro: Checkboxes are used to select multiple options from a list of options.
---

```component
<ui-checkbox-item name="terms" label="I agree to have fun!" />
```

## With descriptions

Checkboxes can have descriptions below their labels.

```component
<ui-checkbox-item
    name="terms"
    label="I Agree"
    description="...that if I wrastle this here gator I won't sue nobody."
/>
```

## Checkbox group

Organize a list of related checkboxes vertically.

::: tip
When using checkbox groups, add your `name` or `v-model` to the group element instead of the individual checkboxes
:::

```component
<ui-checkbox-group name="meals">
    <ui-heading text="Which meals do you know about?" />
    <ui-checkbox-item value="Breakfast" />
    <ui-checkbox-item value="Second breakfast" />
    <ui-checkbox-item value="Elevensies" />
    <ui-checkbox-item value="Luncheon" />
    <ui-checkbox-item value="Afternoon tea" />
    <ui-checkbox-item value="Dinner" />
    <ui-checkbox-item value="Supper" />
</ui-checkbox-group>
```

## Inline

You can also arrange your checkboxes inline, horizontally.

```component
<ui-checkbox-group name="books" :inline="true" class="flex justify-center">
    <ui-checkbox-item value="The Hobbit" />
    <ui-checkbox-item value="Lord of the Rings" />
    <ui-checkbox-item value="The Silmarillion" />
</ui-checkbox-group>
```

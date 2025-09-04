---
id: 623e132f-d382-4817-90a1-5073b0065dfc
blueprint: ui_component
title: Dropdown
template: ui-component
intro: Displays a menu to the user—such as a set of actions or functions—triggered by a button, with full keyboard navigation support.
---

The dropdown component has a `<template #trigger>` slot to contain the button that will trigger the dropdown.

```component
<ui-dropdown>
    <template #trigger>
        <ui-button text="Do a Action" icon-append="ui/chevron-vertical" class="[&_svg]:size-2" />
    </template>
    <ui-dropdown-menu>
        <ui-dropdown-item text="Bake a food" />
        <ui-dropdown-item text="Write that book" />
        <ui-dropdown-item text="Eat this meal" />
        <ui-dropdown-item text="Lie about larceny" />
        <ui-dropdown-item text="Save some bird" />
    </ui-dropdown-menu>
</ui-dropdown>
```

## Icons

```component
<ui-dropdown>
    <template #trigger>
        <ui-button text="Go To..." icon-append="ui/chevron-vertical" class="[&_svg]:size-2" />
    </template>
    <ui-dropdown-menu>
        <ui-dropdown-item text="Assets" icon="assets" />
        <ui-dropdown-item text="Collections" icon="collections" />
        <ui-dropdown-item text="Globals" icon="globals" />
        <ui-dropdown-item text="Navigation" icon="navigation" />
        <ui-dropdown-separator />
        <ui-dropdown-item text="Taxonomies" icon="taxonomies" />
    </ui-dropdown-menu>
</ui-dropdown>
```

## Headers and footers

Headers and footers can be added to the dropdown by using the `<ui-dropdown-header>` and `<ui-dropdown-footer>` components.

```component

<ui-dropdown>
    <template #trigger>
        <ui-button text="My Account" icon-append="ui/chevron-vertical" class="[&_svg]:size-2" />
    </template>
    <ui-dropdown-header text="My Account" icon="avatar" />
    <ui-dropdown-menu>
        <ui-dropdown-item text="Photos" icon="assets" />
        <ui-dropdown-item text="Email" icon="mail" />
        <ui-dropdown-item text="Sales" icon="taxonomies" />
    </ui-dropdown-menu>
    <ui-dropdown-footer text="Logout" icon="arrow-right" />
</ui-dropdown>
```

## Disabled items

Items can be disabled by using the `disabled` prop.

```component
<ui-dropdown>
    <template #trigger>
        <ui-button text="Go To..." icon-append="ui/chevron-vertical" class="[&_svg]:size-2" />
    </template>
    <ui-dropdown-menu>
        <ui-dropdown-item text="Collections" icon="collections" />
        <ui-dropdown-item text="Taxonomies" icon="taxonomies" disabled />
        <ui-dropdown-item text="Globals" icon="globals" />
    </ui-dropdown-menu>
</ui-dropdown>
```

## Side

You can choose what side the dropdown should open on — `bottom` (default), `top`, `left`, or `right`.

```component
<ui-dropdown side="right">
    <template #trigger>
        <ui-button text="Go Right" icon-append="ui/chevron-vertical" class="[&_svg]:size-2" />
    </template>
    <ui-dropdown-menu>
        <ui-dropdown-item text="Collections" icon="collections" />
        <ui-dropdown-item text="Taxonomies" icon="taxonomies" disabled />
        <ui-dropdown-item text="Globals" icon="globals" />
    </ui-dropdown-menu>
</ui-dropdown>
```

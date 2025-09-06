---
id: 4c886845-000a-42b2-b563-7d09b6e833f1
blueprint: ui_component
title: Popover
intro: Display rich content in a portal, triggered by a button.
---
```component
<ui-popover>
    <template #trigger>
        <ui-button text="Open Popover" />
    </template>
    <div class="flex flex-col gap-2.5">
        <ui-heading text="Provide Feedback" />
        <ui-textarea placeholder="How we can make this component better?" elastic />
        <div class="flex flex-col sm:flex-row sm:justify-end">
            <ui-button variant="primary" size="sm" text="Submit" />
        </div>
    </div>
</ui-popover>
```


## Controlling Width

Use standard Tailwind classes with important (!) to control the size of the popover. By default, popovers are 4.5 rems (288px) wide.

```component
<ui-popover class="w-[420px]!">
    <template #trigger>
        <ui-button text="Open Popover" />
    </template>
    <ui-heading text="I'm 420 pixels wide" />
    <img src="https://images.unsplash.com/photo-1611946258523-9c2bfabb94e3?q=80&w=2571&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="420" class="mt-2">
</ui-popover>
```


## Direction

Popovers can pop out in any direction – `top`, `bottom`, `left`, and `right`. Set that direction with the `side` prop.

```component
<ui-popover side="left">
    <template #trigger>
        <ui-button text="To the left" />
    </template>
    <p>Popped to the left</p>
</ui-popover>

<ui-popover side="right">
    <template #trigger>
        <ui-button text="To the right" />
    </template>
    <p>Popped to the right</p>
</ui-popover>
```

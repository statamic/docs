---
id: fbfda0bf-25e0-4199-b1d1-7217af1fcc7a
blueprint: ui_component
title: Heading
template: ui-component
intro: Clean and consistent headings and subheadings.
---
```component
<div class="flex flex-col">
    <ui-heading size="lg">Create collection</ui-heading>
    <ui-subheading>Create a collection to manage a group of entries.</ui-subheading>
</div>
```

## Sizes
Headings come in three sizes. If that feels too restrictive, that's okay — you'll get used to it. Less is more. Trust us.

```component
<ui-heading>Default</ui-heading>
<ui-heading size="lg">Large</ui-heading>
<ui-heading size="xl">Extra Large</ui-heading>
```


## Heading Level
Control the heading level (<code>h1</code>, <code>h2</code>, etc) with the <code>level</code> prop. Without it, the heading will use a <code>div</code>.

```component
<ui-heading level="3" size="xl">Create collection</ui-heading>
```


## Icon

Add an appropriately sized icon to your heading with the `icon` prop.

```component
<ui-heading
    size="lg"
    icon="setting-slider-vertical"
    text="Manage Settings"
></ui-heading>
```


# As a link

Headings can have a link set with an <code>href</code> prop.

```component
<ui-heading size="lg" href="https://statamic.com">
    Visit statamic.com
</ui-heading>
```

---
id: b28338a0-67d4-4db0-abee-c8deb6a185cd
blueprint: ui_component
title: Separator
intro: Clean and consistent visual separators for content sections.
---
```component
<ui-separator text="vs" />
```

## Variants

Separators come in two styles. Use them to match the aesthetic of your interface.

```component
<div class="flex flex-col w-full">
    <ui-separator text="Line Separator (Default)" />
    <ui-separator variant="dots" text="Dotted Separator" />
</div>
```


##  Text

Add text to your separator with the `text` prop.

```component
<ui-separator text="Breaker High" />
```


## Vertical

Use the `vertical` prop to create a vertical separator.

```component
<div class="flex items-center h-6 space-x-4">
    <div>Left Content</div>
    <ui-separator vertical />
    <div>Right Content</div>
</div>
```

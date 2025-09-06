---
id: aa45ab8f-294a-4b80-b0fa-c23be91b88a9
blueprint: ui_component
title: Splitter
intro: Splitter is a component that allows you to split content into multiple, resizable panes.
---
```component
<ui-splitter-group>
<ui-splitter-panel class="h-24 bg-gray-100 rounded-xl flex items-center justify-center">
    Left
</ui-splitter-panel>
<ui-splitter-resize-handle class="w-3"/>
<ui-splitter-panel class="h-24 bg-gray-100 rounded-xl flex items-center justify-center">
    Right
</ui-splitter-panel>
</ui-splitter-group>
```

## Default Size

You can set the default size of a panel by using the `default-size` prop.

```component
<ui-splitter-group>
<ui-splitter-panel class="h-24 bg-gray-100 rounded-xl flex items-center justify-center">
    Sidebar
</ui-splitter-panel>
<ui-splitter-resize-handle class="w-3"/>
<ui-splitter-panel :default-size="75" class="h-24 bg-gray-100 rounded-xl flex items-center justify-center">
    Main
</ui-splitter-panel>
</ui-splitter-group>
```


## Collapsible

Splitters can be collapsible to reduce the amount of space they take up, or to hide them completely. Use the `collapsible` prop to make the splitter collapsible and control the minimum size of the panel with the `min-size` prop.

```component
<ui-splitter-group>
<ui-splitter-panel collapsible :min-size="15" class="h-24 bg-gray-100 rounded-xl flex items-center justify-center">
    Sidebar
</ui-splitter-panel>
<ui-splitter-resize-handle class="w-3"/>
<ui-splitter-panel :default-size="75" class="h-24 bg-gray-100 rounded-xl flex items-center justify-center">
    Main
</ui-splitter-panel>
</ui-splitter-group>
```


## Nested Splitters

Splitters can be nested to create more complex layouts.

```component
<ui-splitter-group class="p-4">
<ui-splitter-panel class="bg-gray-100 rounded-xl h-48 flex items-center justify-center">
    Left
</ui-splitter-panel>
<ui-splitter-resize-handle class="w-3"/>
<ui-splitter-panel>
    <ui-splitter-group direction="vertical">
        <ui-splitter-panel class="bg-gray-100 rounded-xl flex items-center justify-center">
            Right Top
        </ui-splitter-panel>
        <ui-splitter-resize-handle class="h-3" />
        <ui-splitter-panel class="bg-gray-100 dark:bg-gray-900 rounded-xl flex items-center justify-center">
            Right Bottom
        </ui-splitter-panel>
    </ui-splitter-group>
</ui-splitter-panel>
</ui-splitter-group>
```

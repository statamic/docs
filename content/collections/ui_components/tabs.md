---
id: 83a67772-b3b8-4f5a-9db8-e5a014f681e2
blueprint: ui_component
title: Tabs
template: ui-component
---
```component
<ui-tabs default-tab="tab1" class="w-full">
    <ui-tab-list>
        <ui-tab-trigger text="Shiny" name="tab1" />
        <ui-tab-trigger text="Happy" name="tab2" />
        <ui-tab-trigger text="People" name="tab3" />
    </ui-tab-list>
    <ui-tab-content name="tab1">
        <p class="py-8">Tab 1 content</p>
    </ui-tab-content>
    <ui-tab-content name="tab2">
        <p class="py-8">Tab 2 content</p>
    </ui-tab-content>
    <ui-tab-content name="tab3">
        <p class="py-8">Tab 3 content</p>
    </ui-tab-content>
</ui-tabs>
```

---
id: 7638e0a3-4a16-4849-93ab-72509a7083c4
blueprint: ui_component
title: Modal
template: ui-component
intro: Display content in a layer above the main page. Ideal for confirmations, alerts, and forms.
---
```component
<ui-modal title="That's Pretty Neat">
    <template #trigger>
        <ui-button text="How neat is that?" />
    </template>
</ui-modal>
```


## Title

Titles are required for accessibilility, but you don't have to use the `title` prop if you want to style it differently. You have full control of the style and content by using the `ui-modal-title` component.

```component
<ui-modal>
    <template #trigger>
        <ui-button text="How neat is that?" />
    </template>
    <ui-modal-title class="text-center flex items-center justify-between">
        <span>🍁</span>
        <h2 class="font-serif text-xl">What's why they call it neature!</h2>
        <span>🍁</span>
    </ui-modal-title>
</ui-modal>
```


## Close Button

You can use the `ui-modal-close` component to close the modal.

```component
<ui-modal title="Hey look a close button" class="text-center">
    <template #trigger>
        <ui-button text="Open Says Me" />
    </template>
    <ui-modal-close class="text-center">
        <ui-button text="Close Says Me" />
    </ui-modal-close>
</ui-modal>
```


## Icon

You can add an icon to the title by passing the `icon` prop.

```component
<ui-modal title="That's Pretty Neat" icon="fire-flame-burn-hot">
    <template #trigger>
        <ui-button text="How neat is that?" />
    </template>
</ui-modal>
```


## Footer

You can use a custom footer by using the `#footer` slot.

```component
<ui-modal title="Create new user">
    <template #trigger>
        <ui-button text="Create User" variant="primary" />
    </template>
    <div class="space-y-6 py-3">
        <div class="flex gap-6">
            <ui-field label="First name" badge="Optional">
                <ui-input name="first_name" />
            </ui-field>
            <ui-field label="Last name" badge="Optional">
                <ui-input name="last_name" />
            </ui-field>
        </div>
        <ui-field label="Email">
            <ui-input name="email" type="email" />
        </ui-field>
        <ui-field label="Password">
            <ui-input label="Password" type="password" />
        </ui-field>
    </div>
    <template #footer>
        <div class="flex items-center justify-end space-x-3 pt-3 pb-1">
            <ui-modal-close>
                <ui-button text="Cancel" variant="ghost" />
            </ui-modal-close>
            <ui-button text="Create User" variant="primary" />
        </div>
    </template>
</ui-modal>
```

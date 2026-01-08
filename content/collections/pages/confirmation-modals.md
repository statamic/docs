---
title: Confirmation Modals
id: 88bf3f66-4b80-42c9-8b65-bef712b8f413
---

Statamic ships with a [`<Modal>` UI component](https://ui.statamic.dev/?path=/docs/overlays-modal--docs) you can use to build custom modals. 

However, if all you need is a confirmation prompt, you can use the `ConfirmationModal` component instead. You should use `v-if` to make it appear.

``` html
<confirmation-modal
    v-if="confirming"
    title="Do the thing"
    @confirm="doTheThing"
    @cancel="confirming = false"
/>
```

## Props

| Prop | Description |
|------|-------------|
| `title` | Header text |
| `bodyText` | Provide a simple string as a content of the modal. Defaults to `Are you sure?`. |
| `buttonText` | Text for the confirmation button label. Defaults to `Confirm`. |
| `danger` | Boolean for making the modal red. Useful for when you're doing something scary like deletions. |

## Events

| Event | Description |
|-------|-------------|
| `confirm` | When the user clicks the confirm button. |
| `cancel` | When the user clicks the cancel button. |

## Slots

The default slot replaces the `bodyText` prop. Useful when you need something more complicated than a single paragraph.

``` html
<confirmation-modal ...>
    <p>More complicated</p>
    <p>stuff here.</p>
</confirmation-modal>
```


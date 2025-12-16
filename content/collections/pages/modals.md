---
title: Modals
id: 88bf3f66-4b80-42c9-8b65-bef712b8f413
---

You can learn more about our `<Modal>` component on the [UI Component docs](https://ui.statamic.dev/?path=/docs/components-modal--docs).

## Confirmation Modals

There is a prebuilt modal component available to you if you don't need something completely custom. You should use `v-if` to make it appear.

``` html
<confirmation-modal
    v-if="confirming"
    title="Do the thing"
    @confirm="doTheThing"
    @cancel="confirming = false"
/>
```

### Props

| Prop | Description |
|------|-------------|
| `title` | Header text |
| `bodyText` | Provide a simple string as a content of the modal. Defaults to `Are you sure?`. |
| `buttonText` | Text for the confirmation button label. Defaults to `Confirm`. |
| `danger` | Boolean for making the modal red. Useful for when you're doing something scary like deletions. |

### Events

| Event | Description |
|-------|-------------|
| `confirm` | When the user clicks the confirm button. |
| `cancel` | When the user clicks the cancel button. |

### Slots

The default slot replaces the `bodyText` prop. Useful when you need something more complicated than a single paragraph.

``` html
<confirmation-modal ...>
    <p>More complicated</p>
    <p>stuff here.</p>
</confirmation-modal>
```


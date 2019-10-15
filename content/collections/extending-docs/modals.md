---
title: Modals
id: 88bf3f66-4b80-42c9-8b65-bef712b8f413
---
## Modals

You can create modals using the `<modal>` component.

``` html
<modal
    v-if="isOpen" 
    name="my-modal" 
    width="300px" height="300px"
    @closed="isOpen = false"
>
    <div slot-scope="{ close }">
        Your modal's content.
        <button @click="close">x</button>
    </div>
</modal>
```

When a modal is rendered in the DOM, it will be automatically opened. So, to control whether or not it's open, you should add a `v-if` to it.

When closed, the modal will emit a `closed` event. You should use this event to change the 'open' condition back to `false`.

You should also add a button somewhere inside your modal to be able to close it. To close it, emit a `closed` event.

## Confirmation Modals

There is a prebuilt modal component available to you if you don't need something completely custom.

Similar to the regular modal, you should use a `v-if` to make it appear.

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


---
title: Stacks
intro: |
  A Stack is a way to add a layer of UX to the Control Panel.
stage: 1
id: c21a18cc-b9a9-4b1a-b1f7-97473f7d82f1
---
## Stacks
For example, when editing a related entry while you're already editing another entry would open a second publish form over the top. Once you're done, the layer would close and return you to your original task, without you losing any progress, or needing to navigate away.

To create a Stack, wrap a block of content with a `<stack>` component.

``` html
<stack name="inline-editor" v-if="isEditing" @closed="isEditing = false">
    Your stack's content.
</stack>
```

## Narrow stacks

To make a stack narrow, add a prop.

``` html
<stack narrow>...</stack>
```

## Opening a Stack

When a Stack is rendered in the DOM, it will be automatically opened. So, to control whether or not it's open, you should add a `v-if` to it.

## Closing a Stack

You can close a Stack by clicking on a lower stack (or the original layer). Any higher Stacks will also attempt to close. You can also change your `v-if` back to a falsey value.

When closed, the modal will emit a `closed` event. It's recommended to use this event to perform your closing logic. This will let the Stack nicely animate out instead of abruptly disappearing. The `close` function is available to you in the slot scope.

``` html
<stack v-if="isEditing" @closed="isEditing = false">
  <div slot-scope="{ close }">

    <!-- instead of this: --->
    <button @click="isEditing = false">Close</button>

    <!-- do this: -->
    <button @click="close">Close</button>

  </div>
</stack>
```

## Preving Stacks from closing

Before a Stack is closed, you have the opportunity to cancel it. For instance, if your Stack contains a form, you may want to give a warning about unsaved changes when the user tries to close it. To prevent closing of a Stack, you should pass in a function that returns `false` to stop closing and `true` to allow it.

``` html
<stack :before-close="shouldClose"> ... </stack>
```
``` js
shouldClose() {
    if (confirm('Are you sure?')) {
        return true; // let it close
    } else {
        return false; // prevent it from closing
    }
}
```

If you prevent your stack from closing, any subsequent Stacks closures will also be prevented.

## Panes

Panes are similar to narrow Stacks, except there can only be one at a time, and they appear next to your content instead of over the top. This allows you to interact with the pane and your main content area at the same time.

``` html
<pane name="options" v-if="showOptions" @closed="showOptions = false">
    <div slot-scope="{ close }">
        Pane content
        <button @click="close">Close</button>
    </div>
</pane>
```

---
id: 3482755d-3d20-42d5-8680-301a1cb95965
title: Command Palette
---

The command palette provides handy access to many places in the Control Panel without having to leave your keyboard. Make friends with the `⌘K` shortcut.

Out of the box, a number of items will be already added, for example:
- Everything you can find in the navigation
- Content in your search index
- Contextual items, like buttons and actions on the current page.

You may add items to the command palette in a number of ways.

### PHP

In PHP, you can add basic links.

```php
use Statamic\CommandPalette\Category;
use Statamic\Facades\CommandPalette;

CommandPalette::add(
    text: ['Search', 'Ancient', 'Hotbot'], // Array will add separators "Search > Ancient > Hotbot"
    url: 'https://hotbot.com',
    openNewTab: true,
    trackRecent: false,
    icon: 'sexy-robot',
    category: Category::Actions,
);
```

### JavaScript

In JavaScript, you can add links too, but you the main benefit over PHP is that you can define functionality.

```js
import throwConfetti from 'confetti';

Statamic.$commandPalette.add({
    text: ['Silliness', 'Celebrate'],
    icon: 'star',
    action: () => {
        throwConfetti();
    },
});
```

### Vue Component

There's a Vue component that will add a command based on props. The props are exposed back to you through the slot so you don't have to define things twice.

A great example of when to use this would be if you have a button on the page that you want to also be accessible through the command palette.

```vue
<script setup>
import { CommandPaletteItem, Button } from '@statamic/cms/ui';
</script>
<template>
    <CommandPaletteItem
        text="Go Somewhere"
        url="/somewhere"
        v-slot="{ text, url }"
    >
        <Button :text="text" :href="url" />
    </CommandPaletteItem>
</template>
```
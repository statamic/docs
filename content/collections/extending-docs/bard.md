---
title: Bard
id: e2078e40-0b3f-415b-8963-e99b4cc84f02
---

## Extensions

You may add your own [TipTap](https://tiptap.scrumpy.io/) extensions to Bard using the `extend` method. The callback may return an extension instance, or an array of them.

``` js
Statamic.$bard.extend(() => new MyExtension);
```

``` js
Statamic.$bard.extend(() => [new MyExtension, new AnotherExtension]);
```

## Buttons

To add a button to the toolbar, use the `buttons` method. The callback may return a button object, or an array of them.

``` js
Statamic.$bard.buttons(() => {
    return { name: 'bold', text: __('Bold'), command: 'bold', icon: 'bold' };
});
```

``` js
Statamic.$bard.buttons(() => [
    { name: 'bold', text: __('Bold'), command: 'bold', icon: 'bold' },
    { name: 'italic', text: __('Italic'), command: 'italic', icon: 'italic' },
]);
```

Returning values to the button method will push them onto the end. If you need more control, you can manipulate the supplied buttons argument, and then return nothing. For example, we'll add a button after wherever the existing bold button happens to be:

``` js
Statamic.$bard.buttons(buttons => {
    const indexOfBold = _.findIndex(buttons, { command: 'bold' });

    buttons.splice(indexOfBold + 1, 0, {
        name: 'italic', text: 'Italic', command: 'italic', icon: 'italic'
    });
});
```
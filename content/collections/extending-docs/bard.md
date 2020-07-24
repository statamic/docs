---
title: Bard
stage: 1
id: e2078e40-0b3f-415b-8963-e99b4cc84f02
---

## Extensions

You may add your own [TipTap](https://tiptap.scrumpy.io/) extensions to Bard using the `extend` method. The callback may return a single extension, or an array of them.

``` js
Statamic.$bard.extend(({ mark }) => mark(new MyExtension));
```

``` js
Statamic.$bard.extend(({ mark }) => {
    return [
        mark(new MyExtension),
        mark(new AnotherExtension)
    ]
});
```

The classes you return should be wrapped using the provided helper functions (eg. `mark` in the example above).

### Classes

Your extension class should look like a TipTap extension ([see an example here](https://github.com/scrumpy/tiptap/blob/master/packages/tiptap-extensions/src/marks/Bold.js))
except it should not extend another class, and you should use methods instead of getters.

``` js
export default class MyExtension {
  name() {
    return 'myextension';
  }
}
```

### Marks

The `extend` callback will provide a `mark` function to you. Use it to wrap your class, and under the hood it will convert it to an actual TipTap extension class
to be used by Bard.

Within your class, Statamic will provide commonly used functions along with the arguments you'd get in a TipTap extension. This prevents you from needing to
import the entire TipTap library into your build. For example:

``` js
commands({ type, toggleMark }) {
    return () => toggleMark(type)
}
```

> If you need more TipTap methods than the ones passed into the arguments, you can use our [TipTap API](#tiptap-api).

If you're providing a new mark and intend to use this Bard field on the front-end, you will also need to create a Mark class to be used by the PHP [renderer](#prosemirror-rendering).

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

## TipTap API

In your extensions, you may need to use functions from the `tiptap` library. Rather than importing the library yourself and bloating your JS files, you may use methods through our API.

``` js
Statamic.$bard.tiptap.core; // 'tiptap'
Statamic.$bard.tiptap.commands; // 'tiptap-commands'
Statamic.$bard.tiptap.utils; // 'tiptap-utils'
```

You could shorten things up by using destructuring. For example:

``` js
const { core: tiptap, commands, utils } = Statamic.$bard.tiptap;
const selection = new tiptap.TextSelection(...);
commands.insertText(...);
utils.getMarkAttrs(...);
```

## ProseMirror Rendering

If you have created a mark on the JS side to be used inside the Bard fieldtype, you will need to be able to render it on the PHP side (in your views).

The Bard `Augmentor` class is responsible for converting the ProseMirror structure to HTML.

You can use the `addMark` method to bind a [Mark](https://github.com/ueberdosis/prosemirror-to-html) class into the renderer. Your service provider's `boot` method
is a good place to do this.

``` php
use Statamic\Fieldtypes\Bard\Augmentor;

public function boot()
{
    Augmentor::addMark(MyMark::class);
}
```

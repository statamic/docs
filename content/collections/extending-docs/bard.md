---
title: Extending Bard
stage: 1
intro: "The Bard fieldtype is a rich-text editor based on [TipTap](https://tiptap.scrumpy.io/), which in turn is a Vue component that wraps around [ProseMirror](https://prosemirror.net/docs/guide/), which is robust JavaScript framework for building rich-text editors that _don't_ directly write HTML or rely on `contenteditable`, but rather a document model."
id: e2078e40-0b3f-415b-8963-e99b4cc84f02
---
## Required Reading

Before you attempt to create any Bard extensions, it would be wise to learn how to write a TipTap extension first. Otherwise you'd be trying to learn how to ride a motorcycle before you can even ride a bike. Or a unicyle before you can juggle. To have a better understanding of how to write a TipTap extension, you'd in turn benefit greatly on reading about how ProseMirror works.

:::tip
Writing custom extensions for Bard is pretty complicated, but can be rewarding and give you powerful results.
:::

In short, here's a quickstart of the things you should probably start with:

- [The ProseMirror guide](https://prosemirror.net/docs/guide/) — Yes, it's really long, but you should at least pretend to read it
- Checking out the [code samples for the core TipTap extensions](https://github.com/ueberdosis/tiptap/tree/v1/packages/tiptap-extensions), so you can understand how TipTap relates to ProseMirror
- If you don't know [how to extend the control panel](/extending/control-panel) yet, go ahead and read up on that first. The code snippets later will be part of your extension to the control panel. Alternatively, you may also [extend the control panel through the creation of an addon](/extending/addons).
- Come back here again and keep on going.

## Extensions

### Adding New Extensions

You may add your own TipTap extensions to Bard using the `addExtension` method. (Previously `extend`.) The callback may return a single extension, or an array of them.

``` js
Statamic.$bard.addExtension(({ mark, node }) => mark(new MyExtension));
```

``` js
Statamic.$bard.addExtension(({ mark, node }) => {
    return [
        mark(new MyExtension),
        node(new AnotherExtension)
    ]
});
```

The classes you return should be wrapped using the provided helper functions (i.e. `mark` or `node` like in the example above).

:::tip
If you want to _replace_ an existing extension, [read below](#replacing-existing-extensions).
:::

### Extension Classes

Your extension class should look like a TipTap extension ([see an example here](https://github.com/ueberdosis/tiptap/blob/v1/packages/tiptap-extensions/src/marks/Bold.js))
except it should not extend another class, and you should use methods instead of getters.

``` js
export default class MyExtension {
  constructor(options = {}) {
    this.options = options
  }

  name() {
    return 'myextension';
  }

  schema() {
    // Your schema stuff
  }

  commands({type}) {
    // Your command stuff
  }

  inputRules({type}) {
    return [] // Input rules if you want
  }

  plugins() {
    return []
  }

  pasteRules() {
    return []
  }
}
```

### Replacing Existing Extensions

If you'd like to replace a [native extension](https://github.com/ueberdosis/tiptap/tree/v1/packages/tiptap-extensions/src/nodes) (e.g. headings or paragraphs) you can use the `replaceExtension` method. It takes the `name` of the extension, and a callback that returns a single extension instance.

The callback will provide you with the existing extension instance.

```js
Statamic.$bard.replaceExtension('heading', ({ mark, node, extension }) => {
    return node(new CustomHeadingExtension(extension.options));
})
```

If you are doing simple tweaks to an extension (e.g. adding tailwind classes to headings) you can use the native extension classes directly by importing them through `$bard.tiptap.extensions`. Then you don't need to author an entire class and use the `mark` or `node` helpers.

```js
const { Heading } = Statamic.$bard.tiptap.extensions;

class CustomHeading extends Heading {
    get schema() {
        return {
            ...super.schema,
            toDOM: node => [`h${node.attrs.level}`, { class: 'font-bold' }, 0],
        }
    }
}

Statamic.$bard.replaceExtension('heading', ({ mark, node, extension }) => {
    return new CustomHeadingExtension(extension.options);
})
```


### Marks and Nodes

The `addExtension` and `replaceExtension` callbacks will provide the `mark` and `node` functions to you. Use it to wrap your class, and under the hood it will convert it to an actual TipTap extension class
to be used by Bard.

Within your class, Statamic will provide commonly used functions along with the arguments you'd get in a TipTap extension. This prevents you from needing to
import the entire TipTap library into your build. For example:

``` js
// mark
commands({ type, toggleMark }) {
    return () => toggleMark(type)
}

// node
commands({ type, toggleBlockType }) {
    return () => toggleBlockType(type)
}
```

:::tip
If you need more TipTap methods than the ones passed into the arguments, you can use our [TipTap API](#tiptap-api).
:::

If you're providing a new mark or node and intend to use this Bard field on the front-end, you will also need to create a Mark or Node class to be used by the PHP [renderer](#prosemirror-rendering).

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

If you have created a mark or node on the JS side to be used inside the Bard fieldtype, you will need to be able to render it on the PHP side (in your views).

The Bard `Augmentor` class is responsible for converting the ProseMirror structure to HTML.

You can use the `addMark` and `addNode` methods to bind a [Mark or Node](https://github.com/ueberdosis/prosemirror-to-html) class into the renderer. Your service provider's `boot` method
is a good place to do this.

``` php
use Statamic\Fieldtypes\Bard\Augmentor;

public function boot()
{
    Augmentor::addMark(MyMark::class);
    Augmentor::addNode(MyNode::class);
}
```

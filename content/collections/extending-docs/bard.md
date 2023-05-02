---
title: Extending Bard
stage: 1
intro: "The Bard fieldtype is a rich-text editor based on [Tiptap](https://tiptap.dev/), which in turn is a Vue component that wraps around [ProseMirror](https://prosemirror.net/docs/guide/), which is robust JavaScript framework for building rich-text editors that _don't_ directly write HTML or rely on `contenteditable`, but rather a document model."
id: e2078e40-0b3f-415b-8963-e99b4cc84f02
---
## Required Reading

Before you attempt to create any Bard extensions, it would be wise to learn how to write a Tiptap extension first. Otherwise you'd be trying to learn how to ride a motorcycle before you can even ride a bike. Or a unicyle before you can juggle. To have a better understanding of how to write a Tiptap extension, you'd in turn benefit greatly on reading about how ProseMirror works.

:::tip
Writing custom extensions for Bard is pretty complicated, but can be rewarding and give you powerful results.
:::

In short, here's a quickstart of the things you should probably start with:

- [The ProseMirror guide](https://prosemirror.net/docs/guide/) — Yes, it's really long, but you should at least pretend to read it
- Checking out the [The Tiptap documentation](https://tiptap.dev/introduction) and [code samples for the core Tiptap extensions](https://github.com/ueberdosis/tiptap/tree/develop/packages), so you can understand how Tiptap relates to ProseMirror
- If you don't know [how to extend the control panel](/extending/control-panel) yet, go ahead and read up on that first. The code snippets later will be part of your extension to the control panel. Alternatively, you may also [extend the control panel through the creation of an addon](/extending/addons).
- Come back here again and keep on going.

## Extensions

### Adding New Extensions

You may add your own Tiptap extensions to Bard using the `addExtension` method. The callback may return a single extension, or an array of them.

``` js
const { Node, Mark, Extension } = Statamic.$bard.tiptap.core;

Statamic.$bard.addExtension(() => Node.create({...}));
```

``` js
Statamic.$bard.addExtension(() => {
    return [
        Node.create({...}),
        Mark.create({...}),
        Extension.create({...}),
    ]
});
```

Check out [Tiptap's custom extension documentation](https://tiptap.dev/guide/custom-extensions) and [code samples for the core Tiptap extensions](https://github.com/ueberdosis/tiptap/tree/develop/packages) to find out how to write an extension.

If you're providing a new mark or node and intend to use this Bard field on the front-end, you will also need to create a Mark or Node class to be used by the PHP [renderer](#prosemirror-rendering).

:::tip
If you need any other Tiptap helpers or utilities you can use our [Tiptap API](#tiptap-api).
:::

### Replacing Existing Extensions

If you'd like to replace a [native extension](https://github.com/ueberdosis/tiptap/tree/develop/packages) (e.g. headings or paragraphs) you can use the `replaceExtension` method. It takes the `name` of the extension, and a callback that returns a single extension instance.

```js
const { Node } = Statamic.$bard.tiptap.core;  

Statamic.$bard.replaceExtension('heading', ({ extension, bard }) => {
    return Node.create({
        name: 'heading',
        ...
    });
});
```

The callback will provide you with the existing extension instance, so if you are doing simple tweaks to an extension (e.g. customizing an input rule) you can simply extend the existing instance. Then you don't need to author an entire extension:

```js
const { nodeInputRule } = Statamic.$bard.tiptap.core;

Statamic.$bard.replaceExtension('heading', ({ extension, bard }) => {
    return extension.extend({
        addInputRules() {
            return [
                nodeInputRule({...}),
            ];
        },
    });
});
```

You can also reconfigure extensions (e.g. to add tailwind classes to headings):

```js
Statamic.$bard.replaceExtension('heading', ({ extension, bard }) => {
    return extension.configure({
        HTMLAttributes: {
            class: 'font-bold',
        },
    });
});
```

## Buttons

To add a button to the toolbar, provide a callback to the `buttons` method.

The callback will receive two arguments:
- `buttons` - an array of the existing buttons in the toolbar (more about that in a moment)
- `button` - a function that wraps your button objects

The callback may return a `button` object, or an array of them.

``` js
Statamic.$bard.buttons((buttons, button) => {
    return button({
        name: 'custom_bold',
        text: __('Custom Bold'), // Tooltip text
        svg: 'bold', // Name of an SVG icon
        html: '<svg>...</svg>', // Custom icon HTML
        args: { class: 'font-bold' }, // The command arguments
        command: (editor, args) => editor.chain().focus().setCustomBold(args).run(), // The command to run
        activeName: 'customBold', // The active node/mark type that will activate this button (falls back to name)
        active: (editor, args) => editor.isActive('bold'), // Active check callback (overrides activeName)
        visibleWhenActive: 'example', // The active node/mark type that will show this button (always visible if not set)
        visible: (editor, args) => editor.isActive('example'), // Visible check callback (overrides visibleWhenActive)
    });
});
```

``` js
Statamic.$bard.buttons((buttons, button) => [
    button({...}),
    button({...}),
]);
```

Returning values to the `buttons` method will push them onto the end. If you need more control, you can manipulate the supplied `buttons` argument, and then return nothing. For example, we'll add a button after wherever the existing bold button happens to be:

``` js
Statamic.$bard.buttons((buttons, button) => {
    const indexOfBold = _.findIndex(buttons, { name: 'bold' });

    buttons.splice(indexOfBold + 1, 0, button({...}));
});
```

:::tip
Using the `button()` method will make the button only appear if the Bard field has been configured to show your button.

If you'd like your button to appear on all Bard fields, regardless of whether it's been configured to use that button, you can just return an object. Don't wrap with `button()`.
:::

## Tiptap API

In your extensions, you may need to use functions from the `tiptap` library. Rather than importing the library yourself and bloating your JS files, you may use methods through our API.

``` js
Statamic.$bard.tiptap.core; // `tiptap` (core, commands, utillities and helpers)
Statamic.$bard.tiptap.pm.state; // `prosemirror-state`
Statamic.$bard.tiptap.pm.model; // `prosemirror-model`
Statamic.$bard.tiptap.pm.view; // `prosemirror-view`
```

You could shorten things up by using destructuring. For example:

``` js
const { InputRule, insertText, getAttributes } = Statamic.$bard.tiptap.core;
new InputRule(...);
insertText(...);
getAttributes(...);
```

## Tiptap PHP Rendering

If you have created an extension on the JS side to be used inside the Bard fieldtype, you will need to be able to render it on the PHP side (in your views).

The Bard `Augmentor` class is responsible for converting the ProseMirror structure to HTML.

You can use the `addExtension` or `replaceExtension` methods to bind an extension class into the renderer. Your service provider's `boot` method is a good place to do this.

``` php
use Statamic\Fieldtypes\Bard\Augmentor;

public function boot()
{
    // Pass an object
    Augmentor::addExtension('myExtension', new MyExtension);

    // or a closure. You will be passed the bard fieldtype and an array of options as arguments.
    Augmentor::addExtension('myExtension', function ($bard, $options) {
        return new MyExtension(['foo' => $bard->config('should_foo')];
    });

    // Same for replacing extensions.
    Augmentor::replaceExtension('paragraph', new MyCustomParagraph);

    // Closures too. There will be an additional argument at the front which is the existing extension.
    Augmentor::replaceExtension('paragraph', function ($existing, $bard, $options) {
        return new CustomParagraph;
    });
}
```

Check out [code samples for the core Tiptap extensions](https://github.com/ueberdosis/tiptap-php/tree/main/src) to find out how to write PHP extensions.
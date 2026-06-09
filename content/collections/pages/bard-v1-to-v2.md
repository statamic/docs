---
id: dbad308e-fdae-42ed-9168-75521bc5d5fe
blueprint: page
title: 'Upgrade from Bard v1 to v2'
intro: 'A guide for upgrading from Bard v1 to v2.'
template: page
---
## Overview

A new version of Bard (and Tiptap, the library that Bard is built on) was introduced in Statamic 3.4.

There is nothing you need to do to upgrade Bard or Tiptap since they're included in the Statamic upgrade, however if you have any custom extensions, you'll need to make some adjustments.


## JavaScript Extensions

Extensions no longer need to use our wrappers. You can now use regular Tiptap extensions.

Here's how you'd import and bootstrap the extension into Statamic.

```js
import AwesomeExtension from './AwesomeExtension'; // [tl!--]
import { AwesomeExtension } from './AwesomeExtension'; // [tl!++]

Statamic.$bard.addExtension(({ mark }) => mark(new AwesomeExtension)); // [tl!--]
Statamic.$bard.addExtension(() => AwesomeExtension); // [tl!++]
```

Here's just the "container" of your extension (so you don't get overwhelmed by a large diff).

```js
const { Mark } = Statamic.$bard.tiptap.core; // [tl!++]

export default class AwesomeExtension { // [tl!--]
export const AwesomeExtension = Mark.create({ // [tl!++]
    // ...
} // [tl!--]
}) // [tl!++]
```

And here are the various inner parts of the extension. Starting with name now being a property, and should be camelCased:

```js
name() { // [tl! --:start]
    return 'awesome_extension'
} // [tl! --:end]
name: 'awesomeExtension' // [tl! ++]
```

Schema is split into parseHTML and renderHTML:

```js
schema() { // [tl! --:start]
    return {
        parseDOM: [
            { style: 'color: red; font-family: cursive' }
        ],
        toDOM: () => ['span', { style: 'color: red; font-family: cursive' }, 0],
    }
} // [tl! --:end]
parseHTML() { // [tl! ++:start]
    return [
        { style: 'color: red; font-family: cursive' }
    ];
},
renderHTML() {
    return ['span', {style: 'color: red; font-family: cursive'}, 0];
} // [tl! ++:end]
```

All commands are explicitly added by name:

```js
commands({ type, toggleMark }) {// [tl! --:start]
    return () => toggleMark(type)
}// [tl! --:end]
addCommands() {// [tl! ++:start]
    return {
        toggleAwesome: () => ({ commands }) => {
            return commands.toggleMark(this.type);
        }
    }
}// [tl! ++:end]
```

## Buttons

Buttons can largely remain the same. You need to use the new camelCase name, and use a function to call your command manually. In this example we'll use the `toggleAwesome` command defined above.

```js
Statamic.$bard.buttons((buttons, button) => {
    return button({
        name: 'awesome_extension', // [tl! --]
        name: 'awesomeExtension', // [tl! ++]
        text: __('Awesome'),
        command: 'fancy',  // [tl! --]
        command: (editor) => editor.chain().focus().toggleAwesome().run()  // [tl! ++]
    });
});
```

## PHP Extensions

On the PHP side, we no longer use the `prosemirror-to-html` package. We now use the more official `tiptap-php` package. The classes have changed a little.

```php
<?php

namespace App\Bard;

use ProseMirrorToHtml\Marks\Mark; // [tl!--]
use Tiptap\Core\Mark; // [tl!++]
use Tiptap\Utils\HTML; // [tl!++]

class Awesome extends Mark
{
    protected $markType = 'awesome_extension'; // [tl!--]
    public static $name = 'awesomeExtension'; // [tl!++]

    public function tag()  // [tl!--]
    public function renderHTML($mark, $attributes = [])  // [tl!++]
    {
        return [
            [  // [tl!--:start]
                'tag' => 'span',
                'attrs' => [
                    'style' => 'color: red; font-family: cursive'
                ]
            ] // [tl!--:end]
            'span', // [tl!++:start]
            HTML::mergeAttributes([
                'style' => 'color: red; font-family: cursive'
            ], $attributes),
            0 // [tl!++:end]
        ];
    }
}
```

To add or replace extensions, there is no longer a difference between marks and nodes. You now specify the name and pass the extension.

```php
Augmentor::addMark(Awesome::class); // [tl!--]
Augmentor::addExtension('awesome_extension', new Awesome); // [tl!++]

Augmentor::replaceMark(DefaultBold::class, CustomBold::class);  // [tl!--]
Augmentor::replaceExtension('bold', new CustomBold); // [tl!++]
```

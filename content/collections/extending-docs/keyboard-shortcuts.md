---
title: 'Keyboard Shortcuts'
intro: 'Improve usability by adding keyboard shortcuts.'
stage: 4
id: efcca509-5690-4201-88d7-74c542bb9900
---
You may add keyboard shortcuts with a simple syntax, based on the [Mousetrap](https://craig.is/killing/mice) library.

## Basic usage

Bind a keyboard shortcut in a similar way to how you would with Mousetrap. You will get a reference to a Binding object. To unbind, destroy it.

``` js
export default {
    data() {
        return {
            binding: null
        },
    },
    created() {
        this.binding = this.$keys.bind('mod+s', this.save);
    },
    destroyed() {
        this.binding.destroy();
    },
    methods: {
        save() {
            //
        }
    }
}
```

## Unbinding

If you are binding a keyboard shortcut in a component that may disappear - perhaps it's in a stack or modal - you should destroy it once you're done.

When destroying the binding, it will revert back to the previous binding if one existed.

For example: If you're on a form which already uses mod+s to save it, and you open your component which re-binds mod+s, when you destroy your binding, the previous form's binding will kick back into gear.

## Available methods

``` js
this.$keys.bind(keys, fn);
```

Creates a keyboard shortcut binding.
First argument is a [key sequence](#key-sequences), or array of key sequences. Second argument is a function to be executed.
The `Binding` object is returned.

``` js
this.$keys.bindGlobal(keys, fn);
```

Creates a global keyboard shortcut binding.
Works the same as `bind`, except the shortcut will work inside text fields.

## Key sequences

A sequence can be:

- a single key. eg. `/`
- multiple keys together: eg. `shift+/`
- an actual sequence of keys: eg. `up up down down`

## Available keys

For modifier keys you can use `shift`, `ctrl`, `alt`, or `meta`.

You can substitute `option` for `alt` and `command` for `meta`.

Other special keys are `backspace`, `tab`, `enter`, `return`, `capslock`, `esc`, `escape`, `space`, `pageup`, `pagedown`, `end`, `home`, `left`, `up`, `right`, `down`, `ins`, `del`, and `plus`.

Any other key you should be able to reference by name like `a`, `/,` `$,` `*,` or `=.`

> You can use `mod` to mean both `ctrl` on Windows and `cmd` on Mac. This saves you from having to define two separate sequences.

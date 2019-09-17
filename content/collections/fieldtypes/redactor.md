---
title: Redactor
description: A fast, customizable WYSIWYG editor.
overview: 'Redactor is a fast, retina-ready WYSIWYG editor fieldtype. It’s lightweight, customizable, and powerful. Currently using [Redactor 10](https://imperavi.com/assets/pdf/redactor-documentation-10.pdf) you can check out the docs to see what options are available to customize.'
image: /assets/fieldtypes/redactor.png
options:
  -
    name: settings
    type: string
    description: >
      The _name_ of the Redactor setting configuration you want to use.
      If you leave this blank, or specify a name that doesn't exist,
      Statamic will use the first set of settings in the list.
  -
    name: container
    type: string
    description: >
      An asset container ID. When specified, the fieldtype will allow the user to add assets from the specified container.
  -
    name: folder
    type: string
    description: >
      The folder (relative to the asset container) to use when choosing assets. If left blank, the root folder of the container will be used.
  -
    name: restrict_assets
    type: bool
    description: >
      If set to `true`, navigation within the asset browser dialog will be disabled, and you
      will be restricted to the container and folder specified.
id: 25d8be49-2300-42ac-90e4-92df42fc2906
---
## Data Structure {#data-structure}

By design Redactor saves HTML code.

``` .language-yaml
quote: |
  <blockquote>I signed up for Second Life about a year ago. Back then, my life was so great that I literally wanted a second one. Absolutely everything was the same... except I could fly.</blockquote><p>– Dwight Schrute</p>  
```

This is fine, but keep it in mind if you're using it for your `content` field and are using a markdown file.
Statamic automatically parses the `content` field as Markdown within `md` files.


## Redactor.js Configuration {#configuration}

You are able to set any number of predefined Redactor setting configurations. We give you two out of the box, but of
course you are free to modify those and add more.

``` .language-yaml
-
  name: Standard
  settings:
    buttons: [formatting, bold, italic, unorderedlist, orderedlist, html]
-
  name: Basic
  settings:
    buttons: [bold, italic]
```

Each item has a name, which is what you will see when configuring your fieldtype, and the settings themselves.

You can find these Redactor settings in `Configure > Settings > System` or within `site/settings/system.yaml`.

The `settings` value should be a YAML representation of the options object that will get passed into the Redactor jQuery
plugin. You are able to customize all of the Redactor options. You can [view the full list of settings in the Redactor documentation][redactor-docs].

Any settings and options available to the plugin can be set here. For example, if the docs say to use the following configuration object:

``` .language-javascript
$('textarea').redactor({
  formatting: ['p', 'blockquote', 'h2'],
  minHeight: 300
});
```

You would translate to YAML like so:

``` .language-yaml
-
  name: My Redactor Settings
  settings:
    formatting:
      - p
      - blockquote
      - h2
    minHeight: 300
```

*Note: Function type options (eg. callbacks) are not supported.*

[redactor-docs]: https://imperavi.com/assets/pdf/redactor-documentation-10.pdf

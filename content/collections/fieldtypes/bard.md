---
title: Bard
description: "Rich article writing and block-based layouts made easy."
intro: |
  Bard is more than just a content editor, and more flexible than a block-based editor **It is designed to provide a delightful and powerful writing experience** with unparalleled flexibility on your front-end.
screenshot: fieldtypes/bard.jpg
options:
  -
    name: allow_source
    type: boolean
    description: |
      Controls whether the "show source code" button is available to your editors. Default: `true`.
  -
    name: sets
    type: array
    description: An array containing sets of fields. If you don't provide any sets, Bard will act like a basic text/WYSIWYG editor and you won't see the "Add Set" button.
  -
    name: buttons
    type: array
    description: |
      An array of buttons you want available in the toolbar.
      You can choose from `h1`, `h2`, `h3`, `h4`, `h5`, `h6`, `bold`, `italic`, `underline`, `strikethrough`, `unorderedlist`, `orderedlist`, `removeformat`, `quote`, `anchor`, `image`, `table`, `code` (inline), and `codeblock`.

      These are the defaults:
      ![Bard Buttons](/img/fieldtypes/bard-buttons.png) {.mt-4}
  -
    name: target_blank
    type: boolean
    description: |
      Automatically add `target="_blank"` on links by default. You'll be able to override this per-link. Default: `false`.
  -
    name: link_noopener
    type: boolean
    description: |
      Set `rel="noopener"` on all created links. Default: `false`.
  -
    name: link_noreferrer
    type: boolean
    description: |
      Set `rel="noreferrer"` on all created links. Default: `false`.
  -
    name: fullscreen
    type: boolean
    description: |
      Enable the option to toggle into fullscreen mode. Default: `true`.
  -
    name: container
    type: string
    description: >
      An asset container ID. When specified, the fieldtype will allow the user to add a link to an asset from the specified container.
  -
    name: toolbar_mode
    type: string
    description: >
      Choose which style of toolbar you prefer, `fixed` or `floating`. Default: `fixed`.
  -
    name: reading_time
    type: boolean
    description: >
      Show estimated reading time at the bottom of the field. Default: `false`.
  -
    name: save_html
    type: boolean
    description: >
      Save HTML instead of structured data. This simplifies – but limits – control of your template markup. Default: `false`.
  -
    name: always_show_set_button
    type: boolean
    description: >
      Always show the "Add Set" button. Default: `false`.

stage: 1
id: f4bf58d3-cbce-4957-b883-d92fd4791e89
---
## Overview

Bard is our recommended fieldtype for creating long form content from the control panel. It's highly configurable, intuitive, user-friendly, and writes impeccable HTML (thanks to [ProseMirror][prosemirror]).

Bard also has the ability to manage "sets" of fields inline with your text. These sets can contain any number of other fields of any [fieldtype](/fieldtypes), and can be collapsed and neatly rearranged in your content.

## Working With Sets {#sets}

You can use any fieldtypes inside your Bard sets. Make sure to compare the experience with the other meta-fields: [Grid](/fieldtypes/grid) and [Replicator](/fieldtypes/replicator). You can even use Grids and Replicators inside your Bard sets. Just remember that because you can doesn't mean you should. Your UI experience can vary greatly.


## Data Structure

Bard stores your data as a [ProseMirror document](https://prosemirror.net/docs/ref/#model.Document_Structure). You should never need to interact with this data directly, thanks to [augmentation](/augmentation).

## Templating

### Without Sets

If you are using Bard just as a rich text editor and have no need for sets you would use a single tag to render the content.

```
{{ bard_field }}
```

### With Sets

When working with sets, you should use the tag pair syntax and `if/else` conditions on the `type` variable to style each set accordingly. The non-set content uses type `text`.

```
{{ bard_field }}

  {{ if type == "text" }}
    <div class="text">
      {{ text }}
    </div>

  {{ elseif type == "poll" }}
    <figure class="poll">
      <figcaption>{{ question }}</figcaption>
      <ul>
        {{ options }}
          <li>{{ text }}</li>
        {{ /options }}
      </ul>
    </figure>

  {{ elseif type == "hero_image" }}
    <div class="heroimage">
      <img src="{{ hero_image }}" alt="{{ caption }}" />
    </div>
  {{ /if }}

{{ /bard_field }}
```

An alternative approach (for those who like DRY or small templates) is to create multiple "set" partials and pass the data to them dynamically, moving the markup into corresponding partials bearing the set's name.

```
{{ bard_field }}
  {{ partial src="sets/{type}" }}
{{ /bard_field }}
```

``` files
resources/views/partials/sets/
|-- gallery.antlers.html
|-- hero_image.antlers.html
|-- poll.antlers.html
|-- text.antlers.html
`-- video.antlers.html
```

## Extending Bard

Bard uses [TipTap](https://tiptap.dev/) (which in turn is built on top of [ProseMirror][prosemirror]) as the foundation for our quintessential block-based editor.

- Link to [TipTap Extensions](https://tiptap.dev/docs)
- Explain how to bootstrap said extensions and buttons

## Config Options

[prosemirror]: https://prosemirror.net/

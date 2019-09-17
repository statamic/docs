---
title: Bard
description: "Bard is designed for rich post layouts and maxmium flexibility."
overview: |
  <span class="highlight">Bard is designed for rich article layouts</span>. It's more than a content editor, it's practically a layout designer. Bard starts with simple, rich text editor with popup formatting controls. It stores structured data and adds the ability to insert blocks of any arrangement of custom fields amidst the text.

  It's a lot like [Medium's](https://medium.com) editor, but for your own site. It's also 100% compatible with [Replicator's](/fieldtypes/replicator) data structure — you can easily switch between their interfaces if you desire.
image: /assets/fieldtypes/bard.gif
options:
  -
    name: allow_source
    type: boolean _true_
    description: Controls whether the "show source code" button is available to your editors.
  -
    name: sets
    type: array
    description: An array containing sets of fields. If you don't provide any sets, Bard will act like a basic text editor and just save a string.
  -
    name: buttons
    type: array
    description: |
      An array of buttons that should appear in the toolbar. 
      You can choose from `h2` through `h6`, `bold`, `italic`, `underline`, `strikethrough`, `removeformat`, `unorderedlist`, `orderedlist`, `quote`, `superscript`, `subscript`, `anchor`, and `code`.
      By default, a sensible set of buttons will be used.

      [custom]: #custom-buttons
  -
    name: markdown
    type: boolean *false*
    description: |
      _Experimental_. Enabling this option will allow you to author (and save) Markdown. The toolbar, toggle source button, and keyboard shortcuts will be disabled.
  -
    name: spellcheck
    type: boolean *true*
    description: |
      Enable contentEditable's automatic spellcheck.
  -
    name: target_blank
    type: boolean *false*
    description: |
      Automatically add `target="_blank"` on links by default. You'll be able to override this per-link.
  -
    name: link_noopener
    type: boolean *false*
    description: |
      Set `rel="noopener"` on all created links.
  -
    name: link_noreferrer
    type: boolean *false*
    description: |
      Set `rel="noreferrer"` on all created links.
  -
    name: semantic_elements
    type: boolean *false*
    description: |
      Replace unsemantic `<b>` and `<i>` tags with `<strong>` and `<em>` tags.
  -
    name: container
    type: string
    description: >
      An asset container ID. When specified, the fieldtype will allow the user to add a link to an asset from the specified container.
  -
    name: folder
    type: string
    description: >
      The folder (relative to the asset container) to use when choosing an asset. If left blank, the root folder of the container will be used.
  -
    name: restrict_assets
    type: bool
    description: >
      If set to `true`, navigation within the asset browser dialog will be disabled, and you
      will be restricted to the container and folder specified.
added_in: 2.8
id: f4bf58d3-cbce-4957-b883-d92fd4791e89
---
## Usage

At first glance, Bard looks and feels like a simple text editor, but once you start writing you'll realize there's much more to it.

**Clean HTML**: Bard writes clean HTML. It's only allowed a very basic set of tags and aggressively strips anything out. This isn't WYSIWYG. This is better. This is structured content. There's even a code mode so you can take a peek and be sure.

**Formatting Options**: Highlight some text and you get the most commonly used formatting options: bold, italic, link, h2, h3, and blockquote.

**Custom Field Blocks**: Between text paragraphs you can insert blocks of custom content. Most commonly this would be images or videos, but it can be quite literally any combination of one or more [available fieldtypes][fieldtypes] grouped into sets. Just like [Replicator][replicator].

**Drag and Drop Reordering**: Want to rearrange your post layout? Move the images around? Bring your TL;DR from the bottom up to the top? Just drag those blocks around.

**Full Screen Mode**: Like to cut out all possible distractions while you write? No problem.



## Data Structure {#data-structure}

Bard stores your data as an array, exactly like [Replicator][replicator]. Sensing a theme? The default text content will be scoped into `type: text` as HTML content.

```.language-yaml
bard_field:
  -
    type: text
    text: <p>I love it when he plays the saxophone. It gives me all the feels.</p>
  -
    type: image
    image: /assets/img/sax.jpg
    caption: "I want this mounted above my fireplace."
```

## Fieldtypes

You can use any fieldtypes inside your Bard sets. Make sure to compare the experience with the other meta-fields: [Grid](/fieldtypes/grid) and [Replicator](/fieldtypes/replicator). You can even use Grids and Replicators inside your Bard sets. Just remember that because you can doesn't mean you should. Your UI experience can vary greatly.

### Text-only Mode

If you don't configure any additional sets the field data will be saved as a string.
```.language-yaml
bard_field: "<p>Oh hi Mark.</p>"
```

> Please note that you **cannot** name your Bard field "`content`", but go ahead and name it anything else! The `content` field is what's saved in your markdown files below the YAML, and can only contain a string, where Bard would save an array.

## Templating {#templating}

Use tag pair syntax with `if/else` conditions to style each set accordingly.

```
{{ bard_field }}

  {{ if type == "text" }}

    <div class="text">
      {{ text }}
    </div>

  {{ elseif type == "image" }}

    <figure>
      <img src="{{ image }}" alt="{{ caption }}" />
      <figcaption>{{ caption }}</figcaption>
    </figure>

  {{ /if }}

{{ /bard_field }}
```

An alternative approach (for those who like DRY or small templates) is to create multiple "set" partials and pass the data to them dynamically, moving the markup into corresponding partials bearing the set's name.

```
{{ bard_field }}
  {{ partial src="sets/{type}" }}
{{ /bard_field }}
```

```language-files
partials/
|-- sets/
|   |-- gallery.html
|   |-- image.html
|   |-- poll.html
|   |-- text.html
|   |-- video.html
```

## Extending Bard [Since 2.11.0] {#extending-bard}

Bard is powered by [Scribe](https://github.com/guardian/scribe). You are free to extend Bard or the underlying Scribe instances by adding your own plugins. You can do this by pushing a Scribe plugin function into the plugins array:

``` .language-js
Statamic.bard.plugins.push(myPlugin); // where `myPlugin` is a Scribe plugin function.
```

Here's an example of a plugin that converts the selected text into uppercase:

``` .language-js
const uppercasePlugin = function () {
    return function (scribe) {
        var command = new scribe.api.Command('uppercase');

        scribe.commands.uppercase = command;

        command.execute = function () {
            scribe.transactionManager.run(() => {
                const sel = new scribe.api.Selection();
                const range = sel.range;
                sel.placeMarkers();
                const contents = range.extractContents();
                contents.childNodes.forEach(node => node.textContent = node.textContent.toUpperCase());
                range.insertNode(contents);
                sel.selection.removeAllRanges();
                sel.selection.addRange(range);
                sel.removeMarkers();
            });
        };

        command.queryEnabled = function () {
            return true;
        };
    };
};

Statamic.bard.plugins.push(uppercasePlugin);
```


## Custom Buttons {#custom-buttons}

A custom button can be created with a Scribe plugin as described above, combined with a button handler.

The handler should be a function that expects an array of buttons coming from a Bard field's config. You should 
modify this array to include your button. 

Here's an example of just pushing a new button on the end.

``` .language-js
const handler = function (buttons) {
    buttons.push({
      text: 'Uppercase', // Tooltip text when you hover the button
      command: 'uppercase', // The command you defined in your Scribe plugin
      html: '<span>aA</span>', // Either the html contents of the button...
      // icon: 'header', // ...or you can specify a font awesome icon name.
    });
};
Statamic.bard.buttons.push(handler);
```

Here's an example of finding where the config defined `uppercase` and inserting the button there.

``` .language-yaml
my_bard_field:
  type: bard
  buttons:
    - bold
    - uppercase  # button will be inserted here
    - italic
```

``` .language-js
const handler = function (buttons) {
    let i = buttons.indexOf('uppercase');
    buttons.splice(i, 1, { text: 'Uppercase', command: 'uppercase', html: 'aA' });
};

Statamic.bard.buttons.push(handler);
```

[replicator]: /fieldtypes/replicator
[fieldtypes]: /fieldtypes

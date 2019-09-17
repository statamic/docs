---
title: Replicator
description: Build your content by creating sets of fields you can mix and match on the fly.
overview: |
  The Replicator is a meta fieldtype giving you the ability to define _sets_ of fields that you can dynamically piece together in whatever order and arrangement you imagine. You can build long-form articles like [Medium.com](http://medium.com) and take advantage of the extra markup control.

  It's so much better than a WYSIWYG field.
image: /assets/fieldtypes/replicator.jpg
options:
  -
    name: sets
    type: array
    description: An array containing sets of fields.
id: 00b140e3-413a-4d91-b9e7-65f58d56a41b
---
## Usage

You will be presented with a button for each set you’ve defined. Clicking one will replicate an empty set. You can [replicate](https://www.youtube.com/watch?v=qD4EVXkfe0w) a single set type as many times as you like as well as dragging and dropping them to adjust their order.

You may collapse your sets to conserve space. If you do, a preview of the data contained within it will be displayed. [Third party fieldtypes may control how their data will be previewed](/addons/classes/fieldtypes#replicator-preview-text). You can prevent certain fields being shown in the preview text by adding `replicator_preview: false`.

The following fieldset YAML is an example of what could be used to construct the Replicator shown in the screenshot above:

``` language-yaml
fields:
  my_replicator_field:
    type: replicator
    display: Replicator
    sets:
      text:
        display: Text
        fields:
          text:
            type: markdown
      image:
        display: Image
        fields:
          photo:
            type: assets
            container: main
            max_files: 1
          caption:
            type: text
      quote:
        display: Pull Quote
        fields:
          text:
            type: text
          cite:
            type: text
          pull:
            type: radio
            options:
              left: Left Align
              right: Right Align
```
## Fieldtypes

You can use any fieldtypes inside your Replicator sets. Make sure to compare the experience with the other meta-fields: [Grid](/fieldtypes/grid) and [Bard](/fieldtypes/bard).

## Data Structure {#data-structure}

Replicator stores your data as an array with the set name as `type`.

```.language-yaml
my_replicator_field:
  -
    type: text
    text: "Let's talk about the best new show from 2017!"
  -
    type: image
    photo: /assets/night-manager.jpg
    caption: The Night Manager
  -
    type: quote
    text: Such fear, such dread, and such a dazzling script.
    cite: Deborah Ross
    pull: right
```

> Please note that you **can not** use a Replicator fieldtype for the `content` field.

## Templating {#templating}

Use the tag pair syntax with an `if/else` conditions to style each set accordingly.

```
{{ my_replicator_field }}

  {{ if type == "text" }}

    <div class="text">
      {{ text|markdown }}
    </div>

  {{ elseif type == "quote" }}

    <blockquote>{{ text }}</blockquote>
    <p>— {{ cite }}</p>

  {{ elseif type == "image" }}

    <figure>
      <img src="{{ photo }}" alt="{{ caption }}" />
      <figcaption>{{ caption }}</figcaption>
    </figure>

  {{ /if }}

{{ /my_replicator_field }}

```
An alternative, and often cleaner, approach is to have multiple 'set' partials and do:

```
{{ my_replicator_field }}
  {{ partial src="sets/{type}" }}
{{ /my_replicator_field }}
```
Then inside your partials directory you could have:

`sets/image_set.html`
`sets/quote_set.html`

and the set partial may look something like:

```
{{# this is image_set.html #}}

<img src="{{ image }}" alt="{{ caption }}" >
```

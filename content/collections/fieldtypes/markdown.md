---
title: Markdown
description: Our beautiful Markdown editor with preview, assets integration, and more.
intro: Write Markdown with the help of formatting buttons, assets integration, fullscreen mode, a Markdown cheatsheet, and HTML preview mode. What more do you need?
screenshot: fieldtypes/screenshots/v4/markdown.png
id: 607cfe62-7239-461b-8f55-8e7a312c2d5d
related_entries:
  - be292d2b-dc0e-48dc-bce4-0058df27ccc6
options:
  -
    name: antlers
    type: string
    description: >
      Enable Antlers parsing in this field's content.
  -
    name: automatic_line_breaks
    type: boolean
    description: >
      Automatically convert line breaks to `<br>` tags. Default: `true`.
  -
    name: automatic_links
    type: boolean
    description: >
      Automatically links any URLs in the text. Default: `false`.
  -
    name: container
    type: string
    description: |
      Set the name of an [asset container](/assets#containers) to enable browsing, uploading, and inserting assets.
  -
    name: escape_markup
    type: boolean
    description: >
      Escapes inline HTML markup. For example, `<div>` will be replaced with `&lt;div&gt;`. Default: `false`.
  -
    name: folder
    type: string
    description: |
      The folder (relative to the container) to begin browsing. Default: the root folder of the container.
  -
    name: heading_anchors
    type: boolean
    description: |
      Inject anchor links to all of your heading elements (`<h1>`, `<h2>`, etc). Default: `false`.
  -
    name: parser
    type: string
    description: >
      The name of a customized Markdown parser. Leave blank for default.
  -
    name: restrict
    type: bool
    description: >
      If `true`, navigation within the asset browser will be disabled. Your users will be restricted to specified the container and folder. Default: `false`.
  -
    name: smartypants
    type: boolean
    description: >
      Automatically convert straight quotes into curly quotes, dashes into en/em-dashes, and other similar text transformations. Default: `false`.
  -
    name: table_of_contents
    type: boolean
    description: >
      Automatically insert a table of contents at the top of your content with links to your headings. Default: `false`.
---
## Overview

Markdown has been around since 2004. One fateful day in December, [John Gruber](https://daringfireball.net/projects/markdown/) published his spec and first version of the Markdown parser. Since that day (it was a Friday), Markdown has grown wildly in popularity, and today has become the de facto standard format for writing portable content.

Back in 2004 there was just one flavor: John's. Today's landscape has many variations, parsers, extensions, and standards groups. The most widely accepted feature set is [Github-Flavored Markdown][gfm], or GFM for short.

Statamic uses the [League\CommonMark][commonmark] library to support GFM, to enable tables, special attributes like classes and ids on block-level elements, and fenced code blocks.

## Data Structure

The data will be saved exactly as written – a Markdown string.

``` markdown
## Overview

This is the Markdown fieldtype. It's for writing [Markdown](https://daringfireball.net/projects/markdown/), an easy-to-read, easy-to-write plain text format that magically transforms into HTML.
```

## Templating

The Markdown content will be automatically transformed into HTML through [augmentation](/augmentation). You need only use the variable and the rest is done for you.

```
{{ content }}
```

```html
<h2>Overview</h2>
<p>This is the Markdown fieldtype. It's for writing <a href="https://daringfireball.net/projects/markdown/">Markdown</a>, an easy-to-read, easy-to-write plain text format that magically transforms into HTML.</p>
```

## Dark Mode

The Markdown fieldtype also has a dark mode when in fullscreen for those of you who like that sort of thing.

<figure>
    <img src="/img/fieldtypes/screenshots/markdown-dark-mode-v4.png" alt="Dark Mode for Markdown">
    <figcaption><span class="not-italic">😎</span> Sunglasses off.</figcaption>
</figure>



[commonmark]: https://commonmark.thephpleague.com/
[gfm]: https://help.github.com/en/categories/writing-on-github

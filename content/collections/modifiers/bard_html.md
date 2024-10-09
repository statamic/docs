---
id: e2b731c3-13aa-42c8-96f1-9b999a0121e0
blueprint: modifiers
title: 'Bard HTML'
modifier_types:
  - array
  - string
  - utility
---
Converts any Bard data to an HTML string (excluding sets). Bard data can be either:

* The raw value from a Bard field (a ProseMirror document), with or without sets
* One or more ProseMirror nodes (from the [bard_items](bard_items) modifier)

```yaml
main_content:
  -
    type: paragraph
    content:
      -
        type: text
        text: "We're going to build a simple personal website for a fictitious young aspiring programmer named Kurt Logan."
  -
    type: set
    attrs:
      values:
        type: code_block
        code: '<?php Statamic::rocks() ?>'
  -
    type: paragraph
    content:
      -
        type: text
        text: "Kurt always has and always will live in the 1980s and is very excited at the prospect of having his very own place in\_CYBERSPACE."
```

::tabs

::tab antlers
```antlers
{{ main_content | raw | bard_html }}
```
::tab blade
```blade
{{ Statamic::modify($main_content)->bardHtml() }}
```
::

```html
<p>We&#039;re going to build a simple personal website for a fictitious young aspiring programmer named Kurt Logan.</p><p>Kurt always has and always will live in the 1980s and is very excited at the prospect of having his very own place in CYBERSPACE.</p>
```

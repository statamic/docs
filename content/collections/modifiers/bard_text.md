---
id: 5a617e74-0878-4b29-bd39-f1e2496d01cd
blueprint: modifiers
title: 'Bard Text'
modifier_types:
  - array
  - string
  - utility
---
Converts any Bard data to a plain text string (excluding sets).

Bard data can be either:

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

```
{{ main_content | raw | bard_text }}
{{ main_content | raw | bard_text | read_time }}
```

```yaml
string: We're going to build a simple personal website for a fictitious young aspiring programmer named Kurt Logan. Kurt always has and always will live in the 1980s and is very excited at the prospect of having his very own place in CYBERSPACE.
string: 1
```

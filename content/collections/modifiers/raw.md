---
types:
  - string
  - array
  - utility
id: e100a366-b69c-4d59-bec7-eac18c0b286b
---
## Overview
Returns the [unaugmented](/augmentation) version of the variable.

## Example

If you had a Markdown field and wanted to render the actual Markdown-formatted text instead of rendered HTML, you can do this:

### The YAML
```.language-yaml
markdown_field: >
  # How to Breakdance

  First you do the fancy kicky thing with your feets, and then
  you flail your legs around like a battery operated fan at a hot
  summer ballgame.
```

### The Template
```
{{ markdown_field | raw }}
```

### The Output
```
# How to Breakdance

First you do the fancy kicky thing with your feets,
and then you flail your legs around like a battery
operated fan at a hot summer ballgame.
```

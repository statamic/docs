---
title: Code
description: 'Write code and see it highlight. But will you choose spaces or tabs?'
intro: What are you doing writing code in a browser?! Just kidding, it's fine. We made it easy, flexible, and pretty too. We use this fieldtype a lot.

screenshot: fieldtypes/screenshot/code.png
options:
  -
    name: theme
    type: string
    description: |
      Choose between `light` and `material` (dark) themes. Default: `light`.
  -
    name: mode
    type: string
    description: |
      Set a language for syntax highlighting. Your choices include:

      - `clike`
      - `css`
      - `diff`
      - `go`
      - `haml`
      - `handlebars`
      - `htmlmixed`
      - `less`
      - `markdown`
      - `gfm`
      - `nginx`
      - `text/x-java`
      - `javascript`
      - `jsx`
      - `text/x-objectivec`
      - `php`
      - `python`
      - `ruby`
      - `scss`
      - `shell`
      - `sql`
      - `twig`
      - `vue`
      - `xml`
      - `yaml-frontmatter`
  -
    name: indent_type
    type: string
    description: |
      Choose between `tabs` and `spaces`. Choose wisely. Default: `tabs`.
  -
    name: indent_size
    type: integer
    description: |
      Set your preferred indentation size (in spaces). Default: `4`.
  -
    name: line_numbers
    type: boolean
    description: |
      Show line numbers.
  -
    name: line_wrapping
    type: boolean
    description: |
      Enable to wrap long lines of code instead of showing a horizontal scroll. Default: `true`.
  -
    name: key_map
    type: string
    description: |
      Pick your preferred set of keyboard shortcuts. Choose between `default`, `sublime`, and `vim`. We'll let you guess which one is default.
stage: 4
id: 3ca28569-5b86-49a1-b620-ea3364561cde
---
## Overview

If your content involves code snippets, this is the fieldtype for you. It's a [CodeMirror](https://codemirror.net) field with 25 of the most common languages ready for highlighting, handles tabs and spaces, has a dark mode, and best of all — for you super nerds out there — a vim key binding.

## Data Structure

The code fieldtype stores a string. Do whatever you'd like with it.

``` yaml
code: |
  <?php

  public function engage()
  {
    return "Make it so.";
  }
```

## Templating

You can output that string just as it is. If it is indeed code (and why wouldn't it be?), you'll probably want to to wrap it in pre and code tags to display it prettier. If you want code highlighting on your front-end, we recommend hooking up [prism.js](https://prismjs.com).

```
<pre><code>{{ your_code_field }}</code></pre>
```

### Variables

Inside an asset variable's tag pair you'll have access to the following variables.

| Variable | Description |
|----------|-------------|
| `key` | The zero-index count of the current item |
| `value` | The stored value of the checkbox |
| `label` | The label of the checkbox item from the field config |



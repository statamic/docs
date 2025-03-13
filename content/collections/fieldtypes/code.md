---
title: Code
description: 'Write code and see it highlight. But will you choose spaces or tabs?'
intro: What are you doing writing code in a browser?! Just kidding, it's fine. We made it easy, flexible, and pretty too. We use this fieldtype a lot.

screenshot: fieldtypes/screenshots/code.png
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
      Set a default language for syntax highlighting. Your choices include:

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
    name: mode_selectable
    type: boolean
    description: |
      Whether the `mode` can be selected by the user in the publish form. Enabling this will change the GraphQL
      type from a string to a Code type.
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
  -
    name: rulers
    type: array
    description: |
      You can set the columns and the line style (choose between `dashed` or `solid`) of any rulers you wish to use.
stage: 4
id: 3ca28569-5b86-49a1-b620-ea3364561cde
---
## Overview

If your content involves code snippets, this is the fieldtype for you. It's a [CodeMirror](https://codemirror.net) field with 25 of the most common languages ready for highlighting, handles tabs and spaces, has a dark mode, and best of all — for you super nerds out there — a vim key binding.

## Data Structure

The code fieldtype stores a string. Do whatever you'd like with it.

``` yaml
code_snippet: |
  <?php

  public function engage()
  {
    return "Make it so.";
  }
```

If you've enabled the `mode_selectable` option, an array will be saved with `code` and `mode` in it.

```yaml
code_snippet:
  mode: php
  code: |
    <?php

    public function engage()
    {
        return "Make it so.";
    }
```

## Templating

You can output that string just as it is. If it is indeed code (and why wouldn't it be?), you'll probably want to to wrap it in pre and code tags to display it prettier. If you want code highlighting on your front-end, we recommend hooking up [prism.js](https://prismjs.com).

::tabs

::tab antlers

```antlers
<pre><code>{{ code_snippet }}</code></pre>
```

::tab blade

```blade
<pre><code>{!! $code_snippet !!}</code></pre>
```

::

You're also able to use it as an array if you want to output the mode.

::tabs

::tab antlers

```
{{ code_snippet }}
<pre class="language-{{ mode }}"><code>{{ code }}</code></pre>
{{ /code_snippet }}
```

::tab blade

```blade
<pre class="language-{{ $code_snippet['mode'] }}"><code>{!! $code_snippet['code'] !!}</code></pre>
```

::

### Variables

Inside an code fieldtype's tag pair you'll have access to the following variables.

| Variable | Description |
|----------|-------------|
| `code` | The contents of the field. |
| `mode` | The selected language mode. |

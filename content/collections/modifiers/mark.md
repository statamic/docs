---
id: 390ae639-0964-4d51-b7ed-efd3b810913c
blueprint: modifiers
title: Mark
modifier_types:
  - string
  - utility
---
Wrap any matched words in `<mark>` tags to highlight them on the page.

```yaml
description: This cat video is the okayest thing ever.
```

::tabs

::tab antlers
```antlers
{{ description | mark('cat thing') }}
{{ description | mark('video', 'class:highlight') }}
```
::tab blade
```blade
{!! Statamic::modify($description)->mark('cat thing') !!}
{!! Statamic::modify($description)->mark('video', 'class:highlight') !!}
```
::

```html
This <mark>cat</mark> video is the okayest <mark>thing</mark> ever.
```

```html
This cat <mark class="highlight">video</mark> is the okayest thing ever.
```

If no words are specified the `get:q` value will be used by default.

:::tip
This modifier expects HTML input. While most plain text strings will work just fine you should escape the value with the `entities` modifier if your text contains less than or greater than symbols: `{{ plain_text | entities | mark }}`
:::
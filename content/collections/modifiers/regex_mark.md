---
id: 053e62e4-be01-4e82-944d-fe72b18a1a7c
blueprint: modifiers
title: 'Regex Mark'
modifier_types:
  - string
  - utility
---
Wrap any regex matches in `<mark>` tags to highlight them on the page.

```yaml
description: This cat video is the okayest thing ever.
```

::tabs

::tab antlers
```antlers
{{ description | regex_mark('cat video|thing') }}
{{ description | regex_mark('video', 'class:highlight') }}
```
::tab blade
```blade
{!! Statamic::modify($description)->regexMark('cat video|thing') !!}
{!! Statamic::modify($description)->regexMark(['video', 'class:highlight']) !!}
```
::

```html
This <mark>cat video</mark> is the okayest <mark>thing</mark> ever.
```

```html
This cat <mark class="highlight">video</mark> is the okayest thing ever.
```

:::tip
This modifier expects HTML input. Escape plain text containing less-than or greater-than symbols before matching: `{{ plain_text | entities | regex_mark('pattern') }}`.
:::

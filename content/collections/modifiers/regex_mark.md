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

```
{{ description | regex_mark('cat video|thing') }}
{{ description | regex_mark('video', 'class:highlight') }}
```

```html
This <mark>cat video</mark> is the okayest <mark>thing</mark> ever.
```

```html
This cat <mark class="highlight">video</mark> is the okayest thing ever.
```

:::tip
This modifier expects HTML input. While most plain text strings will work just fine you should escape the value with the `entities` modifier if your text contains less than or greater than symbols: `{{ plain_text | entities | mark }}`
:::
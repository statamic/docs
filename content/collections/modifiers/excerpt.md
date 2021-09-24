---
id: 051ecd7b-1cf7-4b47-b8c1-cfcede33289f
blueprint: modifiers
title: Excerpt
intro: 'Generate an excerpt from your content.'
modifier_types:
  - string
---
Breaks a string at a given marker. Uses `<!--more-->` by default.

```yaml
---
title: 'Example Entry'
---
Lorem Ipsum dolor sit amet.<!--more--> consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Massa id neque aliquam vestibulum.
```

```
{{ books | excerpt }}
```

```html
Lorem Ipsum dolor sit amet.
```

You can override the marker by passing an alternative as the first parameter:

```
{{ books | excerpt:<!-- end --> }}
```

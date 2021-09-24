---
id: 287d14d7-6660-4ac6-aa1b-0ca4d298cdcc
blueprint: modifiers
modifier_types:
  - string
title: Smartypants
---
Translate plain ASCII punctuation characters into “smart” typographic punctuation HTML entities. It performs the following transformations:

- Straight quotes (`"` and `'`) into “curly” quote HTML entities
- Backticks-style quotes (&#96;&#96;like this\'\') into “curly” quote HTML entities
- Two dashes (`--`) into an em dash.
- Three consecutive dots (`...`) into an ellipsis entity

```yaml
conversation: |
  "What's your favorite album?" asked Lars. ``...And Justice for All'' replied
  Kirk -- who was icing his hands after a 20 minute guitar solo.
```

```
{{ conversation | smartypants }}
```

```html
“What’s your favorite album?” asked Lars. “…And Justice for All” replied
Kirk — who was icing his hands after a 20 minute guitar solo.
```

or more precisely...

```html
&#8220;What&#8217;s your favorite album?&#8221; asked Lars. &#8220;&#8230;And Justice for All&#8221; replied
Kirk &#8212; who was icing his hands after a 20 minute guitar solo.
```

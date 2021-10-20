---
id: d464d979-7e57-40a6-8892-a08d08bd7ccf
blueprint: modifiers
modifier_types:
  - array
  - utility
title: Plural
---
Get the plural form of an English word. Accepts a numerical parameter, either as a literal value or a variable, to control plurality. It's important to note that you should use the singular form of the word to ensure the best results.

```yaml
shopping_list:
  - item: pickle
    quantity: 1
  - item: apple
    quantity: 12
  - item: donut
    quantity: 500
```

```
Please pick up the following items:
{{ shopping_list }}
  - {{ quantity }} {{ item | plural:quantity }}.
{{ /shopping_list }}
```

```html
Please pick up the following items:
- 1 pickle
- 3 apples
- 500 donuts
```

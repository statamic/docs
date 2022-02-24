---
id: 5ee6e776-5361-4d87-9227-c0461e33853f
blueprint: modifiers
modifier_types:
  - array
  - string
  - utility
title: Reverse
---
Reverse the order of the characters in a string or the items in an array.

```yaml
status: repaid
order_of_ceremony:
  - photos
  - service
  - eat
  - party
```

```
{{ status | reverse }}
{{ order_of_ceremony | reverse | list }}
```

```html
diaper
party, eat, service, photos
```

---
types:
  - string
  - utility
id: 5ee6e776-5361-4d87-9227-c0461e33853f
---
Reverse the order of the characters in a string or the items in an array.

```.language-yaml
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

```.language-output
diapers
party, eat, service, photos
```

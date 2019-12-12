---
id: d9ae0cd6-a94e-44d7-b748-5506fa2e5ae7
types:
  - system
---
Since you don't always know how many segments your URL will have, you can always grab the last segment.

Example URL: `/nestled/safely/under/our/tree`

```
{{ last_segment }}
```

``` .language-output
tree
```

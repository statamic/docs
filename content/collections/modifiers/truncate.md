---
types:
  - string
id: cc80cc58-f73a-47fd-8f4d-e1cfc23c5d56
---
Truncates the string to a given length (parameter 1). You can append a string with parameter 2, and if truncating occurs the string is further truncated so that it may be appended without exceeding the desired length.

This differs from [safe_truncate][safe_truncate] in that it _may_ truncate in the middle of a word.

```.language-yaml
advice: >
  So, here’s some advice I wish I woulda got when I was your age:
  Live every week like it’s Shark Week.
```

```
{{ advice | truncate:90:... }}
```

```.language-output
So, here’s some advice I wish I woulda got when I was your age:
Live every week like i...
```

[safe_truncate]: /modifiers/safe_truncate

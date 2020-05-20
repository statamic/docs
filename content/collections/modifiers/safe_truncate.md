---
modifier_types:
  - string
id: 1267d7b0-8a07-4103-9570-86327fb8e250
---
Truncates the string to a given length (parameter 1), while ensuring that
it does not split words. You can append a string with parameter 2, and if truncating occurs the string is further truncated so that it may be appended without exceeding the desired length.

```.language-yaml
advice: >
  So, here’s some advice I wish I woulda got when I was your age:
  Live every week like it’s Shark Week.
```

```
{{ advice | safe_truncate:90:... }}
```

```.language-output
So, here’s some advice I wish I woulda got when I was your age:
Live every week like...
```

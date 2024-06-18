---
id: 63acdaa6-9724-4179-b210-ea5d507672e9
blueprint: modifiers
modifier_types:
  - array
  - markup
  - string
title: Shuffle
related_entries:
  - 48178377-da99-4754-ae9e-d294720cff33
---
Shuffles a string or an array to make it all random.

```yaml
string: Mr. Roboto was the original hipster.
array:
  - Sonic
  - Knuckles
  - Tails
```

```
{{ string | shuffle }}
{{ array | shuffle }}
```

```yaml
string: a nhglRsws.oMtiotr hprriao eeo.b ti
array:
  - Tails
  - Knuckles
  - Sonic
```

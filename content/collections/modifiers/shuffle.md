---
modifier_types:
  - array
  - markup
id: 63acdaa6-9724-4179-b210-ea5d507672e9
---
Shuffles a string or an array to make it all random.

```.language-yaml
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

```.language-yaml
string: a nhglRsws.oMtiotr hprriao eeo.b ti
array:
  - Tails
  - Knuckles
  - Sonic
```

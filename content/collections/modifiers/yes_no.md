---
types:
  - string
  - utility
  - conditions
id: 3773fc46-e5f2-4a87-8f68-4ac906bca50d
---
A ternary-esque syntax for outputting `yes` if true, `no` if false. Both values can be customized by passing additional parameters. Also supports `?` as shorthand.

```.language-yaml
foo: true
bar: false
```

```
{{ foo | yes_no }}
{{ bar | yes_no }}
{{ foo | yes_no:yep:nah }}
{{ bar | yes_no:yep:nah }}
{{ foo | ?:yep:nah }}
{{ bar | ?:yep:nah }}
```

```.language-output
yes
no
yep
nah
yep
nah
```

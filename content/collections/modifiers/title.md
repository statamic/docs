---
modifier_types:
  - string
id: 2293d024-32ad-4bb6-a7ff-46ec2e1d9f2f
---
Returns a trimmed string with the first letter of each word capitalized, ignoring articles, coordinating conjunctions, and short propositions: `a`, `an`, `the`, `at`, `by`, `for`, `in`, `of`, `on`, `to`, `up`, `and`, `as`, `but`, `or`, and `nor`.

```.language-yaml
string: It was one of the best adventures of my life
```

```
{{ string | title }}
```

```.language-output
It Was One of the Best Adventures of My Life
```

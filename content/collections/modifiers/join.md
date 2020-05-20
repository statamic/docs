---
modifier_types:
  - string
  - array
  - utility
id: 9dfc5020-3d14-4774-a1f6-d82d051cb964
---
Turn an array into a string by gluing together all the data with any specified delimiter. It uses a comma by default.

```.language-yaml
tasks:
  - take a shower
  - brush hair
  - clip toenails
```

```
{{ tasks | join }}
{{ tasks join=" + " }} = ready
```

```.language-output
take a shower, brush hair, clip toenails
take a shower + brush hair + clip toenails = ready
```

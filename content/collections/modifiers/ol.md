---
types:
  - array
  - markup
id: 327f4a3b-04d4-4069-881a-fe50ddb9be23
---
Turn an array into an HTML ordered list element.

```.language-yaml
food:
  - sushi
  - broccoli
  - kale
```

```
{{ food | ol }}
```

```.language-output
<ol>
  <li>sushi</li>
  <li>broccoli</li>
  <li>kale</dd>
</ol>
```

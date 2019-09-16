---
types:
  - string
  - array
id: c3d3e2c4-218e-4841-a594-647f10863866
---
Breaks a string into an array of strings split on a given delimiter.

```.language-yaml
places: Scotland, England, Switzerland, Italy
```

```
{{ places | explode:, | ul }}
```

```.language-html
<ul>
  <li>Scotland</li>
  <li>England</li>
  <li>Switzerland</li>
  <li>Italy</li>
</ul>
```

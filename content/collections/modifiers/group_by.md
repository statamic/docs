---
types:
  - array
id: a070fabe-c413-4b31-9cb4-ad14bbe1aa4d
---
Group an array's items by a given key.

```.language-yaml
sponsors:
  -
    sport: basketball
    team: Jazz
  -
    sport: baseball
    team: Yankees
  -
    sport: basketball
    team: Bulls
```

```
{{ sponsors group_by="sport" }}
  {{ basketball }}
    <h2>{{ team }}</h2>
  {{ /basketball
{{ /sponsors }}
```

```.language-output
<h2>Jazz</h2>
<h2>Bulls</h2>
```

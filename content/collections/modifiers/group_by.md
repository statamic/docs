---
id: a070fabe-c413-4b31-9cb4-ad14bbe1aa4d
blueprint: modifiers
modifier_types:
  - array
title: 'Group By'
---
Group an array's items by a given key.

```yaml
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

```html
<h2>Jazz</h2>
<h2>Bulls</h2>
```

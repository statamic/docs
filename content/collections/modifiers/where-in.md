---
id: c1141498-eff1-4fab-b24b-4d942784a748
blueprint: modifiers
modifier_types:
  - conditions
  - array
title: 'Where In'
duplicated_from: c36a6f62-aaf4-478b-a469-29cdb1eab8dc
---
Filter an array (such as a Replicator field's data) to items where a `key` matches specific `values`.

```yaml
games:
  -
    feeling: love
    title: Dominion
  -
    feeling: happy
    title: Netrunner
  -
    feeling: hate
    title: Chutes and Ladders
```

```
<h2>I love...</h2>
{{ games | where_in('feeling', ['love', 'happy']) }}
  {{ title }}<br>
{{ /games }}
```

```html
Dominion
Netrunner
```
---
id: c36a6f62-aaf4-478b-a469-29cdb1eab8dc
blueprint: modifiers
modifier_types:
  - conditions
  - array
title: Where
---
Filter an array (such as a Replicator field's data) to items where a `key` has a specific `value`.

```yaml
games:
  -
    feeling: love
    title: Dominion
  -
    feeling: love
    title: Netrunner
  -
    feeling: hate
    title: Chutes and Ladders
```

```
<h2>I love...</h2>
{{ games | where('feeling', 'love') }}
  {{ title }}<br>
{{ /games }}
```

```html
Dominion
Netrunner
```

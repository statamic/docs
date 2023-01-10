---
id: 17075d87-df8f-4ab7-b957-67cdae80ac0a
blueprint: modifiers
title: Pluck
modifier_types:
  - array
  - utility
---
Retrieves the values of a given `key` from each item.

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
{{ games | pluck('title') }}
```

```yaml
games:
  - Dominion
  - Netrunner
  - Chutes and Ladders
```
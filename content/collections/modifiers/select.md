---
id: 864d101a-c0a2-42d8-a644-80440316de8b
blueprint: modifiers
title: Select
modifier_types:
  - array
  - utility
---
Retrieves the selected values of a given array.

```yaml
games:
  -
    feeling: love
    title: Dominion
    publisher: Rio Grande Games
  -
    feeling: love
    title: Netrunner
    publisher: Wizards of the Coast
  -
    feeling: hate
    title: Chutes and Ladders
    publisher: Unknown
```

```
{{ games | select('title', 'publisher') }}
```

```yaml
-
    title: Dominion
    publisher: Rio Grande Games
-
    title: Netrunner
    publisher: Wizards of the Coast
-
    title: Chutes and Ladders
    publisher: Unknown
```

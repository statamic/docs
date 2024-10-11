---
id: c1141498-eff1-4fab-b24b-4d942784a748
blueprint: modifiers
modifier_types:
  - conditions
  - array
title: 'Where In'
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

::tabs

::tab antlers
```antlers
<h2>I love...</h2>
{{ games | where_in('feeling', ['love', 'happy']) }}
  {{ title }}<br>
{{ /games }}
```
::tab blade
```blade
<?php
    $filteredGames = Statamic::modify($games)->whereIn('feeling', ['love', 'happy'])->fetch();
?>

<h2>I love...</h2>
@foreach ($filteredGames as $game)
  {{ $game['title'] }}
@endforeach
```
::

```html
Dominion
Netrunner
```

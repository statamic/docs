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

::tabs

::tab antlers
```antlers
<h2>I love...</h2>
{{ games | where('feeling', 'love') }}
  {{ title }}<br>
{{ /games }}
```
::tab blade
```blade
<?php
  $filteredGames = Statamic::modify($games)
    ->where(['feeling', 'love'])
    ->fetch();
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

You can also pass an operator to the modifier, so you can do checks like "where not" and "where greater than". Under the hood, this uses [the `where` method of Laravel Collections](https://laravel.com/docs/12.x/collections#method-where), so you can use any operators it supports.

```
<h2>I hate...</h2>
{{ games | where('feeling', '!=', 'love') }}
  {{ title }}<br>
{{ /games }}
```

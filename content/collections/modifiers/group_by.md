---
id: a070fabe-c413-4b31-9cb4-ad14bbe1aa4d
blueprint: modifiers
modifier_types:
  - array
title: 'Group By'
---
## Overview

You may use this modifier to group items (a simple array, a collection of entries, etc) into groups
based on some common value.

## By Key

The most basic usage example would be to take a simple array and output the groups using the key.

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
  <h1>Basketball</h2>
  {{ basketball }}
    {{ team }}
  {{ /basketball }}

  <h1>Baseball</h2>
  {{ baseball }}
    {{ team }}
  {{ /baseball }}
{{ /sponsors }}
```

```html
<h1>Basketball</h1>
Jazz
Bulls

<h1>Baseball</h1>
Yankees
```

## Looping Over Groups
In the previous example, you had to know that there was going to be `basketball` and `baseball` keys ahead of time.

If you don't know the groups, you can loop over the `groups` variable.
It will be an array containing the name of the `group` and its `items`.

```
{{ sponsors group_by="sport" }}
    {{ groups }}
        <h1>{{ group | upper }}</h1>
        {{ items }}
            {{ team }}
        {{ /items }}
    {{ /groups }}
{{ /sponsors }}
```

## Nested Values
If you need to get a nested value for the groups, you can use the familiar colon syntax.

For example, you may have an `entries` field where you've selected entries from multiple collections, and you want to group by the collection's title.

```yaml
menu_items:
  - burger
  - fries
  - coke
  - pepsi
```
```
{{ menu_items group_by="collection:title" }}
    {{ groups }}
        <h2>{{ group }}</h2>
        {{ items }}
            {{ title }}
        {{ /items }}
    {{ /groups }}
{{ /menu_items }}
```
```
<h2>Food</h2>
Burger
Fries

<h2>Drinks</h2>
Coke
Pepsi
```

## Dates

You may group entries by a date field.

For example, you might want to output articles and group them by month.

Here we'll group them by the `date` field using the `F Y` [PHP date format](https://www.php.net/manual/en/datetime.format.php) which
would output as "Month Year".

```
{{ collection:articles as="entries" }}
    {{ entries group_by="date|F Y" }}
        {{ groups }}
            <h1>{{ group }}</h1>
            {{ items }}
                {{ title }}
            {{ /items }}
        {{ /groups }}
    {{ /entries }}
{{ /collection:articles }}
```

```
<h1>September 2021</h1>
Entry from September
Another entry from September

<h1>October 2021</h1>
Entry from October
```

> The date field in this example is named `date`, but you can use any date field.
> ```
> {{ entries group_by="custom_date_field|F Y" }}
> ```

If you need the key to differ from how it's displayed (perhaps you want to use an additional modifier after), you can pass another date format as the
third argument. (Argument 2 creates the key, argument 3 creates the `{{ group }}` text).

```
{{ entries group_by="date|Y-m|F Y" }}
```

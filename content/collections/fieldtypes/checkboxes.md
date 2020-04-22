---
title: Checkboxes
description: Boxes you check!
intro: >
  Checkboxes! Make some checkboxes, click the checkboxes, and store a record of which boxes of which ones you clicked. They're boxes you check.
screenshot: fieldtypes/checkboxes.png
options:
  -
    name: inline
    type: bool
    description: >
      Show the checkboxes next to each other in a row instead of stacked vertically. Default: `false`
  -
    name: options
    type: array
    description: >
      Sets of key/value pairs define the values and labels of the checkbox options.
stage: 2
id: f922cb9b-6fc9-4249-adf4-59aa46285c13
---
## Overview

The checkboxes fieldtype is a multiple choice input. It saves one or more options chosen from a preset list. In other words, they're boxes you check.

## Configuring

Use the `options` setting to define a list of values and labels.

``` yaml
favorites:
  type: checkboxes
  instructions: Choose up to 3 favorite foods.
  options:
    donuts: Donuts
    icecream: Ice Cream
    brownies: Brownies
```

You may omit the labels and just specify keys. If you use this syntax, the value and label will be identical.

``` yaml
  options:
    - Donuts
    - Ice Cream
    - Brownies
```

## Data Structure

The values are stored as a YAML array. If you only specified values for the `options` array, then the labels will be saved.

``` yaml
favorites:
  - donuts
  - icecream
```



## Templating

You can loop through the checked items and access the value and label of each item inside the loop.

```
<ul>
{{ favorite }}
    <li>{{ value }}</li>
{{ /favorite }}
</ul>
```

``` output
<ul>
    <li>donuts</li>
    <li>icecream</li>
</ul>
```

### Variables

Inside an asset variable's tag pair you'll have access to the following variables.

| Variable | Description |
|----------|-------------|
| `key` | The zero-index count of the current item |
| `value` | The stored value of the checkbox |
| `label` | The label of the checkbox item from the field config |

## Config Options

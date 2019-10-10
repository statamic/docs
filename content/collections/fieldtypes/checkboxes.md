---
title: Checkboxes
description: Manage an array of boolean values with checkboxes.
overview: >
  Create — you guessed it — checkboxes! The selected checkboxes are stored as an array. Keep that in mind when using the data in your templates.
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
      Sets of key/value pairs that define the values and labels of the checkbox options.
stage: 3
id: f922cb9b-6fc9-4249-adf4-59aa46285c13
---
## Overview

The checkboxes fieldtype is a multiple choice input. It saves one or more options chosen from a preset list. In other words, they're boxes that you check.

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

The values in the screenshot would saved as YAML array:

``` yaml
favorites:
  - donuts
  - icecream
```

If you only specified values for the `options` array, then the labels will be saved.

``` yaml
favorites:
  - Donuts
  - Ice Cream
```

## Templating

_This fieldtype is not [augmented](/augmentation)._

Since the data is saved as a simple array, you can use a tag pair to iterate over the `values`.

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

## Config Options

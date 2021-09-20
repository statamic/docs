---
title: Radio
description: 'Circles you click. You can only choose one.'
intro: |
  Radio buttons. The "you can only have one" variation of checkboxes. Create some options and let your users select one and only one. May they choose wisely.

screenshot: fieldtypes/radio.png
options:
  -
    name: inline
    type: bool
    description: |
      Show the radio buttons next to each other in a row instead of stacked vertically. Default: `false`

  -
    name: options
    type: array
    description: 'Sets of key/value pairs define the values and labels of the radio options.'
stage: 4
id: 0b662f17-1cd1-4c64-a705-980a2ca5aab4
---
## Overview

The radio fieldtype is a multiple choice input where you only get one choice. It saves the chosen option from a preset list.

## Configuring

Use the `options` setting to define a list of values and labels.

``` yaml
favorite:
  type: radio
  instructions: Choose your favorite food.
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

The chosen option is stored as a string. If you only specified values for the `options` array, then the label will be saved.

``` yaml
favorite: brownies
```



## Templating

It's a string, so you can just use that value.

```
<p>I love {{ favorite }}. A lot.</p>
```

``` output
<p>I love donuts. A lot.</p>
```



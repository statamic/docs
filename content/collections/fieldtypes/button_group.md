---
title: 'Button Group'
description: 'Buttons you click. You can only choose one.'
intro: |
  Buttons. Create some options and let your users select one and only one. May they choose wisely.
screenshot: fieldtypes/screenshots/button_group.png
options:
  -
    name: clearable
    type: boolean
    description: |
      Allow deselecting all options, making `null` a possible value. Default: `false`.
  -
    name: options
    type: array
    description: 'Sets of key/value pairs define the values and labels of the buttons.'
stage: 4
id: 26751221-fdc8-47c6-97f0-bf4997319482
---
## Overview

The button group fieldtype is a multiple choice input where you only get one choice. It saves the chosen option from a preset list.

## Configuring

Use the `options` setting to define a list of values and labels.

``` yaml
seat_choice:
  type: button_group
  instructions: Choose your airline seat. Choose wisely.
  options:
    left: Left
    middle: Middle
    right: Right
```

You may omit the labels and just specify keys. If you use this syntax, the value and label will be identical.

``` yaml
  options:
    - Left
    - Middle
    - Right
```

## Data Structure

The chosen option is stored as a string. If you only specified values for the `options` array, then the label will be saved.

``` yaml
seat_choice: middle
```



## Templating

It's a string, so you can just use that value.

::tabs

::tab antlers

```
<p>I love sitting in the {{ seat_choice }} seat. A lot.</p>
```

::tab blade

```blade
<p>I love sitting in the {{ $seat_choice }} seat. A lot.</p>
```

::

```html
<p>I love sitting in the middle seat. A lot.</p>
```



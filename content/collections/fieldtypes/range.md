---
title: Range
description: 'Choose a number between a min and max value.'
intro: |
  Range fields let the user choose a numeric value which must be _no less_ than a given value, and _no more_ than another.

screenshot: fieldtypes/range.png
options:
  -
    name: min
    type: integer
    description: |
      The minimum, left-most value. Default `0`.
  -
    name: max
    type: integer
    description: |
      The maximum, left-most value. Default `1000`.
  -
    name: step
    type: integer
    description: |
      The minimum size between values. Default `1`.
  -
    name: append
    type: string
    description: |
      Add text to the end (right-side) of the rage slider.
  -
    name: prepend
    type: string
    description: |
      Add text to the beginning (left-side) of the rage slider.
stage: 4
id: 5ede219c-607e-4ad2-8498-6ca55a063e73
---
## Data Structure

The value is stored as an integer.

``` yaml
number: 42
```

## Templating

Use the variable in your templates to display the value. That's pretty much it.

```
<p>My favorite number is {{ number }}.</p>
```

``` output
<p>My favorite number is 42.</p>
```



---
title: Range
description: 'Choose a number between a min and max value.'
intro: |
  Range fields let the user choose a numeric value which must be _no less_ than a given value, and _no more_ than another. Supports both integer and decimal values.

screenshot: fieldtypes/screenshots/v6/range.webp
screenshot_dark: fieldtypes/screenshots/v6/range-dark.webp
options:
  -
    name: min
    type: number
    description: |
      The minimum, left-most value. Supports decimals. Default `0`.
  -
    name: max
    type: number
    description: |
      The maximum, right-most value. Supports decimals. Default `100`.
  -
    name: step
    type: number
    description: |
      The minimum size between values. Supports decimals (e.g., `0.1` for tenths, `0.01` for hundredths). Default `1`.
  -
    name: append
    type: string
    description: |
      Add text to the end (right-side) of the range slider.
  -
    name: prepend
    type: string
    description: |
      Add text to the beginning (left-side) of the range slider.
id: 5ede219c-607e-4ad2-8498-6ca55a063e73
---
## Data Structure

The value is stored as an integer or float, depending on your field configuration.

If your `min`, `max`, and `step` are all integers, the value will be stored as an integer:

``` yaml
number: 42
```

If any of `min`, `max`, or `step` contain decimal values, the value will be stored as a float:

``` yaml
opacity: 0.75
temperature: 21.5
```

## Example Configurations

### Integer Range (Default)

``` yaml
fields:
  age:
    type: range
    min: 0
    max: 100
    step: 1
```

### Decimal Range

For values like percentages, opacity, or other decimal values:

``` yaml
fields:
  opacity:
    type: range
    min: 0
    max: 1
    step: 0.1
  temperature:
    type: range
    min: -10.5
    max: 42.5
    step: 0.5
    append: '°C'
```

## Templating

Use the variable in your templates to display the value. That's pretty much it.

::tabs

::tab antlers
```antlers
<p>My favorite number is {{ number }}.</p>
```

::tab blade
```blade
<p>My favorite number is {{ $number }}.</p>
```
::

```html
<p>My favorite number is 42.</p>
```



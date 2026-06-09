---
title: Float
description: 'For when all you want is decimal numbers.'
intro: 'The float fieldtype is a text-style input that only accepts floats (numbers) and has increment and decrement controls.'
screenshot: fieldtypes/screenshots/v6/float.webp
screenshot_dark: fieldtypes/screenshots/v6/float-dark.webp
id: 3dcf9495-9a02-4044-b6bb-428b7ff23807
options:
  -
    name: append
    type: string
    description: >
      Add text after (to the right of) the float input.
  -
    name: prepend
    type: string
    description: >
      Add text to the beginning (to the left of) the float input.
  -
    name: placeholder
    type: int
    description: >
      Set a default placeholder value.
  -
    name: min
    type: int
    description: >
      Set the minimum allowed value.
  -
    name: max
    type: int
    description: >
      Set the maximum allowed value.
  -
    name: step
    type: int
    description: >
      Set the interval between valid numbers.
---
## Overview

The float fieldtype is essentially an HTML5 input with `type="number"`. Very similar to the [Integer fieldtype](/fieldtypes/integer), but it allows decimal numbers.

## Data Storage

Stores a float – a decimal number.

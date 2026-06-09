---
title: Integer
description: 'For when all you want is numbers.'
intro: 'The integer fieldtype is a text-style input that only accepts integers (numbers) and has increment and decrement controls.'
screenshot: fieldtypes/screenshots/v6/integer.webp
screenshot_dark: fieldtypes/screenshots/v6/integer-dark.webp
id: 4038c2ac-8c3a-4f4c-8530-8c5f9c8242a6
options:
  -
    name: append
    type: string
    description: >
      Add text after (to the right of) the integer input.
  -
    name: prepend
    type: string
    description: >
      Add text to the beginning (to the left of) the integer input.
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

The integer fieldtype is essentially an HTML5 input with `type="number"`. Using the `up` and `down` keyboard keys will increment and decrement the value by `1`.

## Data Storage

Stores an integer – a whole number that is not a fraction.

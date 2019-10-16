---
title: Revealer
description: A button that allows you to reveal conditional fields.
intro: The revealer is a simple button that allows you to reveal conditional fields without the need to save any additional data.
id: 54066363-7dec-431c-86c6-7e9353380ef5
screenshot: fieldtypes/revealer.gif
stage: 3
options:
  -
    name: display
    type: string
    description: This is the button text.
  -
    name: instructions
    type: string
    description: Instructional text that will appear as a tooltip on the button.
---
This fieldtype is intended to be used with [conditional field rules](#). If you have some fields that should only sometimes show, throw a Revealer field in there and those fields may be shown once the button is clicked.

The example image above uses the following field configuration:

``` yaml
  -
    handle: revealed
    field:
      type: text
      display: 'I am revealed!'
      if:
        behold: 'equals true'
  -
    handle: behold
    field:
      type: revealer
      display: 'Behold!'
```

Regardless of whether the button was clicked or not, no data will be saved.

## Config Options

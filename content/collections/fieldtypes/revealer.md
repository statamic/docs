---
title: Revealer
description: A button that reveals conditional fields like magic.
intro: The revealer is a simple button that reveals conditional fields without saving boolean button data.
id: 54066363-7dec-431c-86c6-7e9353380ef5
screenshot: fieldtypes/screenshots/revealer.gif
stage: 3
options:
  -
    name: display
    type: string
    description: The revealer label text.
  -
    name: mode
    type: string *button*
    description: The revealer input is displayed in `button` mode by default. Choose `toggle` mode if you wish to display a toggle input instead.
  -
    name: input_label
    type: string
    description: Optionally customize the label on the input itself.
  -
    name: instructions
    type: string
    description: Instructional text that will appear as a tooltip on the button.
---

If you have some fields that you wish to hide until the user is ready to reveal them, throw a Revealer field in there and those fields may be shown once the button is clicked.

This fieldtype is intended to be used with our [conditional field rules](/conditional-fields), but unlike regular conditional fields, it will not [disrupt data flow](/conditional-fields#data-flow) on fields hidden by a Revealer.

The example image above uses the following field configuration:

``` yaml
  -
    handle: behold
    field:
      type: revealer
      display: 'Behold!'
  -
    handle: revealed
    field:
      type: text
      display: 'I am revealed!'
      if:
        behold: 'equals true'
```

Regardless of whether the button was clicked or not, no boolean data will be saved for the `behold` Revealer button itself.

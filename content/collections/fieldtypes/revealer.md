---
title: Revealer
description: A button that allows you to reveal conditional fields.
overview: A button that allows you to reveal conditional fields.
id: 54066363-7dec-431c-86c6-7e9353380ef5
image: /assets/fieldtypes/revealer.gif
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
This fieldtype is intended to be used with [conditional field rules](/fieldsets#conditional-fields). If you have some fields that should only sometimes show, throw a Revealer field in there and those fields may be shown once the button is clicked.

The example image above uses the following fieldset:

``` .language-yaml
fields:
  content:
    type: markdown
  has_extended_content:
    type: revealer
    display: Show extended content fields
  extended_content:
    type: markdown
    show_when:
      has_extended_content: true
  bibliography:
    type: markdown
    show_when:
      has_extended_content: true
```

Regardless of whether the button was clicked or not, no data will be saved.

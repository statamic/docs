---
title: Template
description: A template picker with autosuggest.
intro: >
  Used for choosing an entry’s template. Be sure to name the field `template` if you want it to be able to change the template (it's a special variable name).
id: 76e0ee52-a3c4-4904-8b5c-f722bbb20482
screenshot: fieldtypes/template.png
stage: 4
options:
  -
    name: hide_partials
    type: boolean
    description: >
      Since partials are rarely intended to be used as templates, they are hidden by default.
---
## Overview

This is generally used as a "system" field to control an entry's template. It points to the `resources/views` directory and will list all available templates therein.

## Options

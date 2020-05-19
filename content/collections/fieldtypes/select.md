---
title: Select
description: Choose from predefined options. This field is highly configurable.
intro: Give your users a list of options to choose from. This select field is highly configurable with support for search, multiple choice, and creating new options on the fly.
screenshot: fieldtypes/select.png
options:
  -
    name: clearable
    type: boolean
    description: |
      Allow deselecting any chosen option and making null a possible value. Default: `false`.
  -
    name: options
    required: true
    type: array
    description: >
      A set of key/value pairs that define the values and labels. If you don't define the keys, the value and label will be the same.
  -
    name: placeholder
    type: string
    description: |
      Set the non-selectable placeholder text. Default: none.
  -
    name: multiple
    type: boolean
    description: >
      Allow multiple selections. Default: `false`.
  -
    name: searchable
    type: boolean
    description: >
      Enable search with suggestions by typing in the select box. Default: `true`.
  -
    name: taggable
    type: boolean
    description: >
      Use a "tag" style UI when selecting multiples. Default: `false`.
  -
    name: push_tags
    type: boolean
    description: >
      Add newly created options to the list. Default: `false`.
stage: 4
id: 812bd19d-ec37-42d5-b8f9-310366ef8abe
---
## Overview

This field is highly configurable, thanks to the fantastic [Vue Select](https://vue-select.org) component. Be sure to explore all the [config options](#config-options)!

## Data Storage

Select fields will store the _value_ of the chosen option or options. Given this configuration...

``` yaml
handle: select
  field:
    display: Select
    options:
      face: "So's your face."
      know: "I know you are, but what am I?"
      hand: "Talk to the hand."
      beeswax: "Mind your own beeswax."
    placeholder: 'Choose your snappy comeback'
    type: select
```

Your saved data will be:

``` yaml
select: face
```


## Templating

Select fields return the **value** from your selected option. You can access the label with `select_var:label`.

```
<p id="{{ select }}"> Oh yeah? {{ select:value }}</p>
```

``` output
<p id="face">Oh yeah? So's your face.</p>
```

## Config Options

---
title: Select
description: Choose from predefined options. This field is highly configurable.
intro: Give your users a list of options to choose from. This select field is highly configurable with support for search, multiple choice, and creating new options on the fly.
screenshot: fieldtypes/screenshots/v6/select.webp
screenshot_dark: fieldtypes/screenshots/v6/select-dark.webp
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
    name: default
    type: string
    description: |
      Set the default option key. Default: none.
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
id: 812bd19d-ec37-42d5-b8f9-310366ef8abe
---
## Overview

This field is highly configurable, thanks to the fantastic [Vue Select](https://vue-select.org) component. Be sure to explore all the [config options](#options)!

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

### Options in blueprint YAML {#options-in-blueprint-yaml}

In the blueprint file, the field’s `options` list is stored in **expanded** form (an ordered sequence of `key` / `value` pairs) so Statamic can preserve option order everywhere content is stored—including SQL-backed databases. If you author blueprints by hand, use that shape or mirror what the Blueprint Editor writes:

```yaml
options:
  - key: face
    value: "So's your face."
  - key: know
    value: "I know you are, but what am I?"
```

That setting applies to the blueprint definition only, not to the entry value (`select: face` above).


## Templating

Select fields return the **value** from your selected option. You can access the label with `select_var:label`.

::tabs

::tab antlers
```antlers
<p id="{{ select }}"> Oh yeah? {{ select:label }}</p>
```

::tab blade
```blade
<p id="{{ $select }}"> Oh yeah? {{ $select['label'] }}</p>
```
::

```html
<p id="face">Oh yeah? So's your face.</p>
```



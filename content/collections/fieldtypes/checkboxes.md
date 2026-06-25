---
title: Checkboxes
description: Boxes you check. You can check 'em all.
intro: >
  Checkboxes! Make some checkboxes, click the checkboxes, and store a record of which boxes of which ones you clicked. They're boxes you check.
screenshot: fieldtypes/screenshots/v6/checkboxes.webp
screenshot_dark: fieldtypes/screenshots/v6/checkboxes-dark.webp
options:
  -
    name: appearance
    type: string *default*
    description: |
      Choose how the checkboxes are displayed in the Control Panel. One of `default`, `inline`, or `chips`. Default: `default`.
  -
    name: options
    type: array
    description: >
      Sets of key/value pairs define the values and labels of the checkbox options.
id: f922cb9b-6fc9-4249-adf4-59aa46285c13
---
## Overview

The checkboxes fieldtype is a multiple choice input. It saves one or more options chosen from a preset list. In other words, they're boxes you check.

## Configuring

Use the `options` setting to define a list of values and labels.

``` yaml
favorites:
  type: checkboxes
  instructions: Choose up to 3 favorite foods.
  options:
    donuts: Donuts
    icecream: Ice Cream
    brownies: Brownies
```

You may omit the labels and just specify keys. If you use this syntax, the value and label will be identical.

``` yaml
  options:
    - Donuts
    - Ice Cream
    - Brownies
```

### Appearance

Use the `appearance` setting to change how options are rendered in the Control Panel:

``` yaml
favorites:
  type: checkboxes
  appearance: chips
  options:
    donuts: Donuts
    icecream: Ice Cream
    brownies: Brownies
```

| Value | Description |
|-------|-------------|
| `default` | Standard checkboxes, stacked vertically. |
| `inline` | Checkboxes in a horizontal row. |
| `chips` | Pill-style buttons with larger touch targets. |

:::tip
`inline: true` still works on publish forms, but when you edit and save the field in the blueprint editor, Statamic converts it to `appearance: inline`.
:::

#### Chips

The chips appearance option is new in Statamic v6.22. Chips are inline pill-style buttons with larger touch targets. You can select them in the control panel under the appearance setting or configure them in the blueprint YAML, as shown above.

Chips are available for both checkboxes and [radio](/fieldtypes/radio) fieldtypes.

<figure>
    <img src="/img/fieldtypes/screenshots/v6/chips-configuration-checkboxes.webp" alt="Chips configuration for checkbox fieldtype" class="u-hide-in-dark-mode" style="max-width: 100%;">
    <img src="/img/fieldtypes/screenshots/v6/chips-configuration-checkboxes-dark.webp" alt="Chips configuration for checkbox fieldtype" class="u-hide-in-light-mode" style="max-width: 100%;">
    <figcaption>Appearance options for the radio fieldtype, including chips.</figcaption>
</figure>

<figure>
    <img src="/img/fieldtypes/screenshots/v6/chips-on-a-publish-form-checkboxes.webp" alt="Chips on a publish form for checkbox fieldtype" class="u-hide-in-dark-mode" style="max-width: 100%;">
    <img src="/img/fieldtypes/screenshots/v6/chips-on-a-publish-form-checkboxes-dark.webp" alt="Chips on a publish form for checkbox fieldtype" class="u-hide-in-light-mode" style="max-width: 100%;">
    <figcaption>And here's what it looks like on a publish form.</figcaption>
</figure>

### Options in blueprint YAML

See [Select · Options in blueprint YAML](/fieldtypes/select#options-in-blueprint-yaml)—checkbox options in the blueprint use the same expanded `key` / `value` rows so order is preserved everywhere.

## Data Structure

The values are stored as a YAML array. If you only specified values for the `options` array, then the labels will be saved.

``` yaml
favorites:
  - donuts
  - icecream
```



## Templating

You can loop through the checked items and access the value and label of each item inside the loop.

::tabs

::tab antlers

```
<ul>
{{ favorites }}
    <li>{{ value }}</li>
{{ /favorites }}
</ul>
```

::tab blade

```blade
<ul>
	@foreach($favorites as $favorite)
	{{-- You can also access $favorite['key'] and $favorite['label'] --}}
	<li>{{ $favorite['value'] }}</li>
	@endforeach
</ul>
```

::

```html
<ul>
    <li>donuts</li>
    <li>icecream</li>
</ul>
```

::tabs

::tab antlers

To conditionally check if a value has been selected, you can combine the [pluck](/modifiers/pluck) and [contains](/modifiers/contains) modifiers:

```antlers
{{ if favorites | pluck('value') | contains('donuts') }}
   <span>Contains donuts!</span>    
{{ /if }}
```

::tab blade

To conditionally check if a value has been selected, you can combine the pluck and contains collection methods:

```blade
@if (collect($favorites)->pluck('value')->contains('donuts'))
	<span>Contains donuts!</span>
@endif
```
::

### Variables

Inside an asset variable's tag pair you'll have access to the following variables.

| Variable | Description |
|----------|-------------|
| `key` | The zero-index count of the current item |
| `value` | The stored value of the checkbox |
| `label` | The label of the checkbox item from the field config |



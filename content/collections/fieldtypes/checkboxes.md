---
title: Checkboxes
description: Manage an array of boolean values with checkboxes.
overview: >
  Create — you guessed it — checkboxes! The selected checkboxes are stored as an array. Keep that in mind when using the data in your templates.
image: /assets/fieldtypes/checkboxes.png
options:
  -
    name: options
    type: array
    description: >
      Sets of key/value pairs that define the values and labels of the checkbox options.
id: f922cb9b-6fc9-4249-adf4-59aa46285c13
---
## Usage {#usage}

Use the `options` setting to define a list of values and labels.

``` .language-yaml
favorites:
  type: checkboxes
  instructions: Choose up to 3 favorite foods.
  options:
    donuts: Donuts
    icecream: Ice Cream
    brownies: Brownies
```

You may omit the labels and just specify keys. If you use this syntax, the value and label will be identical.

``` .language-yaml
  options:
    - Donuts
    - Ice Cream
    - Brownies
```

## Data Structure {#data-structure}

The values in the screenshot would saved as a simple list:

``` .language-yaml
favorites:
  - donuts
  - icecream
```

If you only specified values for the `options` array, then the labels will be saved.

``` .language-yaml
favorites:
  - Donuts
  - Ice Cream
```


## Templating {#templating}

Since the data is saved as a simple list, you can use a tag pair to iterate over the values or use an array modifier:

```
<ul>
{{ favorite }}
    <li>{{ value }}</li>
{{ /favorite }}
</ul>
```

```
{{ favorite | ul }}
```

``` .language-output
<ul>
    <li>donuts</li>
    <li>icecream</li>
</ul>
```


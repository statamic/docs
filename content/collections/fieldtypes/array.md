---
title: Array
meta_title: Array Fieldtype
intro: Manage data in a `key:value` array format.
overview: |
  The array fieldtype is used to manage `key: value` array data. It's similar to the [table](/fieldtypes/table) fieldtype but with a more strict data structure and compact user interface.
screenshot: fieldtypes/array.png
options:
  -
    name: keys
    type: array
    description: >
      Define keys when using [keyed mode](#keyed-mode).
      Default: `null`.
  -
    name: mode
    type: string
    description: "Determine which [mode](#modes) to use. Default: `dynamic`."
  -
    name: value_header
    type: string
    description: >
      **Value** column heading displayed when using [dynamic mode](#dynamic-mode)
      Default: `null`.
  -
    name: key_header
    type: string
    description: >
      **Key** column heading displayed when using [dynamic mode](#dynamic-mode)
      Default: `null`.
stage: 3
id: 457f17eb-c0ee-4345-bf90-88322abc212d
---
## Overview

This fieldtype is used to manage `key: value` array data in the right situation. It's used for situations when there is data you would like to stay grouped together because there's only _one_ set and you don't want to use loops.

If you'd like to have _lists_ of this type of data, you might want to use a [grid](/fieldtypes/grid) or [replicator](/fieldtypes/replicator) field.

## Modes

The screenshot above depicts the two modes you can choose from. One for when you know there is a fixed set of keys (keyed), and one for when you don't (dynamic).

### Keyed Mode

The second field contains pre-defined keys. This will give the user a stricter input. They can only enter the values
for the specified keys, and they cannot be reordered.

``` .language-yaml
address:
  type: array
  keys:
    street: Street
    city: City
    country: Country
```

The keys can be specified with or without labels. The snippet above (and what's shown in the screenshot) uses labels.

The following is an example of just keys. When using this syntax, the key and the label will be identical.

```
keys:
  - street
  - city
  - country
```

### Dynamic Mode

The second field contains no pre-defined keys. This will allow the user to define them on the fly and re-arrange them.

``` .language-yaml
address:
  type: array
```
Column headings can be set with `value_header` & `key_header`.
```
value_header: Type of Bacon
key_header: Why is it awesome?
```


## Data Structure

In the example above, both fields would save the exact same data.

``` .language-yaml
address:
  street: 221B Baker Street
  city: London
  country: England
```

## Templating

_This fieldtype is not [augmented](/augmentation)._

You can use basic array access, nested variables, or the [foreach tag](/tags/foreach) to loop through all of the keys. All three of the following methods are equivalent.

```
// Array access
{{ address }}
    {{ street }} {{ city }} {{ country }}
{{ /address }}

// Nested variables
{{ address:street }} {{ address:city }} {{ address:country }}

// Foreach tag:
{{ foreach:address }}
    {{ value }}
{{ /foreach:addresss }}
```

## Config Options

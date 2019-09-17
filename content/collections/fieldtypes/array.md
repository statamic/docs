---
title: Array
description: Manage data in a `key:value` array format.
overview: |
  This is used to create a very specific type of YAML data, the `key: value` array. This is different from the Grid/Replicator (Multi-dimensional Array) approach because each key is unique instead of looping through sets of the same fields.

  It can provide a cleaner content management experience _and_ cleaner templates when used in the right situation.
image: /assets/fieldtypes/array.png
options:
  -
    name: keys
    type: array
    description: |
      The optional pre-defined keys to be used in the field. See [keyed mode][keyed-mode].
      [keyed-mode]: #keyed
id: 457f17eb-c0ee-4345-bf90-88322abc212d
---

## Variations {#variations}

The image above shows the two variations of this fieldtype.

### Dynamic mode {#dynamic}

The first field contains no pre-defined keys. This will allow the user to define them on the fly and re-arrange them.

``` .language-yaml
address:
  type: array
```

### Keyed mode {#keyed}

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

They keys can be specified with or without labels. The snippet above (and what's shown in the screenshot) uses labels.

The following is an example of just keys. When using this syntax, the key and the label will be identical.

```
keys:
  - street
  - city
  - country
```


## Data Structure {#data-structure}

In the example above, both fields would save the exact same data.

``` .language-yaml
address:
  street: 221B Baker Street
  city: London
  country: UK
```

## Templating {#templating}

Since the data is saved as a simple key/value pair, you may use basic array access or the [Foreach](/tags/foreach) tag for output.

```
{{ address }}
    {{ street }} {{ city }} {{ country }}
{{ /address }}
```

Nested variables:

```
{{ address:street }} {{ address:city }} {{ address:country }}
```

Foreach tag:

```
{{ foreach:address }}
    {{ key }}: {{ value }}
{{ /foreach:addresss }}
```

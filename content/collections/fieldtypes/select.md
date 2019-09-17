---
title: Select
image: /assets/fieldtypes/select.jpg
id: 812bd19d-ec37-42d5-b8f9-310366ef8abe
overview: Create a list of predefined options to populate a simple HTML select field.
options:
  -
    name: options
    type: array
    description: >
      A set of key/value pairs that define the values and labels.
  -
    name: default
    type: string
    description: The default, preselected option.
---
## Usage

Select fields need to define a list of options. They can be a simple list -- where the stored value and display label are one and the same, or a key/value pair, allowing you to customize both the value and the label.

### List Example

```
oscar_winner:
  type: select
  options:
    - Tommy Wiseau
    - Greg Sistero
    - James Franco
```

### Value/Label Example


```
oscar_winner:
  type: select
  options:
    tommy: Tommy Wiseau
    greg: Greg Sistero
    james: James Franco
```

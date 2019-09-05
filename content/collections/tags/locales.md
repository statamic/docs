---
title: Locales
id: ec775716-e573-4a0e-b6e6-23ca1d7b3bbd
overview: >
    Iterate through and output localized versions of content.
parameters:
  -
    name: id
    type: string
    description: |
      The ID of the content you want to localize. If left blank, the content will be taken from the context.
  -
    name: sort
    type: string
    description: |
      Sort by one of the keys in your `system.yaml`'s `locales` array. (eg. `name` or `full`). If left blank, the order in the file will be maintained. Only applicable in the tag pair.
  -
   name: current_first
   type: boolean *true*
   description: |
     When true, this ensures that the current site locale will be first in the list. Only applicable in the tag pair.
variables:
  -
    name: locale
    type: array
    description: |
      The locale data of the current iteration. Contains `key`, `name`, and `full`. You can use array format to access the nested value (eg. `{{ locale:name }}`)
  -
    name: content data
    type: mixed
    description: >
      Each piece of content being iterated through has access to all the variables inside. This includes things like `title`, `content`, `url`, etc.     
---
## Usage {#usage}

This tag allows you to loop over the content in all of its locales. Or to target the content in a specific locale. This is handy for generating things like a "View this in French" style URLs.

### Iterating over locales {#iterating}

Loop through a piece of content in each locale. An example use case may be to create a dropdown where you select which locale you want to view it in.

```
<ul>
{{ locales }}
  <li><a href="{{ url }}">View in {{ locale:name }}</a></li>
{{ /locales }}
</ul>
```

### Targeting a locale {#targeting}

Rather than looping, you can specify a locale to target it directly.

```
{{ locales:fr }}
    <a href="{{ url }}">View in French</a>
{{ /locales:fr }}
```

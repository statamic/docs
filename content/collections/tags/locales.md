---
title: Locales
id: ec775716-e573-4a0e-b6e6-23ca1d7b3bbd
intro: Create links to localized content.
overview: If you need to generate links to your site's content in other languages (using [multi-site](/multi-site)), you've come to the right place.
stage: 4
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
      Sort by one of the keys in your `sites.php`'s `sites` array. (eg. `name` or `full`). If left blank, the order in the file will be maintained. Only applicable in the tag pair.
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
## Examples

### Iterating over locales {#iterating}

You can loop through in each locale to get URLs to translated versions of an entry or taxonomy term.

```
<ul>
{{ locales }}
  <li><a href="{{ url }}">View in {{ locale:name }}</a></li>
{{ /locales }}
</ul>
```

### Targeting a locale {#targeting}

You can also specify a locale directly instead of looping through them all.

```
{{ locales:fr }}
    <a href="{{ url }}">View in French</a>
{{ /locales:fr }}
```

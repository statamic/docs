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
    name: current
    type: string
    description: >
      The `handle` of the current locale.
  -
    name: is_current
    type: boolean
    description: >
      `true` if the given locale in the loop is the current one.
  -
    name: locale:[key/handle]
    type: string
    description: |
      The system handle for any given locale as set in `config/statamic/sites.php`.
  -
    name: locale:name
    type: string
    description: |
      The user-friendly name for any given locale as set in `config/statamic/sites.php`.
  -
    name: locale:full
    type: string
    description: |
      The full, 4 character system locale (e.g. `en_US`) for any given locale as set in `config/statamic/sites.php`.
  -
    name: locale:short
    type: string
    description: |
      The short 2 character system locale (e.g. `en`) for any given locale as set in `config/statamic/sites.php`.
---
## Overview

This tag is used to access all the locales any given entry or term is available in. It's most commonly used as a language switcher.

Each locale's system data, as configured in `config/statamic/sites.php`, is available inside of a `locale` array.
## Examples

### Iterating over locales {#iterating}

Loop through in each locale to get URLs to translated versions of an entry or taxonomy term.

```
<ul>
{{ locales }}
    <li><a href="{{ permalink }}">View in {{ locale:name }}</a></li>
{{ /locales }}
</ul>
```

### Targeting a locale {#targeting}

You can also specify a locale directly instead of looping through them all.

```
{{ locales:fr }}
    <a href="{{ permalink }}">View in French</a>
{{ /locales:fr }}
```
### Excluding the current locale {#excluding}

You can choose to not show the current locale in a list.

```
{{ locales }}
  {{ if ! is_current }}
    <a href="{{ permalink }}">View in {{ locale:name }}</a>
  {{ /if }}
{{ /locales }}
```

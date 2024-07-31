---
title: Dictionary
description: Choose from options provided by dictionaries.
intro: Give your users a list of options to choose from. Similar to the Select field, but allows you to read options from YAML or JSON files, or even hit external APIs.
screenshot: fieldtypes/screenshots/dictionary.png
options:
  -
    name: dictionary
    type: array
    description: |
      Configure the dictionary to be used. You may also define any config values which should be passed along to the dictionary. The `dictionary` option accepts both string & array values:

      ```yaml
      # When it's a dictionary without any config fields...
      dictionary: countries

      # When it's a dictionary with config fields...
      dictionary:
        type: countries
        region: Europe
      ```
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
    name: max_items
    type: integer
    description: >
      Cap the number of selections. Setting this to 1 will change the UI. Default: null (unlimited).
id: 9b14b5b8-6a7a-4db2-8533-9c78faa0e054
---
## Overview
At a glance, the Dictionary fieldtype is similar to the [Select fieldtype](/fieldtypes/select). However, with the Dictionary fieldtype, options aren't manually defined in a field's config, but rather returned from a PHP class (called a "dictionary").

This can prove to be pretty powerful, since it means you can read options from YAML or JSON files, or even hit an external API. It also makes it easier to share common select options between projects.

## Data Storage
Dictionary fields will store the "key" of the chosen option or options.

For example, a dictionary might have items such as:

```php
'jan' => 'January',
'feb' => 'February',
'mar' => 'March',
```

Your saved data will be:

``` yaml
select: jan
```

## Templating
Dictionary fields will return the "option data" returned by the dictionary's `get` method. The shape of this data differs between dictionaries and is outlined below.

For example, using the built-in Countries dictionary, your template might look like this:

```yaml
past_vacations:
  - USA
  - AUS
  - CAN
  - DEU
  - GBR
```

```
<ul>
    {{ past_vacations }}
        <li>{{ emoji }} {{ name }}</li>
    {{ /past_vacations }}
</ul>
```

```html
<ul>
    <li>🇺🇸 United States</li>
    <li>🇦🇺 Australia</li>
    <li>🇨🇦 Canada</li>
    <li>🇩🇪 Germany</li>
    <li>🇬🇧 United Kingdom</li>
</ul>
```

## Available Dictionaries
Statamic includes a few dictionaries straight out of the box.

### File
This allows you point to a file located in your `resources/dictionaries` directory to populate the options. The file can be `json`, `yaml`, or `csv`.

Each option array should have `label` and `value` keys at the minimum. Any additional keys will be available when templating.

You may redefine which keys are used for the labels and values by providing them to your fieldtype config. In the following example, `name` is the label and `id` is the value. 

```json
[
    {"name": "Apple", "id": "apple", "emoji": "🍎"},
    {"name": "Banana", "id": "banana", "emoji": "🍌"},
    {"name": "Cherry", "id": "cherry", "emoji": "🍒"},
    ...
]
```

```yaml
-
  handle: fruit
  field:
    type: dictionary
    dictionary:
      type: file
      filename: fruit.json
      label: name  # optional, defaults to "label"
      value: id    # optional, defaults to "value"
```

You may provide enhanced labels using basic Antlers syntax. For example, to include the emoji before the fruit name, you can do this:

```yaml
label: '{{ emoji }} {{ name }}'
```

### Countries
This provides a list of countries with their ISO codes, region, subregion, and flag emoji.
```yaml
-
  handle: countries
  field:
    type: dictionary
    dictionary:
      type: countries
      region: 'oceania' # Optionally filter the countries by a region.
                        # Supported options are: africa, americas, asia, europe, oceania, polar
```
```yaml
countries:
  - USA
  - AUS
```
```
{{ countries }}
  {{ emoji }} {{ name }}, {{ iso2 }}, {{ iso3 }}, {{ region }}, {{ subregion }}
{{ /countries }}
```
```
🇺🇸 United States, US, USA, Americas, Northern America
🇦🇺 Australia, AU, AUS, Oceania, Australia and New Zealand
```

### Timezones
This provides a list of timezones and their UTC offsets.

```yaml
-
  handle: timezones
  field:
    type: dictionary
    dictionary:
      type: timezones
```
```yaml
timezones:
  - America/New_York
  - Australia/Sydney
```
```
{{ timezones }}
  {{ name }} {{ offset }}
{{ /timezones }}
```
```
America/New_York -04:00
Australia/Sydney +10:00
```

### Currencies
This provides a list of currencies, with their codes, symbols, and decimals.

```yaml
-
  handle: currencies
  field:
    type: dictionary
    dictionary:
      type: currencies
```
```yaml
currencies:
  - USD
  - HUF 
```
```
{{ currencies }}
  {{ name }}, {{ code }}, {{ symbol }}, {{ decimals }}
{{ /currencies }}
```
```
US Dollar, USD, $, 2
Hungarian Forint, HUF, Ft, 0
```

## Custom Dictionaries

In many cases, using the native [File](#file) dictionary can be all you need for something custom. However, it's possible to create an entirely custom dictionary that could read from files, APIs, or whatever you can think of.

[Find out how to create a custom dictionary](/extending/dictionaries)

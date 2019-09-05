---
title: Get Value
overview: Grab an associative array value so you can filter and loop through it.
parameters:
  -
    name: field
    type: tagpart
    description: >
      This is the name of the field to get. It is not actually a parameter, but just a part of the tag.
      (eg. `{{ get_value:my_field }}`)
  -
    name: from
    type: string
    description: >
      The URL from where to retrieve the value. If this isn't set, it will get the value from the context.
  -
    name: filters
    type: parameters
    description: >
      Any additional parameters will be treated as variable names/values and used as filters. See usage below.
id: b4d337c9-5012-48eb-8819-48b6d35571bc
---
## Usage {#usage}

The first way to use this tag is to get an array value from another URL. This is essentially the single-tag version of
wrapping some templating in a [get_content tag](/tags/get_content).

``` .language-yaml
title: Drinks
whisky:
  -
    brand: Lagavulin
    location: Scotland
    favorite: true
  -
    brand: Glenmorangie
    location: Scotland
  -
    brand: Jameson
    location: Ireland
```

```
{{ get_value:whisky from="/drinks" }}
  {{ brand }}
{{ /get_value:whisky }}
```

``` .language-output
Lagavulin
Glenmorangie
Jameson
```

Additionally, you can filter the array by key/values. Here we'll only show Scottish whisky:

```
{{ get_value:whisky from="/drinks" location="Scotland" }}
  {{ brand }}
{{ /get_value:whisky }}
```

``` .language-output
Lagavulin
Glenmorangie
```

Lastly, we can filter by more than one field. Let's only get the favorite Scottish whiskies:

```
{{ get_value:whisky from="/drinks" location="Scotland" favorite="true" }}
  {{ brand }}
{{ /get_value:whisky }}
```

``` .language-output
Lagavulin
```

Delicious.

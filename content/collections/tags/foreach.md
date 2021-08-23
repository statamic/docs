---
title: Foreach
description: Loops through keys in a named key/value array
intro: >
  Loop through and render values from an array of named keys and values without needing to know the keys.
parameters:
  -
    name: as
    type: string
    description: |
      Optionally rename the `key|value` variables. See the above example.
  -
    name: array
    type: string|array
    description: |
      The name of the array to loop over, or a reference to the array itself. See [dynamic variables](#dynamic-variables).
stage: 4
id: 34b03d03-a113-467f-a1c9-65bc6b446220
---
## Overview

Normally when you have data stored in a named array format perhaps created by the [array fieldtype](/fieldtypes/array), you would need to know the keys to render data in your view.

Using the `foreach` tag you can pass in variable name as the second argument in the tag name and loop through the data using `{{ key }}` and `{{ value }}`.

```yaml
company_info:
  address_1: 123 Hollywood Blvd
  address_2: Suite 404
  city: Beverly Hills
  state: California
  zip: 90210

song_reviews:
  Never Gonna Give You Up: 5/5
  My Heart Will Go On: 3/5
```

```
{{ foreach:company_info }}
  {{ key }}: {{ value }}<br>
{{ /foreach:company_info }}

<ul>
  {{ foreach:song_reviews as="song|rating" }}
    <li>{{ song }}: {{ rating }}</li>
  {{ /foreach:song_reviews }}
</ul>
```

``` output
Address 1: 123 Hollywood Blvd<br>
Address 2: Suite 404<br>
City: Beverly Hills<br>
State: California<br>
Zip Code: 90210

<ul>
  <li>Never Gonna Give You Up: 5/5</li>
  <li>My Heart Will Go On: 3/5</li>
</ul>
```

> **Note:** PHP reserves the word `foreach`, so this tag is _technically_ an alias of `iterate`. If you're spelunking through the source code, that's where you'll find it.


## Dynamic Variables

Instead of using the shorthand `{{ foreach:variable_name }}` syntax, you may pass in the array's name manually.

```
{{ foreach array="song_reviews" }}
    ...
{{ /foreach }}
```

If you have a more complicated array location, you can use a dynamic parameter to pass the array itself.

```yaml
reviews:
  songs: [...]
```

```
{{ foreach :array="reviews:songs" }}
    ...
{{ /foreach }}
```

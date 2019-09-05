---
title: Foreach
parse_content: false
overview: >
  An array of named keys and values requires knowing those keys in order to access the data. This tag enables you to access them abstractly and save the day.
description: Loop through the items of a named key/value array
parameters:
  -
    name: as
    type: string
    description: |
      You can rename the `key|value` variables like so:
      `as="song|rating"`
id: 34b03d03-a113-467f-a1c9-65bc6b446220
---
## Usage

Let's assume we have a bit of data stored in a nice and neat named array, perhaps created by the [Array fieldtype](/fieldtypes/array).

Using the `foreach` tag you can pass the variable name into the second part of the tag call and loop through the data using `{{ key }}` and `{{ value }}`.

```.language-yaml
company_info:
  Address 1: 123 Main Street
  Address 2: Suite 404
  City: Saratoga Springs
  State: New York
  Zip Code: 12866

song_reviews:
  Never Gonna Give You Up: 5/5
  My Heart Will Go On: 3/5
```

```.language-template
{{ foreach:company_info }}
  {{ key }}: {{ value }}<br>
{{ /foreach:company_info }}

<ul>
  {{ foreach:song_reviews as="song|rating" }}
    <li>{{ song }}: {{ rating }}</li>
  {{ /foreach:song_reviews }}
</ul>
```

```.language-output
Address 1: 123 Main Street
Address 2: Suite 404
City: Saratoga Springs
State: New York
Zip Code: 12866

<li>Never Gonna Give You Up: 5/5</li>
<li>My Heart Will Go On: 3/5</li>
```

> **Note:** PHP reserves the word `foreach`, so this tag is _technically_ an alias of `iterate`. If you're spelunking through the source code, that's where you'll find it.

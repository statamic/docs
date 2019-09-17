---
title: Users
description: Relate one or more Users to your content.
overview: >
  Allows you attach Users to your content. This can be used to show authorship, team members, or whatever other use you have for showing people with your content.
image: /assets/fieldtypes/users.jpg
id: 0f8102b9-c948-4264-8cb8-cbfbd0415a04
options:
  -
    name: default
    type: string
    description: >
      The default value. If you specify `current`, then the logged in user will be selected by default.
  -
    name: max_items
    type: integer
    description: >
      The maximum number of users than can be selected. By default (blank) there is no limit. Setting to `1` will save the value as a `string` instead of an `array` and will switch to a select dropdown UI.
  - 
    name: label
    type: string
    description: >
      How the values should appear. You may use variables within the string, eg. "{{ first_name }} {{ last_name }}"
---
## Usage

This fieldtype is used to view a list of Users, generally to establish who authored a given entry or page. Setting the default to `current` will use the currently logged in User.

```.language-yaml
fields:
  author:
    display: Author
    type: users
```

## Data Structure

The Users fieldtype is a [Relate fieldtype](/fieldtypes/relate), which means the users will be saved as IDs.

``` .language-yaml
jedis:
  - 892jfsd9a90as
  - 134jk1h78dfas
```

## Templating

Use the [Relate tag](/tags/relate) to loop through the IDs and fetch the user data.

```
<ul>
  {{ relate:jedis }}
    <li>{{ first_name }} {{ last_name }}</li>
  {{ /relate:jedis }}
</ul>
```

``` .language-output
<ul>
  <li>Luke Skywalker</li>
  <li>Yoda</li>
</ul>
```

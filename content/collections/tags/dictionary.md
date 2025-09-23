---
title: Dictionary
intro: Allows you to loop through options from a Dictionary.
description: Allows you to loop through options from a Dictionary.
id: 603bb573-5ebf-4851-935e-713f1caaa431
parameters:
  -
    name: handle
    type: string
    description: 'The handle of the dictionary you wish to get options from.'
    required: true
  -
    name: sort
    type: string
    description: 'Sort options by field name (or `random`). You may pipe-separate multiple fields for sub-sorting and specify sort direction of each field using a colon. For example, `sort="name"` or `sort="date:asc|name:desc"` to sort by date then by name.'
    required: false
  -
    name: limit
    type: integer
    description: 'Limit the total results returned.'
    required: false
  -
    name: filter|query_scope
    type: string
    description: "Apply a custom [query scope](/extending/query-scopes-and-filters) You should specify the query scope's handle, which is usually the name of the class in snake case. For example: `MyAwesomeScope` would be `my_awesome_scope`."
    required: false
  -
    name: offset
    type: integer
    description: 'Skip a specified number of results.'
    required: false
  -
    name: paginate
    type: 'boolean|int *false*'
    description: 'Specify whether your options should be paginated. You can pass `true` and also use the `limit` param, or just pass the limit directly in here.'
    required: false
  -
    name: page_name
    type: 'string *page*'
    description: 'The query string variable used to store the page number (ie. `?page=`).'
    required: false
  -
    name: on_each_side
    type: 'int *3*'
    description: When using pagination, this specifies the max number of links each side of the current page. The minimum value is `1`.
  -
    name: as
    type: string
    description: 'Alias your options into a new variable loop.'
    required: false
  -
    name: scope
    type: string
    description: 'Scope your options with a variable prefix.'
    required: false
  -
    name: '*'
    type: string
    description: 'Any additional parameters will be set as config options on the Dictionary.'
---

This tag allows you to loop through options from a [Dictionary](/fieldtypes/dictionary).

::tabs

::tab antlers
```antlers
{{ dictionary handle="countries" }}
    {{ label }} {{ value }}
{{ /dictionary }}
```
::tab blade
```blade
<s:dictionary handle="countries">
  {{ $label }} {{ $value }}
</s:dictionary>
```
::

You can also use the shorthand syntax for this:

::tabs

::tab antlers
```antlers
{{ dictionary:countries }}
    {{ label }} {{ value }}
{{ /dictionary:countries }}
```
::tab blade
```blade
<s:dictionary:countries>
  {{ $label }} {{ $value }}
</s:dictionary:countries>
```
::

You can also output any additional data provided by the Dictionary, like `emoji` or `region` in the case of the Countries dictionary:

::tabs

::tab antlers
```antlers
{{ dictionary:countries }}
    {{ emoji }} {{ name }} in {{ region }}
{{ /dictionary:countries }}
```
::tab blade
```blade
<s:dictionary:countries>
  {{ $emoji }} {{ $name }} in {{ $region }}
</s:dictionary:countries>
```
::

## Searching

::tabs

::tab antlers
```antlers
{{ dictionary:countries search="Aus" }}
    {{ label }} {{ value }}
{{ /dictionary:countries }}
```
::tab blade
```blade
<s:dictionary:countries search="Aus">
  {{ $label }} {{ $value }}
</s:dictionary:countries>
```
::

```html
🇦🇺 Australia AUS
🇦🇹 Austria AUT
```

## Conditions

::tabs

::tab antlers
```antlers
{{ dictionary:countries region:is="Europe" }}
    {{ label }} {{ value }}
{{ /dictionary:countries }}
```
::tab blade
```blade
<s:dictionary:countries region:is="Europe">
  {{ $label }} {{ $value }}
</s:dictionary:countries>
```
::

There are a bunch of conditions available to you, like `:is`, `:isnt`, `:contains`, `:starts_with`, and `:is_before`. There are many more than that. In fact, there's a whole page dedicated to [conditions - check them out](/conditions).

## Paginating

To enable pagination mode, add the `paginate` parameter with the number of options in each page.

::tabs

::tab antlers
```antlers
{{ dictionary:countries paginate="10" as="countries" }}
    {{ countries }}
        {{ label }}<br>
    {{ /countries }}

    {{ paginate }}
        <a href="{{ prev_page }}">⬅ Previous</a>

        {{ current_page }} of {{ total_pages }} pages
        (There are {{ total_items }} pages)

        <a href="{{ next_page }}">Next ➡</a>
    {{ /paginate }}
{{ /dictionary:countries }}
```
::tab blade
```blade
<s:dictionary:countries paginate="10" as="countries">
  @foreach ($countries as $country)
    {{ $country['label'] }}<br>
  @endforeach

  @if ($paginate['total_pages'] > 1)
    <a href="{{ $paginate['prev_page'] }}">⬅ Previous</a>

    {{ $paginate['current_page'] }} of {{ $paginate['total_pages'] }} pages
    (There are {{ $paginate['total_items'] }} pages)

    <a href="{{ $paginate['next_page'] }}">Next ➡</a>
  @endif
</s:dictionary:countries>
```
::

In pagination mode, your options will be scoped (in the example, we're scoping them into the `countries` tag pair). Use that tag pair to loop over the options in that page.

The `paginate` variable will become available to you. This is an array containing data about the paginated set.

| Variable | Description |
|----------|-------------|
| `next_page` |	The URL to the next paginated page.
| `prev_page` |	The URL to the previous paginated page.
| `total_items` |	The total number of options.
| `total_pages` |	The number of paginated pages.
| `current_page` |	The current paginated page. (ie. the x in the ?page=x param)
| `auto_links` |	Outputs an HTML list of paginated links.
| `links` |	Contains data for you to construct a custom list of links.
| `links:all` |	An array of all the pages. You can loop over this and output {{ url }} and {{ page }}.
| `links:segments` |	An array of data for you to create a segmented list of links.

<br>

## Query Scopes

Doing something custom or complicated? You can create [query scopes](/extending/query-scopes-and-filters) to narrow down those results with the `query_scope` or `filter` parameter:

::tabs

::tab antlers
```antlers
{{ dictionary:countries query_scope="your_query_scope" }}
```
::tab blade
```blade
<s:dictionary:countries query_scope="your_query_scope">

</s:dictionary:countries>
```
::

You should reference the query scope by its handle, which is usually the name of the class in snake case. For example: `YourQueryScope` would be `your_query_scope`.

## Files

One of the powerful things you can do with the Files dictionary is pull in options from a JSON, YAML or CSV file.

::tabs

::tab antlers
```antlers
{{ dictionary:file filename="products.json" label="Name" value="Code" paginate="5" }}
```
::tab blade
```blade
<s:dictionary:file
  filename="products.json"
  label="Name"
  value="Code"
  paginate="5"
>

</s:dictionary:file>
```
::

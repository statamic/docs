---
title: Table
description: Create and manage simple tables of limitless columns and rows.
intro: >
  Creating tables can be a nuisance in a WYSIWYG editor. This fieldtype gives you a way to create flexible tabular data.
screenshot: fieldtypes/table.gif
stage: 4
id: 11e0ab78-7698-44c8-98f1-1194cb12ce28
---
## Data Structure

Data from the Table fieldtype is saved in an array like this:

``` yaml
my_table:
  -
    cells:
      - People
      - Gift
  -
    cells:
      - Kevin
      - Kerosene
  -
    cells:
      - Buzz
      - Spider
```

This data format makes it trivial when it comes time to render it templates.

## Templating

This fieldtype comes with a handy [`table`](/modifiers/table) modifier, which will turn your data into a simple HTML `<table>`.

```
{{ my_table | table }}
```

Here’s the same thing that the modifier would have output, but we’re modifying the cells to use `| markdown`.

```
<table>
  {{ my_table }}
    <tr>
      {{ cells }}
        <td>{{ value | markdown }}</td>
      {{ /cells }}
    </tr>
  {{ /my_table }}
</table>
```

Want even more control? This example assumes you have a boolean field in your front-matter named `first_row_headers` which toggles whether or not to render the first row of the table in a `<thead>` with `<th>` tags.

```
<table>
  {{ my_table }}
    {{ if first && first_row_headers }}
      <thead>
        <tr>
          {{ cells }}
            <th>{{ value|markdown }}</th>
          {{ /cells }}
        </tr>
      </thead>
      <tbody>
    {{ /if }}
    {{ if !first && first_row_headers || !first_row_headers }}
      {{ if first }}
        <tbody>
      {{ /if }}
        <tr>
          {{ cells }}
            <td>{{ value|markdown }}</td>
          {{ /cells }}
        </tr>
      {{ if last }}
        </tbody>
      {{ /if }}
    {{ /if }}
  {{ /my_table }}
</table>
```

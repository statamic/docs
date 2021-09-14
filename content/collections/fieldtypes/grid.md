---
title: Grid
description: Manage columns of dynamic rows of data that can contain any other fieldtypes.
overview: >
  The grid fieldtype is a _meta_ fieldtype, a fieldtype that serves as a container for more fieldtypes. Any fieldtypes. Think of Grid as a spreadsheet, where each column contains any fieldtype, _including another Grid_. We lovingly refer to these as Inception Grids.

  Let's go deeper.

image: fieldtypes/grid.png
options:
  -
    name: min_rows
    type: 'integer *0*'
    description: The minimum number of required rows.
  -
    name: max_rows
    type: integer
    description: >
      The maximum number of rows allowed. Once
      reached the `Add Row`
      button will disappear.
  -
    name: fields
    type: array
    description: >
      A list of fields, each of which create their own column.
  -
    name: mode
    type: string *table*
    description: >
      The Grid is displayed as a table by default. If you have a large number of columns it can get pretty crowded. Choose `stacked` mode to group rows similar to [Replicator](/fieldtypes/replicator). When [Sneak Peek]() is enabled, Grids automatically toggle into stacked mode.
  -
    name: add_row
    type: string
    description: "The `Add Row` button's label."
id: fa6d2032-0e42-4ea5-b20c-4226941bf0da
---
## Fieldtypes

You can use any fieldtypes inside a Grid. Just remember that because you can doesn't mean you should. Your UI experience will vary greatly. Make sure to compare the experience with the other meta-fields: [Replicator](/fieldtypes/replicator) and [Bard](/fieldtypes/bard).

## Data Structure

The Grid field creates a YAML collection (associative array).

## Templating

The example below would have the following data which can be looped through as a tag pair with access to the column data as variables.

``` .language-yaml
cast:
  -
    actor: Mark Hamill
    character: Luke Skywalker
  -
    actor: Harrison Ford
    character: Han Solo
```

```
<h3>Star Wars Cast</h3>
<ul>
    {{ cast }}
        <li>{{ character }} played by {{ actor }}</li>
    {{ /cast }}
</ul>
```

``` .language-output
<h3>Star Wars Cast</h3>
<ul>
    <li>Luke Skywalker played by Mark Hamill</li>
    <li>Han Solo played by Harrison Ford</li>
</ul>
```

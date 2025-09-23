---
title: Table
description: Create and manage simple tables of limitless columns and rows.
intro: >
  Creating tables can be a nuisance in a WYSIWYG editor. This fieldtype gives you a way to create flexible tabular data.
screenshot: fieldtypes/screenshots/table.gif
stage: 4
id: 11e0ab78-7698-44c8-98f1-1194cb12ce28
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
    name: default
    type: string
    description: |
      Set the default value.
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

::tabs

::tab antlers
```antlers
{{ my_table | table }}
```

::tab blade
```blade
{!! Statamic::modify($my_table)->table() !!}
```
::

Here’s the same thing that the modifier would have output, but we’re modifying the cells to use `| markdown`.

::tabs

::tab antlers
```antlers
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
::tab blade
```blade
<table>
	@foreach ($my_table as $row)
		<tr>
			@foreach ($row['cells'] as $cell)
				<td>{!! Statamic::modify($cell)->markdown() !!}</td>
			@endforeach
		</tr>
	@endforeach
</table>
```
::

Want even more control? This example assumes you have a boolean field in your front-matter named `first_row_headers` which toggles whether or not to render the first row of the table in a `<thead>` with `<th>` tags.

::tabs

::tab antlers
```antlers
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
::tab blade

The following example uses the `fetch` helper function, which resolves `Value` instances for you and returns the underlying value. If the passed value is not a `Value` instance, you will get that original value back.

```blade
<?php
	use function Statamic\View\Blade\{fetch};
?>
<table>
	@php($first_row_headers = fetch($first_row_headers) ?? false)
	@foreach ($my_table as $row)
		@if ($loop->first && $first_row_headers)
			<thead>
			<tr>
				@foreach ($row['cells'] as $value)
				<th>{!! Statamic::modify($value)->markdown() !!}</th>
				@endforeach
			</tr>
			</thead>
			<tbody>
		@endif
		@if (! $loop->first && $first_row_headers || ! $first_row_headers)
			@if ($loop->first)
				<tbody>
			@endif

			<tr>
				@foreach ($row['cells'] as $value)
					<th>{!! Statamic::modify($value)->markdown() !!}</th>
				@endforeach
			</tr>

			@if ($loop->last)
				</tbody>
			@endif
		@endif
	@endforeach
</table>
::

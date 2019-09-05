---
title: Get Files
parse_content: false
overview: >
  Retrieve and filter a list of files.
description: Retrieve and filter a list of files.
parameters:
  - 
    name: in|from
    type: string
    description: >
      The directory from which to find files. Relative to your project root.  
      For example: `in="site/themes/redwood"`
  -
    name: depth
    type: integer *1*
    description: >
      The depth of subdirectories to recursively look through. Defaults to no recursion.
  - 
    name: not_in
    type: string
    description: >
      Filter by excluding from a subdirectory or subdirectories. You may use regex, and will be matched against the file path without a leading slash. For example: `not_in="site/themes/(partials|layouts)"`
  -
    name: file_size
    type: string
    description: >
      Filter by file size using one of the following comparison operators. >, >=, <, <=, ==, !=.  
      For example: `file_size="< 500K"`
  -
    name: ext|extension
    type: string
    description: >
      Filter by file extension. You may pipe delimit multiple extensions.
  -
    name: include|match
    type: regex
    description: >
      Filter files by a regular expression. Matches will be kept in the list.
  -
    name: exclude
    type: regex
    description: >
      Exclude files by a regular expression. Matches will be removed from the list.
  -
    name: file_date
    type: string
    description: >
      Filter by last modified dates. The target value can be any date supported by PHP’s [strtotime](http://www.php.net/manual/en/datetime.formats.php) function.
  -
    name: limit
    type: integer
    description: Limit the total results returned.
  -
    name: offset
    type: integer
    description: The number of entries the results should by offset by.
  -
    name: sort
    type: string
    description: Sort the listing by `type` (file extension), `size`, `last_modified`, or `random`.
variables:
  -
    name: file
    type: string
    description: The relative filename path.
  -
    name: filename
    type: string
    description: The filename part of the path. eg. `foo` in `path/to/foo.jpg`
  -
    name: basename
    type: string
    description: The basename part of the path. eg. `foo.jpg` in `path/to/foo.jpg`
  -
    name: extension
    type: string
    description: The file extension.
  -
    name: size
    type: string
    description: The file size in a human readable format.
  -
    name: size_bytes|size_b
    type: integer
    description: The file size in bytes.
  -
    name: size_kilobytes|size_kb
    type: integer
    description: The file size in kilobytes.
  -
    name: size_megabytes|size_mb
    type: integer
    description: The file size in megabytes.
  -
    name: size_gigabytes|size_gb
    type: integer
    description: The file size in gigabytes.
  -
    name: is_image
    type: boolean
    description: Whether the file is an image.
  -
    name: last_modified
    type: Carbon
    description: The last modified date of the file.
id: c7f3def7-8db8-4e6a-b14f-b2981b2333a5
---
## Example {#example}

Iterate through the Javascript files in your theme:

```
{{ get_files in="site/themes/redwood/js" }}
  <script src="{{ file }}"></script>
{{ /get_files }}
```

---
title: Get Files
parse_content: false
description: Retrieves and filters local files
intro: The ultimate 🇨🇭Swiss Army Knife doing-stuff-with-files feature. With the `get_files` tag you can scan and display data on files in _any_ directories inside your local filesystem.
stage: 4
parameters:
  -
    name: in|from
    type: string
    description: >
      The directory to find files in relative to the `public/` directory.
      Example: `in="img/brand"`
  -
    name: depth
    type: integer
    description: >
      The depth of subdirectories to recursively look through. Default: `1` (no recursion).
  -
    name: not_in
    type: string
    description: >
      Filter by excluding from a subdirectory or subdirectories. You may use regex, and will be matched against the file path without a leading slash. For example: `not_in="img/(brand|logos)"`
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
      Filter by file extension. You may pipe delimit multiple extensions. Example: `ext="jpg|png"`.
  -
    name: include|match
    type: regex
    description: >
      Filter files by a regular expression. Matches will be **kept**.
  -
    name: exclude
    type: regex
    description: >
      Exclude files by a regular expression. Matches will be **removed**.
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
    description: The filename path relative to your project root.
  -
    name: filename
    type: string
    description: The filename part of the path. The `neon` in `path/to/neon.jpg`
  -
    name: basename
    type: string
    description: The basename part of the path. The `neon.jpg` in `path/to/neon.jpg`
  -
    name: extension
    type: string
    description: |
      The file extension. Example: `jpg` or `zip`.
  -
    name: size
    type: string
    description: |
      The file size in a human readable format. Example: `1.24 MB`.
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
## Overview

What you do with this tag is up to you. It's that odd, multi-tool you don't have a use for..._until you need it desperately_. If you need to do stuff with listing files and their meta data, this might be the thing you're looking for.

Don't forget about [assets](/assets) though, they're a much more robust and controlled aspect of Statamic.

## Example

Here's a few examples of what you can do with the `get_files` tag.

### List non-asset images in the site's design resources

```
{{ get_files in="public/img/brand" }}
  <img src="{{ file }}" class="w-1/3">
{{ /get_files }}
```

### List the zip files in a web-inaccessible directory

```
<table>
  <thead>
    <tr>
      <th>File</th>
      <th>Size</th>
      <th>Last Modified</th>
    </tr>
  </thead>
  <tbody>
  {{ get_files in="secure/downloads" }}
    <tr>
      <td>{{ basename }}</td>
      <td>{{ size }}</td>
      <td>{{ last_modified }}</td>
    </tr>
  {{ /get_files }}
  </tbody>
</table>
```

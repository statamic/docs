---
title: Loop
description: 'Loop a specified number of times'
intro: |
  Create and iterate through a loop a specific number of times or between a range.

parameters:
  -
    name: times
    type: int
    description: |
      Number of times to loop.

  -
    name: from
    type: int
    description: |
      Number to start looping from. Default `1`.

  -
    name: to
    type: int
    description: 'Number to stop looping at.'
stage: 4
id: 0c59949c-2a78-4f83-94c3-164736140f03
---
## Overview

Create and iterate through a loop a specific number of times using the `times` parameter, or through a range with the `from` and `to` parameters. Do not use both. It'll make a weird mess.

## Examples

### Count to 10
```
{{ loop times="10" }}
  {{ value }}
{{ /loop }}
```

### Populate a select field with years

```
<select name="year">
   {{ loop from="1900" to="2020" }}
      <option value="{{ value }}">{{ value }}</option>
   {{ /loop }}
</select>
```

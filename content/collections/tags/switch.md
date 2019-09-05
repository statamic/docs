---
title: Switch
description: Loop over a set of values repeatedly.
overview: >
  For each time that this tag is called, a value from those listed in the between parameter will be returned. The first value will be returned the first time this tag is called, the second value the second time, etc. Once this tag runs out of values to return, it starts over at the first thing in its list.
parameters:
  -
    name: between
    type: array
    description: >
      A set of values to iterate over, using a
      pipe-separated string.
id: 8b558556-a08b-4134-b77d-102b4fb34060
---
## Examples {#examples}

Odd/even table row classes for zebra striping.

```
<table>
  {{ collection:shows }}
    <tr class="{{ switch between='odd|even' }}">
      <th>{{ title }}</th>
      <td>{{ rating }}</td>
    <tr>
  {{ /collection:shows }}
</table>
```

``` .language-output
<table>
  <tr class="odd">
    <td>Parks & Recreation</td>
    <td>6/5<td>
  </tr>
  <tr class="even">
    <td>Real Housewives of Detroit</td>
    <td>1/5<td>
  </tr>
  <tr class="odd">
    <td>5/5</td>
    <td>The Office</td>
  </tr>
</table>
```

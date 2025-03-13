---
title: Switch
description: Loops a given set of values repeatedly
intro: >
  Each time a switch tag is rendered it will return the next value from its `between` parameter until it reaches the end where it will start all over again.
parameters:
  -
    name: between
    type: array
    description: >
      A set of values to iterate over, using a pipe-separated string.
stage: 4
id: 8b558556-a08b-4134-b77d-102b4fb34060
---
## Overview

The switch tag is most often used to write HTML classes in your markup to help style lists and grids of items. While CSS has gained a lot of features in recent years with CSS selectors like `nth-of-type`, the switch tag is more relevant than ever, especially in combination with utility frameworks like [TailwindCSS](https://tailwindcss.com).

## Examples

Here are a few ideas on what you can do with the switch tag.

### Set alternating background color for table rows

::tabs

::tab antlers
```antlers
<table>
  {{ collection:shows }}
    <tr class="{{ switch between='bg-white|bg-grey-100' }}">
      <th>{{ title }}</th>
      <td>{{ rating }}</td>
    <tr>
  {{ /collection:shows }}
</table>
```
::tab blade
```blade
<table>
  <s:collection:shows>
    <tr class="{{ Statamic::tag('switch')->between('bg-white|bg-grey-100') }}">
     <th>{{ $title }}</th>
     <td>{{ $rating }}</td>
    </tr>
  </s:collection:shows>
</table>
```
::

### Reverse every other pair of items with `flex-direction: row-reverse`

::tabs

::tab antlers
```antlers
{{ features }}
  <div class="flex {{ switch between='flex-row|flex-row-reverse' }}">
    <div class="w-1/2 px-4 m-2">
      <h2>{{ feature_name }}</h2>
      <div>{{ description }}</div>
    </div>
    <img src="{{ feature_screenshot }}" class="w-1/2 m-2">
  </div>
{{ /features }}
```
::tab blade
```blade
@foreach ($features as $feature)
  <div class="flex {{ Statamic::tag('switch')->between('flex-row|flex-row-reverse') }}">
    <div class="w-1/2 px-4 m-2">
      <h2>{{ $feature->feature_name }}</h2>
      <div>{{ $feature->description }}</div>
    </div>
    <img src="{{ $feature->feature_screenshot }}" class="w-1/2 m-2">
  </div>
@endforeach
```
::

## Multiple Instances

You can have multiple instances of the switch tag in a single view and they won't collide with each other as long as the your set of parameters is unique.

If you want to have multiple, identical switch tags you can add an extra parameter to keep track of which is which.

::tabs

::tab antlers
```antlers
{{ switch between="even|odd" for="gallery" }}
{{ switch between="even|odd" for="footer" }}
```
::tab blade
```blade
{{ Statamic::tag('switch')->between('even|odd')->for('gallery') }}
{{ Statamic::tag('switch')->between('even|odd')->for('footer') }}
```
::

## Repeating Values

If you have a lot of redundancy in your `between` parameter, you can simplify it by passing in the number of times you want an element to be repeated.

For example, if you'd like to set the background of every 10th element to purple, you could set the first value to white 9 times followed by purple 1 time.

::tabs

::tab antlers
```antlers
{{ switch between="bg-white:9|bg-purple" }}
```
::tab blade
```blade
{{ Statamic::tag('switch')->between('bg-white:9|bg-purple') }}
```
::

:::tip
If you're using [TailwindCSS's JIT mode](https://tailwindcss.com/docs/just-in-time-mode) or you purge your CSS on production, you might notice any classes **only in your switch tag** are missing. Add spaces around the pipes to make sure JIT picks them up.

::tabs

::tab antlers
```antlers
{{ switch between="bg-white | bg-purple" }}
```
::tab blade
```blade
{{ Statamic::tag('switch')->between('bg-white | bg-purple') }}
```
::

:::

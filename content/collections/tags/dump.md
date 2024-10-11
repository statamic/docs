---
title: Dump
description: Debugs variables in current view context
intro: The dump tag is used for debugging data inside your current view context.
stage: 5
id: 32bc9a50-3b12-11e6-bdf4-0800200c9a66
---
## Overview
This tag is useful for debugging. It will stop execution of the page and render the raw data of the variables in your current context (page, variable loop, etc).

Dropping it in a template or layout will show you all the data that's been injected into the view layer.

::tabs

::tab antlers
```antlers
{{ dump }}
```
::tab blade
```blade
<statamic:dump />
```
::

Dropping it inside a loop will dump all the data _just for that loop context_.

::tabs

::tab antlers
```antlers
{{ gallery }}
  {{ dump }}
{{ /gallery }}
```
::tab blade
```blade
@foreach ($gallery as $item)
  {{-- Using the Statamic tag --}}
  <statamic:dump />
  
  {{-- Using Blade Directives --}}
  @dd($item)
@endforeach
```
::

:::tip
You can also use the [dump modifier](/modifiers/dump) to achieve a similar effect.
:::

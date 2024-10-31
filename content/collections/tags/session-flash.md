---
title: 'Session:Flash'
description: 'Store data for a single request.'
intro: Flash data is session data that is only kept for a single request. It is most often used for success/failure messages that automatically disappear after a page refresh.
stage: 5
id: 29957a36-a15a-4fd0-9342-b829b6235fea
---
## Example

::tabs

::tab antlers
```antlers
{{ session:flash message="You did it!" }}
```
::tab blade
```blade
{{-- Using PHP --}}
@php(session()->flash('message', 'You did it!'))

{{-- Using Antlers Blade Components --}}
<s:session:flash message="You did it!" />
```
::

The next (and only next) request will then have that variable available.

::tabs

::tab antlers
```antlers
{{ session:message }} // You did it!
```
::tab blade
```blade
{{-- Using PHP --}}
@php(session()->get('message'))

{{-- Using Antlers Blade Components --}}
<s:session:message />
```
::

## Multiple Variables

You can set multiple variables at once and reference interpolated data (references to variables).

::tabs
::tab antlers
```antlers
{{ session:flash success="true" :clicked="order_button" }}
```
::tab blade
```blade
{{-- Using Antlers Blade Components --}}
<s:session:flash
  success="true"
  :clicked="$order_button"
/>

{{-- Using PHP --}}
<?php
  session()->flash('success');
  session()->flash('clicked', $order_button);
?>
```
::


## Setting Array Data

Array data can be set with dot notation.

::tabs
::tab antlers
```antlers
{{ session:flash likes.snow_cones="true" likes.italian_ice="false" }}
```
::tab blade
```blade
{{-- Using Antlers Blade Components --}}
<s:session:flash
  likes.snow_cones="true"
  likes.italian_ice="false"
/>

{{-- Using PHP --}}
<?php
  session()->flash('likes.snow_cones');
  session()->flash('likes.italian_ice', false);
?>
```
::


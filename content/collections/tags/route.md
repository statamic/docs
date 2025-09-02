---
title: Route
description: 'Generate URLs to your named routes'
intro: 'The route tag allows you to generate the full URL for a given named route, including any parameters.'
variables:
  -
    name: name
    type: string
    description: 'The route''s name'
  -
    name: route params
    type: various
    description: parameters the route requires
id: d99ec742-2947-4b72-ba39-af51a9fed626
---
## Overview
This tag is equivalent to the `route()` helper in [Laravel](https://laravel.com/docs/urls#urls-for-named-routes). Useful for outputting the correct urls for all your glorious routes.

## Example

``` php
  Route::put('bacon/{bacon}', 'BaconController@update')->name('bacon.update');
```

::tabs

::tab antlers
```antlers
<form action="{{ route:bacon.update :bacon="id" }}">
   ... yummy bacon goodness
</form>
```
::tab blade
```blade
<form action="{{ route('bacon.update', ['bacon' => $id]) }}">
   ... yummy bacon goodness
</form>
```
::

```html
<form action="/bacon/6">
   ... yummy bacon goodness
</form>
```

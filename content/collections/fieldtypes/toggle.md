---
title: Toggle
description: A toggle switch for booleans (`true` and `false`).
intro: A nice little toggle switch generally used to manage settings-type variables. It stores `true` or `false` and is delightfully uncomplicated, just like our relationship with yogurt.
screenshot: fieldtypes/screenshots/v4/toggle.png
id: ac5f8f98-616f-4621-a7ee-dbc8bbc15525
---
## Data Structure

Flicking the toggle to the right sets to the value to `true`, left to `false`.

``` yaml
do_the_thing: true
```

## Templating

Toggles are usually used to control logic, so you can combine them with `{{ if }}` statements in your templates to handle all manner of show/hide wizardry.

::tabs

::tab antlers
```antlers
{{ if do_the_thing }} It does it {{ /if }}
```

::tab blade

The following example uses the `fetch` helper function, which resolves `Value` instances for you and returns the underlying value. This way you always get the real "truthy" value, regardless of how you retrieved `$do_the_thing`.

```blade
<?php
	use function Statamic\View\Blade\{fetch};
?>

@if (fetch($do_the_thing))
  It does it
@endif
```
::

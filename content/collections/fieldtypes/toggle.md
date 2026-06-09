---
title: Toggle
description: A toggle switch for booleans (`true` and `false`).
intro: A nice little toggle switch generally used to manage settings-type variables. It stores `true` or `false` and is delightfully uncomplicated, just like our relationship with yogurt.
screenshot: fieldtypes/screenshots/v6/toggle.webp
screenshot_dark: fieldtypes/screenshots/v6/toggle-dark.webp
id: ac5f8f98-616f-4621-a7ee-dbc8bbc15525
---

## Can I haz green?

Some people like their toggles green. It's a personal preference, just like white or milk chocolate. Since the control panel theme is customizable, you can make your toggles green! Or whatever other color for that matter… but maybe not red? Look for the Theme section in `config/statamic/cp.php` and set the `switch-bg` your preferred color. Here's green:

```php
'theme' => [
    'switch-bg' => Color::Green[500],
    'dark-switch-bg' => Color::Green[600],
],
```

<figure>
    <img src="/img/fieldtypes/screenshots/v6/toggle-green.webp" alt="Statamic Toggle Green" class="u-hide-in-dark-mode">
    <img src="/img/fieldtypes/screenshots/v6/toggle-green-dark.webp" alt="Statamic Toggle Green" class="u-hide-in-light-mode">
    <figcaption>Who dares to dream? A nugget of <a target="_blank" href="https://www.youtube.com/watch?v=TkZFuKHXa7w">purest green!</a></figcaption>
</figure>

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

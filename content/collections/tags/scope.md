---
id: d4f29394-ac2f-4f73-bc33-5ec081324e2e
blueprint: tag
title: Scope
intro: 'Used to push all of the "root", or page scope data into an array to be used however you see fit.'
parameters:
  -
    name: scope
    type: 'tag part'
    description: 'The name of the scope while. This is not a parameter, but part of the tag itself. For example, `{{ scope:plop }}`.'
    required: false
  -
    name: handle_prefix
    type: string
    description: 'A prefix to prepend to variable names when looking up data. For example, if you have a variable named `hero_title` and use `handle_prefix="hero_"`, you can reference it as `{{ title }}`.'
    required: false
---
## Overview

Most commonly this take is used to avoid any kind of variable collisions or to confirm data to a particular naming mechanism. Scoping is most often done on the Tag level (e.g. the [Collection Tag](/tags/collection/#scope)), but gives you another level of control and flexibility.

## Example

::tabs

::tab antlers
```antlers
---
title: Grimmace Shake
---

{{ scope:stuff }}
<h1>{{ stuff:title }}</h1>
{{ /scope:stuff }}
```
::tab blade
```blade
<?php
  $title = 'Grimmace Shake';
?>

<s:scope:stuff>
  <h1>{{ $stuff['title'] }}</h1>
</s:scope:stuff>
```
::

This will output:

```html
<h1>Grimmace Shake</h1>
```

## Handle Prefix

The `handle_prefix` parameter lets you access prefixed variables without needing to include the prefix. This is useful when working with [imported fieldsets](/blueprints#importing-fieldsets) that use a prefix.

For example, if you have a fieldset imported with the prefix `hero_`, you might have variables like `hero_title` and `hero_description`. Using `handle_prefix`, you can reference them without the prefix:

::tabs

::tab antlers
```antlers
{{ scope handle_prefix="hero_" }}
    {{ if title }}
        <h1>{{ title }}</h1>
        <p>{{ description }}</p>
    {{ /if }}
{{ /scope }}
```
::tab blade
```blade
<s:scope handle_prefix="hero_">
    @if ($title)
        <h1>{{ $title }}</h1>
        <p>{{ $description }}</p>
    @endif
</s:scope>
```
::

In this example, `{{ title }}` will resolve to the value of `hero_title`, and `{{ description }}` will resolve to `hero_description`.

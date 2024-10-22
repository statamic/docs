---
id: a29dcde5-5708-4ed3-8d00-76f818095477
blueprint: modifiers
modifier_types:
  - array
  - utility
title: Compact
---
Converts a comma-delimited list of variable names into an array that can be used anywhere. Arrays are accepted.

It allows colon delimited syntax to target nested variables.

```yaml
title: 'The finest title there ever was'
stuff:
  one: 'Value One'
  two: 'Value Two'
```

::tabs

::tab antlers
```antlers
{{ "stuff:one, title, stuff:two" | compact | ul }}
```
::tab blade
```blade
{!! Statamic::modify("stuff:one, title, stuff:two")->compact()->ul() !!}
```
::

Would produce the following output:

::tabs

```html
<ul>
    <li>Value One</li>
    <li>The finest title there ever was</li>
    <li>Value Two</li>
</ul>
```

:::tip
It's similar to PHP's `compact()` function.

```php
$foo = 'bar';
$baz = 'qux';
compact('foo', 'baz'); // ['bar', 'qux']
```
:::

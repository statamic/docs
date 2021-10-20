---
title: Building Modifiers
template: page
updated_by: 42bb2659-2277-44da-a5ea-2f1eed146402
updated_at: 1569264085
stage: 1
intro: Modifiers give you the ability to manipulate the data of your variables on the fly. They can manipulate strings, filter arrays and lists, help you compare things, do basic math, simplify your markup, play Numberwang, and even help you debug.
id: e052ecb8-60d9-4afa-980e-ce128c301d70
---
## Anatomy of a Modifier

A modifer consists of a few parts. Let’s break it down.

```
{{ variable | repeat:2 }}
```

- The first part? A regular old variable: `variable`.
- Next up, the modifier's [handle](#handle): `repeat`
- And finally, a parameter: `2`

Parameters are used to modify the behavior of a modifier. They could be anything from an integer or boolean to a variable reference. It’s up to you.

## Creating a Modifier

You can generate a Modifier class with a console command:

``` shell
php please make:modifier Repeat
```

This'll create a class in `app/Modifiers` which will be automatically registered.

To create and register a modifier inside an addon instead, check out the [addon docs](/extending/addons#registering-components).

## Modifying a value

The modifier class expects one `index` method which should return a modified `$value`.

``` php
<?php

namespace App\Modifiers;

use Statamic\Modifiers\Modifier;

class Repeat extends Modifier
{
    public function index($value, $params, $context)
    {
        // {{ variable | repeat }}
    }
}
```

The first and only required argument passed into `index` will be the `$value` that needs modifying. We can do anything to this value as long as we return it when we’re done. Once returned, the template will either render it, or pass it along the next modifier in the chain.

The other two arguments are optional:

- `$params` will be an array of any parameters.
- `$context` will be an array of contextual data available at that position in the template.

## Handle

The modifier's handle is how it will be referenced in templates. By default, this will be the snake_cased version of the class name. In this example above, it would be `repeat`.

You can override this by setting a static `$handle` property.

``` php
protected static $handle = 'repeatrepeat';
```

Then, using the example above, `variable | repeat` would now be `variable | repeatrepeat`.

## Aliases

You may choose to create aliases for your modifier too. It will then be usable by its handle, or any of its aliases.

``` php
protected static $aliases = ['duplicate'];
```


## Example

Let’s say we need a modifier that repeats things. Maybe even delicious things.

``` php
<?php

namespace App\Modifiers;

use Statamic\Modifiers\Modifier;

class Repeat extends Modifier
{
    public function index($value, $params, $context)
    {
        // Repeat twice by default
        $repeat = 2;

        // Get the parameter, if there is one
        if ($param = array_get($params, 0)) {
            // Either get the variable from the context, or if it doesn't exist,
            // use the parameter itself - we'll assume its a number.
            $repeat = array_get($context, $param, $param);
        }

        // Repeat!
        return str_repeat($value, $repeat);
    }
}
```

Given the following data:

``` yaml
times: 5
thing: Pizza
```

And template:

```
{{ thing | repeat }}
{{ thing | repeat:3 }}
{{ thing | repeat:times }}
```

You would find yourself with varying amounts of pizza.

```html
PizzaPizza
PizzaPizzaPizza
PizzaPizzaPizzaPizzaPizza
```

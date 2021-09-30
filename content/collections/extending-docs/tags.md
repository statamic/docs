---
title: Building Tags
template: page
updated_by: 42bb2659-2277-44da-a5ea-2f1eed146402
updated_at: 1569264076
intro: Ultimately a Tag is nothing more than a PHP Method called from an Antlers template. This common pattern allows non-PHP developers to take advantage of dynamic features in their site easily without writing any code.
stage: 1
id: 098cb1c5-94c2-4bc0-add7-9aad39951d67
---
## Anatomy of a Tag

A tag consists of several parts, none of which are named the “thorax”. Let’s break a Tag down:

```
{{ acme:foo_bar src="baz" }}
```

- The first part? That’s the tag's handle: `acme`
- The second bit is the method it maps to: `fooBar` (the method will be camelCased)
- And lastly, a parameter: `src="foo"`. There can be any number of parameters on a Tag.

Tags can also come in pairs, much like beer comes in pints. For example:

```
{{ entries:listing folder="blog" }}
  <div>{{ title }}</div>
{{ /entries:listing }}
```

Anything in-between your tag pair is available as `$this->content`. Sometimes you’ll want to use it as input, other times manipulate it, and yet another time leave it be. It’s up to you.


## Multiple Tags in one class

We use the plural "Tags" for the class, because one class defines multiple tags. They just all use the same handle.

Every `public` method in a tag class will become a tag, using the snake_cased version.

For example:

``` php
<?php

namespace Acme\Example;

class MyTags extends \Statamic\Tags\Tags
{
    public function fooBar()
    {
        // {{ my_tags:foo_bar }}
    }
}
```

### Index

A tag without a method will use the `index` method.

``` php
public function index()
{
    // {{ my_tags }}
}
```

### Wildcards

A common tag pattern is to have the method be dynamic. For example, the [Collection Tag][collection_tag]'s method is the handle of the collection you want to work with: `{{ collection:blog }}`.

You may add a `wildcard` method to your Tag class to catch these.

``` php
public function wildcard($tag)
{
    // {{ tag:* }}

    // if you used {{ tag:foo }}, $tag would be "foo"
}
```

If you want a tag named literally "wildcard", you can adjust the wildcard method that Statamic will call by updating the `wildcardMethod` property.

``` php
protected $wildcardMethod = 'missing';

public function wildcard()
{
    // {{ tag:wildcard }}
}

public function missing($tag)
{
    // {{ tag:* }}
}
```

You may have used the `__call()` magic method in Statamic v2 to handle wildcard tags. This still technically works, but we've
introduced the `wildcard` method to prevent some infinite looping situations you may encounter.

## Generating a tag class

You can generate a Tags class with a console command:

``` bash
php please make:tag Foo
```

This'll create a class in `app/Tags` which will be automatically registered.

To create and register a tag inside an addon instead, check out the [addon docs](/extending/addons#registering-components).

## Tag Handle

The first part of the tag will be the tag's "handle". This will be the snake_cased version of the class name by default. In this example, it would be `my_tags`.

You can override this by setting a static `$handle` property.

``` php
protected static $handle = 'example';
```

Then, using the example above, `my_tags:x` would now be `example:x`

## Aliases

You may choose to create aliases for your tag too. It will then be usable by its handle, or any of its aliases.

``` php
protected static $aliases = ['sample'];
```

## Parameters

You may get the values of parameters through the `parameters` property.

Any parameters prefixed with a colon will resolve the values from the context automatically.

``` yaml
author: john
```

```
{{ mytag
    greeting="hello"
    :name="author"
    do_this="true"
    do_that="false"
    limit="5"
    latitude="6"
    things="foo|bar"
}}
```

``` php
$this->params->get('greeting'); // "hello"
$this->params->get('name'); // "john"
$this->params->bool('do_this') // true
$this->params->bool('do_that') // false
$this->params->int('limit') // 5
$this->params->float('latitude') // 6.0
$this->params->explode('things') // ['foo', 'bar']

// Array access also works:
$this->params['greeting']; // "hello"

// It's a Collection, so all those methods work, too.
$this->params->only(['greeting', 'name']); // ['hello', 'john']
```

For any of these methods, you may provide a second argument as a fallback if the key doesn't exist.

``` php
$this->params->get('nope', 'fallback'); // "fallback"
```

You may also provide an array of keys. The first match will be used.

``` php
$this->params->get(['salutation', 'greeting']); // "hello"
```

## Context

The context is the array of values being used for rendering the template where your tag happens to be placed.
Take this block of templating for example:

```
{{ title }}

{{ collection:blog }}
    {{ title }}
    {{ your_tag }}
{{ /collection:blog }}
```

The `title` in the first line uses the page context since it's not nested inside any other tag pairs. This would typically be the title of the entry of the URL you're visiting. You can pretend that the entire template is wrapped in a pair of invisible tags.

The `collection:blog` tag loops over entries in a collection. The `title` in there will be using the context of the entry in the current iteration of the loop.

Likewise, the `your_tag`'s context will be current iteration of the loop.

You may get values out of the context similar to [parameters](#parameters):

``` php
$this->context->get('title');
$this->context->get('unknown', 'fallback');
$this->context->get(['first_this', 'then_this']);
```

If the item you are retrieving is defined in a Blueprint, it'll be a `Value` object. To avoid you needing to check for Value objects and manually convert them yourself, you may use the `value` and `raw` methods instead:

``` php
// If it's a Value object, it'll get the augmented value for you.
$this->context->value('something');

// If it's a Value object, it'll get the raw value for you.
$this->context->raw('something');
```

## Rendering Data

Rendering your tag data is a little different depending on whether you intend to have a single tag or a tag pair.

Generally, you should try to have a tag that is either always used as a single, or a pair. If you _need_ a tag to work either way, the `$this->isPair` boolean is available to you.

### Single Tags

A single tag stands alone by itself and does not have a closing tag. Your method must return a string if you to render something. Within a template, your tag will be replaced with that returned string.

``` php
public function method()
{
    return 'hello';
}
```
```
{{ your_tag:method }}
```
```
hello
```

You may also return a boolean. This is useful if your tag is designed to be used in conditions.

``` php
public function method()
{
    return true;
}
```
```
{{ if {your_tag:method} }} yup {{ /if }}
```
```
yup
```

If your tag doesn’t return anything, your tag won’t render anything. This can be useful if you need to perform some sort of non-HTML rendering task. For example, the redirect tag doesn’t output any HTML, it just performs a redirect.

### Tag Pairs

When using your tag in a pair, you can return an array (or Collection) to be used as the new context. Its variables will be available between your tags.

``` php
public function method() {
    return [
        'tree' => 'maple',
        'path' => 'dirt',
        'sky'  => 'blue'
    ];
}
```
```
{{ your_tag:method }}
    {{ tree }} {{ path }} {{ sky }}
{{ /your_tag:method }}
```
```
maple dirt blue
```

Returning a multidimensional array will let you loop over the items.

``` php
public function method() {
    return [
        [
            'tree' => 'maple',
            'path' => 'dirt',
            'sky'  => 'blue'
        ],
        [
            'tree' => 'oak',
            'path' => 'asphalt',
            'sky'  => 'black'
        ]
    ];
}
```
```
{{ your_tag:method }}
    {{ tree }} {{ path }} {{ sky }}
{{ /your_tag:method }}
```
```
maple dirt blue
oak asphalt black
```

Returning an empty array will automatically make a `no_results` boolean available.

``` php
public function method() {
    return [ ];
}
```
```
{{ your_tag:method }}
    {{ if no_results }}
        No results.
    {{ else }}
        Some results.
    {{ /if }}
{{ /your_tag:method }}
```
```
No results.
```

### Passing along context

As mentioned above, the array returned from a tag pair method is what'll be available between the tags. The parent context is not available. This is to prevent variable collision and confusion.

If you *want* parent context to be available, you can pass those down manually.

``` php
// One at a time
return [
    'local' => 'value',
    'var' => $this->context->get('var'),
];
```

``` php
// Merging in multiple
return array_merge(
    $this->context->only('foo', 'bar', 'baz'),
    ['local' => 'value']
);
```

## Miscellaneous

- `$this->content` - When using a tag pair, this is what's between them.
- `$this->isPair` - Boolean for whether a single or tag pair was used.
- `$this->tag` - The full tag that was used.
    - For `{{ ron foo="bar" }}` it would be `ron:index`
    - For `{{ ron:swanson foo="bar" }}`, this would be `ron:swanson`
    - For `{{ ron:swanson:breakfast foo="bar" }}`, this would be `ron:swanson:breakfast`
- `$this->method` - The tag method that was used.
    - For `{{ ron foo="bar" }}`, it would `index`
    - For `{{ ron:swanson foo="bar" }}`, this would be `swanson`
    - For `{{ ron:swanson:breakfast foo="bar" }}`, this would be `swanson:breakfast`

[collection_tag]: /tags/collection

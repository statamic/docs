---
title: Building Tags
template: page
updated_by: 42bb2659-2277-44da-a5ea-2f1eed146402
updated_at: 1569264076
intro: Ultimately a Tag is nothing more than a PHP method called from an Antlers or Blade template. This common pattern allows non-PHP developers to take advantage of dynamic features in their site easily without writing any code.
stage: 1
id: 098cb1c5-94c2-4bc0-add7-9aad39951d67
---
## Anatomy of a Tag

A tag consists of several parts, none of which are named the “thorax”. Let’s break a Tag down:

::tabs

::tab antlers
```antlers
{{ acme:foo_bar src="baz" }}
```

- The first part? That’s the tag's handle: `acme`
- The second bit is the method it maps to: `fooBar` (the method will be camelCased)
- And lastly, a parameter: `src="foo"`. There can be any number of parameters on a Tag.

::tab blade
```blade
<s:acme:foo_bar src="baz" />
```

- The first part after `<s:`? That’s the tag's handle: `acme`
- The second bit is the method it maps to: `fooBar` (the method will be camelCased)
- And lastly, a parameter: `src="foo"`. There can be any number of parameters on a Tag.

::

Tags can also come in pairs, much like beer comes in pints. For example:

::tabs

::tab antlers
```antlers
{{ entries:listing folder="blog" }}
  <div>{{ title }}</div>
{{ /entries:listing }}
```
::tab blade
```blade
<s:entries:listing folder="blog">
  <div>{{ $title }}</div>
</s:entries:listing>
```
::

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
        // Stay awhile and listen.
    }
}
```

Would be called like so in your template:

::tabs

::tab antlers
```antlers
{{ my_tags:foo_bar }}
```
::tab blade
```blade
<s:my_tags:foo_bar />
```
::

### Index

A tag without a method will use the `index` method.

``` php
public function index()
{
    // It's just one of those days.
}
```

Template:

::tabs

::tab antlers
```antlers
{{ my_tags }}
```
::tab blade
```blade
<s:my:tags />
```
::

### Wildcards

A common tag pattern is to have the method be dynamic. For example, the [Collection Tag][collection_tag]'s method is the handle of the collection you want to work with: `collection:blog`.

You may add a `wildcard` method to your Tag class to catch these.

``` php
public function wildcard($tag)
{
    // ♠️♥️♦️♣️
}
```

then, in your template:

::tabs

::tab antlers
```antlers
{{# Replace the * with anything you'd like! Go wild - play your crazy card! #}}
{{ tag:* }}

{{# In this case, the `$tag` value would be "foo" #}}
{{ tag:foo }}
```
::tab blade
```blade
{{-- Replace the * with anything you'd like! Go wild - play your crazy card! --}}
<s:tag:* />

{{-- In this case, the `$tag` value would be "foo" --}}
<s:tag:foo />
```
::

If you want a tag named literally "wildcard", you can adjust the wildcard method that Statamic will call by updating the `wildcardMethod` property.

```php
protected $wildcardMethod = 'missing';

public function wildcard()
{
    // tag:wildcard
}

public function missing($tag)
{
    // tag:*
}
```

:::best-practice
You may notice that the `wildcard` method seems very similar to the `__call()` magic method. It is! The `wildcard` method
uses `__call` under the hood, but with additional smarts. Be sure to use `wildcard`!
:::

## Generating a tag class

You can generate a Tags class with a console command:

``` shell
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

::tabs

::tab antlers
```antlers
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
::tab blade
```blade
<s:mytag
  greeting="hello"
  :name="$author"
  do_this="true"
  do_that="false"
  limit="5"
  latitude="6"
  things="foo|bar"
/>
```
::


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

::tabs

::tab antlers
```antlers
{{ title }}

{{ collection:blog }}
    {{ title }}
    {{ your_tag }}
{{ /collection:blog }}
```
::tab blade
```blade
{{ $title }}

<s:collection:blog>
  {{ $title }}

  <s:your_tag />
</s:collection:blog>
```
::

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

::tabs

::tab antlers
```antlers
{{ your_tag:method }}
```
::tab blade
```blade
<s:your_tag:method />
```
::

```text
hello
```

You may also return a boolean. This is useful if your tag is designed to be used in conditions.

``` php
public function method()
{
    return true;
}
```

::tabs

::tab antlers
```antlers
{{ if {your_tag:method} }} yup {{ /if }}
```
::tab blade
```blade
@if (Statamic::tag('your_tag:method')->fetch()) yup @endif
```

::

```text
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

::tabs

::tab antlers
```antlers
{{ your_tag:method }}
    {{ tree }} {{ path }} {{ sky }}
{{ /your_tag:method }}
```
::tab blade
```blade
<s:your_tag:method>
  {{ $tree }} {{ $path }} {{ $sky }}
</s:your_tag:method>
```
::

```text
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

::tabs

::tab antlers
```antlers
{{ your_tag:method }}
    {{ tree }} {{ path }} {{ sky }}
{{ /your_tag:method }}
```
::tab blade
```blade
<s:your_tag:method>
  {{ $tree }} {{ $path }} {{ $sky }}
</s:your_tag:method>
```
::

```text
maple dirt blue
oak asphalt black
```

### Empty Results in Antlers

When using Antlers, a `no_results` variable will be automatically created when a tag returns an empty array.

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

### Empty Results in Blade

There are many different ways to handle empty results in Blade. When iterating simple tag results without aliasing, there is a special Blade component that takes the place of the `no_results` variable:

``` php
public function method() {
    return [ ];
}
```

```blade
<s:your_tag:method>
  Some results.

  <s:no_results>
    No results.
  </s:no_results>
</s:your_tag:method>
```

In all other scenarios, you will need to use other techniques. Some examples are:

```blade
{{-- Checking the count. --}}
<s:your_tag:method as="results">

  @if (count($results) > 0)
    Some results.
  @else
    No results.
  @endif

</s:your_tag:method>

{{-- Using forelese --}}
<s:your_tag:method as="results">
  @forelse ($results as $value)
    ...
  @empty
    No results.
  @endforelse

</s:your_tag:method>
```

Whichever method you choose will depend on the situation and your personal preference.

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
    $this->context->only('foo', 'bar', 'baz')->all(),
    ['local' => 'value']
);
```

## Considerations for Blade

Most tag implementations will work seamlessly whether a user is writing their templates in Antlers or Blade, but there are a few things to keep in mind.

### Conditionally Included Variables and "Falsey-ness"

Tag implementations that conditionally inject a variable should consider always including the variable in their output, with a backwards-compatible default. Antlers will treat non-existent variables as `false` in conditions, and skip them entirely in other contexts.

Because Blade compiles to PHP, if you do not always include the variable, users of your tag will have to resort to adding `isset` (or similar) checks.

If your tag conditionally injects a variable that template authors rely on to change their output, consider adjusting the logic such that the variable is always available, with a backwards-compatible default.

An example of this is Statamic's own form tag and the `success` variable.

### Aliased Array Results

The Antlers engine will automatically alias array results. Consider the following tag:

```php
<?php

namespace App\Tags;

use Statamic\Tags\Tags;

class YourTag extends Tags
{
    public function index()
    {
        return ['a', 'b', 'c'];
    }
}
```

When writing Antlers, the following will "just work" due to how to the engine is implemented:

```antlers
{{ your_tag as="the_array_name" }}

  {{ the_array_name }}
    {{ value }}
  {{ /the_array_name }}

{{ /your_tag }}
```

The Blade countepart would be:

```blade
<s:my_custom_tag as="the_array_name">
  @foreach ($the_array_name as $value)
    {{ $value }}
  @endforeach
</s:my_custom_tag>
```

However, with the current tag implementation, this would not work and template authors would receive an error stating the `$the_array_name` variable doesn't exist. To make this work, we need to add support for the `as` parameter to our tag directly. Luckily, an `aliasedResult` helper method exists to make this easy for us:

```php
<?php

namespace App\Tags;

use Statamic\Tags\Tags;

class YourTag extends Tags
{
    public function index()
    {
        return ['a', 'b', 'c']; // [tl! --]
        return $this->aliasedResult(['a', 'b', 'c']); // [tl! ++]
    }
}
```

### Don't Assume Tag Content is Always Antlers

If you are interacting with a tag's content and rendering it manually, you should *not* assume that the tag's content is always Antlers.

For example, if you have a tag implementation that looks something like this:

```php
<?php

namespace App\Tags;

use Statamic\Facades\Antlers;
use Statamic\Tags\Tags;

class MyCustomTag extends Tags
{
    public function index()
    {
        return Antlers::parse($this->content);
    }
}

```

consider using the `parse()` method instead, which will take the current templating language into consideration:


```php
<?php

namespace App\Tags;

use Statamic\Facades\Antlers; // [tl! --]
use Statamic\Tags\Tags;

class MyCustomTag extends Tags
{
    public function index()
    {
        return Antlers::parse($this->content); // [tl! --]
        return $this->parse(); // [tl! ++]
    }
}

```

### Implementing Custom Behavior for Blade vs. Antlers

If you want to change your tags behavior specifically for Blade, you can check if the current tag instance is being rendered within a Blade template like so:

```php
<?php

namespace App\Tags;

use Statamic\Tags\Tags;

class YourTag extends Tags
{
    public function index()
    {
        if ($this->isAntlersBladeComponent()) {
            return 'Hello, Blade!';
        }

        return 'Hello, Antlers!';
    }
}
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

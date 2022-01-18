---
blueprint: page
title: 'Antlers Templates'
intro: >
  Antlers is a simple and powerful templating engine provided with Statamic.  It can fetch and filter content, display, modify, and set variables, tap into core features like user authentication and search, and handle complex logic.

  :::warning Heads up!
    These docs are for the **brand new, experimental Antlers Runtime Engine.** [Read more about it](#about), learn how to enable it on your site, and keep reading to see all the new things it can do!
  :::

template: page
id: d37b2af2-f2bf-493a-9345-7087fb5929ce
experimental: true
---

## Overview

Antlers is a fundamental feature of Statamic. It features a tightly coupled template language and library of [Tags](#tags) that can be used to fetch and manipulate data, handle logic, and help you write easier to maintain HTML.

Antlers templates are also called views. Any files in the `resources/views` directory with a `.antlers.html` file extension is an "Antlers Template", and will be parsed with the Antlers Engine.

:::tip
The `.antlers.html` extension is important. Without it, your template will be rendered as **unparsed, static HTML**.
:::

### Basic Example

Antlers adds dynamic features on top of HTML through the use "tags" – expressions contained inside a pair of curly braces: `{{` and `}}` Those curly braces (often called double mustaches or squiggly gigglies) look a whole lot like _antlers_ to us, and now you know why we named them that.

This is a very simple Antlers tag.

```
{{ hello_world }}
```

:::tip DON'T SKIP THIS!
## About the New Antlers Engine {#about}

Not only this new Antlers Engine a complete and fundamental rewrite, but it takes a completely different, more sophisticated approach to the businesss of template parsing.

The original parser was essentially a glorified find and replace machine relying heavily on RegEx. It parsed and evaluated logic as it worked its way through the template. This means it couldn't stop, go backwards, set variables, or handle nested logic well because it had to keep moving forward. It also slowed down the larger the template got because of the amount of characters being pushed through the RegEx.

The New Antlers Engine now has **two stages** – first, it parses and buids an Abstract Syntax Tree from your complete template, and _then_ it evalutes and executes the nodes and logic in the tree in a runtime fashion (much like a programming language) according to the established rules.

This affords Statamic an incredible amount of control. It can go sideways and slatways and longways and backways and squareways and frontways and any other ways that you can think of. This in turn allowed us to build dozens of new features, fix every single Parser-related bug, and support syntax scenarios that were impossible in the previous "parse _and_ evaluate" flow. Features like...

- The ability to _set_ variables
- Syntax errors that reference the exact line, character, and type of error
- The ability to control parse order through sub-expressions
- Merging the results of multiple expressions
- Perform a robust set of mathmatical operations
- Concatenate, increment, and decrement values
- Extended syntax that provide better type handling
- A smarter, more forgiving matching engine so more things Just Work™
- Self-iterating assignment
- Self-closing tags
- Run-time caching for huge performance boosts

This new engine is a powerful factory, mad scientist labratory, and wizarding school all rolled into one. 🏭🧑‍🔬🧙‍♀️
### It's Still Experimental {#experimental}

Because of how fundamental Antlers is to the whole Statamic experience, we wanted to ship this new version under an **opt-in** feature flag in the event it affects the behavior or output of one or more of your templates. Here are a few conditions we wish to avoid, in order of most-to-least likely scenarios:

1. Templates that rely on a bug in the RegEx parser
1. Templates that rely on undocmented behaviors or features that may have been removed in the New Parser
1. Actual regressions created by the new parser
1. Your performance gains are so high that your site rips a hole in the Space Time Continuum

### How to Enable It {#enable}

To try out the new Antlers engine, switch the `statamic.antlers.version` config option from `regex` to `runtime` in `config/statamic/antlers.php`. If you don't have this config file, create it and add the following:

```php
// config/statamic/antlers.php
return [
    'version' => 'runtime',
    // ...
];
```

### Huge Thanks to John Koster

This rewrite was a huge undertaking by the incomparable [John Koster](https://github.com/JohnathonKoster), who apparently found it a relaxing break from his day job. You can see the effort involved in this [massive PR](https://github.com/statamic/cms/pull/4257).

We owe him a debt of gratitude for this amazing gift.
:::

## The Basics

### Delimiters

There are three kinds of delimiters.

- `{{ ... }}`  The basic and most commonly used kind, used to render variables, evaluate expressions, call Tags, and do all the core Statamic things.
- `{{? ?}}` Allows you to write and execute PHP.
- `{{# #}}` Are for code comments.


Before getting into listing all the things that happen _inside_ an Antlers expression, lets take a moment to establish the rules for properly formatting one.

### Formatting Rules

1. Each set of curly braces **must** stay together always, like Kenan & Kel or Wayne & Garth. There must be a left pair and a right pair, just like HTML's `<` and `>` angle braces.
1. Expressions are **case sensitive**.
3. Hyphens and underscores are **not** interchangeable.
1. Whitespace between the curly braces expression is optional, but **recommended** for readability.
1. You **may** break up an expression onto multiple lines.

Consistency is important. We recommend using a single space between braces and the inner expression, lowercase variable names, and underscores as word separators. Pick your style and stick to it. Future you will thank you, but don't expect a postcard.

``` antlers
This is great!
{{ perfectenschlag }}

This is allowed.
{{squished}}

This can make sense when you have lots of parameters.
{{
  testimonials
  limit="5"
  order="username"
}}

This is terrible in every possible way.
{{play-sad_Trombone            }}
```

:::tip
We recommend indenting the markup in your HTML for **human readability and maintainability**, not for final rendered output. Anyone still caring about that this day and age probably needs a long vacation and strong Mai Thai or two. 🍹🍹
:::

### IDE Integrations

Syntax highlighting and auto-completion packages are available for many of the popular IDEs:

**The VS Code Extension is the most powerful one by far.**

- [Antlers for VS Code](https://antlers.dev)
- [Antlers for Sublime Text](https://github.com/addisonhall/antlers-statamic-sublime-syntax)
- [Antlers for Atom](https://github.com/addisonhall/language-antlers)

## Variables

Data passed into your Antlers views can be rendered by wrapping the name of a variable with double curly braces. For example, given the following data:

``` yaml
---
title: DJ Jazzy Jeff & The Fresh Prince
---
```

The `title` variable can be rendered like this:

``` antlers
<h1>{{ title }}</h1>
```

``` html
<h1>DJ Jazzy Jeff & The Fresh Prince</h1>
```

### Valid Characters

Variable must start with an alpha character or underscore (`a-zA-Z_`), followed by any number of additional uppercase or lowercase alphanumeric characters, hyphens, or underscores (`a-zA-Z_0-9`). Spaces or other special characters are not allowed.

Don't be weird and mix-and-match them like a serial killer though:

```
<!-- Get outta here. -->
{{ this_iS-RiDicuL-ou5_ }}
```


### Strings

Strings (simple sequences of text) are one of the most basic data types. They come in the form of variables or static expressions. To render a string variable, wrap the name with double curly braces.

```
<h1>{{ title }}</h1>
```

Antlers also handles static expressions, which are useful when concatenating a as string together, setting fallback or default values, combining with [modifiers](#modifiers), and numerous other situations we can't think of right now but you may find yourself in eventually.

To render a static string, wrap it in single or double quotes, inside a pair of curly braces.

```
<h1>{{ "I will eat you, donut" | upper }}</h1>
```

``` html
<h1>I WILL EAT YOU, DONUT</h1>
```

### Arrays
An Array is a collection of elements (values and/or variables). Elements inside the array may be iterated or looped through using the `{{ value }}` variable. You may also "reach in" and pluck out specific elements by their index.

#### Looping

```
---
songs:
  - Brand New Funk
  - Parents Just Don't Understand
  - Summertime
---

<ul>
{{ songs }}
  <li>{{ value }}</li>
{{ /songs }}
</ul>
```

``` html
<ul>
  <li>Brand New Funk</li>
  <li>Parents Just Don't Understand</li>
  <li>Summertime</li>
</ul>
```

#### Plucking

To pluck values out of an array, you may use "colon", "dot", or "bracket" notation to pull out values by their array key. All three of these syntaxes are equivalent, so feel free to use the one that feels most natural to you. Note that the first item of the array starts with a zero-index key.

```
---
sports:
  - BMXing
  - rollerblading
  - skateboarding
  - scootering
---

<p>Let's go {{ sports:0 }}, {{ sports.1 }} or {{ sports[2] }}.</p>
```

``` html
<p>Let's go BMXing, rollerblading, or skateboarding.</p>
```

#### Dictionaries

Dictionaries are represented in YAML by nested key:value pairs, _inside_ another variable name. These are sometimes called element maps, or associative arrays.

``` yaml
mailing_address:
  address: 123 Foo Ave
  city: Barville
  province: West Exampleton
  country: Docsylvania
```

You can access the keys inside the dictionary "colon", "dot", or "bracket" notation to traverse the levels of the array. All three of these syntaxes are equivalent, so feel free to use the one that feels most natural to you.

``` antlers
I live in {{ mailing_address:city }}. It's in {{ mailing_address }}
```

#### Multi-Dimensional Arrays
More complex data is stored in objects or arrays inside arrays. This is usually called a multi-dimensional array.

``` yaml
skaters:
  -
    name: Tony Hawk
    style: Vert
  -
    name: Rodney Mullen
    style: Street
  -
    name: Bob Burnquist
    style: Vert
```

If you know the names of the variables inside the array, you can loop through the items and access their variables.

``` antlers
{{ skaters }}
<div class="card">
  <h2>{{ name }}</h2>
  <p>{{ style }}</p>
</div>
{{ /skaters }}
```

``` html
<div class="card">
  <h2>Tony Hawk</h2>
  <p>Vert</p>
</div>
<div class="card">
  <h2>Rodney Mullen</h2>
  <p>Street</p>
</div>
<div class="card">
  <h2>Bob Burnquist</h2>
  <p>Vert</p>
</div>
```

You may also use "colon", "dot", or "bracket" notation to access individual values. Note that the first iteration of the array starts with a zero-index.

```
{{ skaters:0:name }}
{{ skaters.1.name }}<br>
{{ skaters[2]['name'] }}<br>
```

``` html
Tony Hawk<br>
Rodney Mullen<br>
Bob Burnquist
```
#### Dynamic Access

If you don't know the names of the keys inside the array – which can happen when working with dynamic or user submitted data – you can access the elements dynamically using variables for the key names.

Using the mailing list example, we could use a `field` variable to access specific keys.

``` md
---
field: country
mailing_address:
  address: 123 Scary Mansion Lane
  country: Docsylvania
  city: Arteefem
  postal_code: RU 7337
---
{{ mailing_address[field] }}

// Output
Docsylvania
```

You can combine literal and dynamic keys and get real fancy if you need to.

```
{{ complex_data:[3][field]['title'] }}
```

### Modifiers

Modifers change the output of an Antlers variable. They are used inside any expression and are separated by a pipe character `|`.

Multiple modifiers can be chained on one output, each sparated by another pipe |`|, and are are applied in order from left to right. Let's look at an example.

```
---
title: Nickelodeon Studios
---

<!-- NICKELODEON STUDIOS rocks! -->
<h1>{{ title | upper | ensure_right('rocks!') }}</h1>

<!-- NICKELODEON STUDIOS ROCKS! (order matters) -->
<h1>{{ title | ensure_right('rocks!') | upper }}</h1>
```

Some modifiers accept parameters to control their behavior. Arguments can be passed inside a pair of `()` braces, just like a native PHP function. If you don't have any arguments to pass, you may omit the braces.

You may pass `strings`, `arrays`, `booleons`, `integers`, `floats`, `objects`, or references to existing variables as arguments.

```
{{ var | modifier('hi', ['pooh', 'pea'], true, 42, $favoriteVar) }}
```

##### Examples
Here are a few examples of modifiers in action.

```
---
summary: "It was the best of times, it was the worst of times."
noun: soups
---

{{ summary | replace('worst', 'yummiest') }}
{{ summary | replace('It was', 'It was also') | replace('times', $noun) }}
{{ summary | explode(' ') | ul }}
{{ (summary | contains('best')) ?= "It was lunch, is what it was." }}
```

```
It was the best of times, it was the yummiest of times.
It was the best of soups, it was the worst of soups.
<ul><li>It</li><li>was</li><li>the</li><li>best</li><li>of</li><li>times,</li><li>it</li><li>was</li><li>the</li><li>worst</li><li>of</li><li>times.</li></ul>
It was lunch, is what it was.
```

There are more than 150 built-in [modifiers][modifiers] that can do anything from array manipulations to automatically writing HTML for you. You can also [create your own modifiers](/extending/modifiers) to do unthinkable things we assumed nobody would ever need to do, until you arrived.

#### Legacy Syntax

The New Antlers Parser still supports what we're now calling the "[Legacy Syntax](/antlers#stringshorthand-style)" styles, and will continue to do so until Statamic 4.0.

### Creating Variables 🆕

You can now set variables by using the assignment operator, `=`.

```
{{ total = 0 }}

{{ loop from="1" to="9" }}
  {{ total += 1 }}
{{ /loop}}

<p>I can count to {{ total }}!</p>
```

```
<p>I can count to 9!</p>
```

#### Arrays
You can also create arrays, if you find the need. Keep in mind that more complex data _might_ be better suited to being managed in Entries, Globals, View Models, or Controllers.

```
{{ todo = ['Get haircut', 'Bake bread', 'Eat soup'] }}

<ul>
  {{ todo }}
    <li>{{ value }}</li>
  {{ /todo }}
</ul>
```

#### Sub-Expressions

You can assign sub-expressions or interpolated statements to variables too. In this example, you can use `{{ items }}` as if it were the actual Collection Tag. Because it is.

```
{{ items = {collection:products sort="rating:desc" limit="5"} }}

<h2>Our Top Products</h2>
<ul>
  {{ items }}
    <li><a href="{{ url }}">{{ title }}</a></li>
  {{ /items }}
</ul>
```

### Truthiness

All variables are considered "truthy" if the exist and contain a value. Variables that _don't_ exist, contain an empty string, or are structured and empty (e.g. an empty array or object) are considered "falsy".

This is a powerful pattern that can help keep template logic simple and uncluttered. For instance, you can set a series of "fallback" variables all in one expression, allowing you to have default values and optionally override them instead of having to a bunch of `if`/`else` checks.

```
<!-- Which one is better? -->
<title>
  {{ if meta_title }}
    {{ meta_title }}
  {{ elseif title }}
    {{ title }}
  {{ else }}
    {{ site:name }}
  {{ /if }}
</title>

<!-- Don't be ridiculous, the answer is this one.  -->
<title>{{ meta_title ?? title ?? site:name }}</title>
```

Another use case is when you _sometimes_ have an array variable to loop through in a template to render some markup. You may skip the existance check entirely, keep the markup inside the loop, and if the variable doesn't exist, nothing inside the tag pair will be rendered.

```
{{ nothing_to_see_here }}
  <!-- Doesn't matter, won't see it -->
{{ /nothing_to_see_here }}
```

### Disambiguation 🆕 {#disambiguation}

As your templates grow and increase in complexity, you _may_ find yourself unsure if you're working with a variable or a [tag](#tags). You may optionally disambiguate your variables by prefixing them with a `$` dollar sign, just like PHP.

```
{{ $content }}
```

### Escaping

By default, Antlers `{{ }}` statements are _not_ automatically escaped. Because content is often stored along with HTML markup, this is the most logical default behavior. **But remember: never render user-submitted data without escaping it first!**

The simplest way to escape data is by using the [sanitize](/modifiers/sanitize) modifier. This will run the data through PHP's `htmlspecialchars()` function and prevent XSS attacks and other potential nastiness.

```
{{ user_submitted_content | sanitize }}
```


## Operators

### Control Flow

### Comparison

Antlers can handle logic and conditional statements with the use of numerous operators, just like native PHP. You can use these operators to check settings, variables, or even user data and alter the output of your page.

You may construct conditional statements using comparison and logical operators like `if`, `else`, and `or`.

<!-- and use any of PHP's [comparison](https://www.php.net/manual/en/language.operators.comparison.php) and [logical](https://www.php.net/manual/en/language.operators.logical.php) operators. -->


| Name | Syntax {.w-40} | Description |
|---|---|---|
| Loose Equality | `this == that` | Tests if the left and right sides are equal. Types will be coerced. |
| Strict Equality | `this === that` | Tests if the left and right are of the same type, _and_ have the same value. |
| Greater Than | `this > that` | Tests if the value on the left is greater than the right. |
| Greater Than or Equal | `this >= that` | Tests if the left is greater than or equal to the right. |
| Less Than | `this < that` | Test if the left is less than the right. |
| Less Than or Equal | `this <= that` | Tests if the left is less than or equal to the right. |
| Not Equal | `this != that` |  Tests if the left is not equal to the right. Types will be coerced. |
| Not Strict Equal | `this !== that` | Tests if the left is not equal to the right, only if they are of the same type. |
| Spaceship Operator | `this <=> that` | Returns -1, 0 or 1 when left expression is respectively less than, equal to, or greater than the right. |

#### Examples

```
{{ if songs === 1 }}
  <p>There is a song!</p>
{{ elseif songs > 100 }}
  <p>There are lots of songs!</p>
{{ elseif songs }}
  <p>There are songs.
{{ else }}
  <p>There are no songs.</p>
{{ /if }}
```

#### Ternary Statements {#ternary}

Ternary statements will let you write a simple if/else statement all in one line. This syntax can be a double-edged sword – they're terse but when used in complex conditions can be hard to wrap your mind grapes around.

```
// Basic: verbose
This item is {{ if is_sold }}sold{{ else }}available{{ /if }}.

// Ternary: nice and short
This item is {{ is_sold ? "sold" : "available" }}.
```

Learn more about [ternary operators][ternary] in PHP.

#### Null Coalescence

When all you need to do is display a variable will support for one or more fallback variables or values, use the null coalescence operator (`??`).

#### Truthy Assignment (Gatekeeper Operator)

What if you want to display a variable or evaluate an expression _but only if_ it passes a truthy check? Time for the Gatekeeper Operator. It doesn't exist in any other programming language, but should. Enjoy!

```
// Short and sweet
{{ show_title ?= title }}

// Longer and bitterer
{{ if show_title }}{{ title }}{{ /if }}
```

This syntax will work for any expression on the "right-hand" side. Just make sure that when using the Gatekeeper that it's the most readable way to construct the template. For example, you could check a toggle field before rendering a partial, all in one clean line.

```
{{ show_newsletter ?= {partial:newsletter} }}
```

### Concatenation 🆕

To concatenate a string, use a `+` plus sign between variables and/or static strings to combine them into a single string. Whether you use concatenation or multiple variables is up to you. Opt for whatever makes the code most readable.

```
---
title: Marv's Coffee Shop
quality: pretty good
---

<p>{{ $title + " makes " + $quality + " donuts." }}</p>
<p>{{ title }} makes {{ quality }} donuts.</p>
```

```html
<p>Marv's Coffee Shop makes pretty good donuts.</p>
<p>Marv's Coffee Shop makes pretty good donuts.</p>
```

### Incrementing and Decrementing 🆕

### Array

### Arithmetic 🆕

### Assignment 🆕

### Scope

### Terminator 🆕


## Expressions

### Literals

### Sub-Expressions

### Merge

### OrderBy

### Self-Iterating Assignments



### Modifiers Inside Conditions

If you want to manipulate a variable with [modifiers](/modifiers) before evaluating a condition, wrap the expression in (parenthesis).

```
{{ if (number_of_bedrooms | count) > 10 }}
  <p>Who are you, Dwane Johnson?</p>
{{ /if }}
```


### Using Tags in Conditions

Yes, you can even use tags in conditions. When working with [tags][tags] instead of variables, you **must** wrap the tag in a pair of additional single braces to tell the parser to run that logic first.

```
{{ if {session:some_var} == "Statamic is rad!" }}
  ...
{{ /if }}
```

## Tags

[Tags][tags] are the primary method for implementing most of Statamic's dynamic features, like search, forms, nav building, pagination, collection listing, filtering, image resizing, and so on.

Tags often look quite similar to variables, so it pays to learn the list of available [Tags][tags] so you don't mix them up or create conflicts.

### Variables Inside Tag Parameters

There are two ways to use variables _inside_ a Tag's parameters.

You can use **dynamic binding** to pass the value of a variable via its name.

```
{{ nav :from="segment_1" }}
```

Alternatively, you can use **string interpolation** and reference any variables with _single braces_. This method lets you concatenate a string giving you the ability assemble arguments out of various parts. Like Frankenstein's monster.

```
{{ nav from="{segment_1}/{segment_2}" }}
```

### Modifiers Inside Parameters

If using a variable inside of a Tag is nice, using a variable with a modifier inside of a Tag is better. Or more complicated. Either way, it works exactly as you’d expect with one small caveat: When using a modifier inside of a Tag, no whitespace is allowed between variables, pipes, and modifiers. Collapse that stuff.

```
// Totally fine.
{{ partially:broken src="{featured_image|url}" }}

// Totally not.
{{ partially:broken src="{ featured_image | url }" }}
```

## Prevent Parsing

You may find you need to prevent Antlers statements from being parsed. This is common if you're using a JavaScript library like [Vue.js][vue], or perhaps you want to display code examples (like we do in these docs). In either case, you have a few options.

### The `@` ignore symbol

First, you may use an `@` symbol on the outside of your curly braces to tell Antlers to leave it alone like a jellyfish on the beach. The `@` symbol will be stripped out automatically leaving nothing but your full expression behind.

```
Hey, look at that @{{ noun }}!
```

``` html
Hey, look at that {{ noun }}!
```

### The `noparse` Tag

Use this method if you need to prevent entire code blocks from being parsed.

```
{{ noparse }}
  Welcome to {{ fast_food_chain }},
  home of the {{ fast_food_chain_specialty_item }},
  can I take your order?
{{ /noparse }}
```

## Using Antlers in Content

By default, Antlers expressions and tags are **not** parsed inside your content. This is for performance and security reasons.

For example, a guest author with limited access to the control panel could conceivably write some template code to fetch and display published/private content from a collection they don't access to.

If this isn't a concern of yours, you can enable Antlers parsing on a per-field basis by setting `antlers: true` in your blueprint.

## Code Comments {#comments}

Antlers code comments are not rendered in HTML (unlike HTML comments), which allos you to use them to "turn off" chunks of code, document your work, or leave notes and inside jokes for yourself and other developers.

```
{{# Remember to replace the lorem ipsum this time, Karen! #}}
```

## Using PHP in Antlers

`{{? ?}}` is the ticket.

Or, you can change your view's file extension from `.antlers.html` to `.antlers.php` and you can write all the raw PHP you want using native PHP tags.`

```
<?php
  echo 'Keep it simple, please';
?>
```


[ternary]: https://www.php.net/manual/en/language.operators.comparison.php#language.operators.comparison.ternary
[vue]: https://vuejs.org
[modifiers]: /modifiers
[tags]: /tags

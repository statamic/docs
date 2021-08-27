---
title: 'Antlers Templates'
intro: 'Antlers is a simple and powerful templating engine provided with Statamic.  It can fetch and filter content, display and modify data, tap into core features like user authentication and search, and handle complex logic.'
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1568806133
blueprint: page
template: page
stage: 2
id: dcf80ee6-209e-45aa-af42-46bbe01996e2
---
## Overview

Antlers view files are often called templates. Any files in your `resources/views` directory using an `.antlers.html` file extension will be parsed with the Antlers engine.

> The `.antlers.html` extension is important. Without it, it would just be plain HTML and you won't get the Antlers features.


## Antlers Syntax

Antlers adds capabilities on top of HTML through the use of curly brace expressions. Those curly braces – often called double mustaches or squiggly gigglies – look a whole lot like _antlers_ to us, hence the name.

```
{{ hello_world }}
```

Before getting into listing all the things that happen _inside_ an Antlers expression, lets take a moment to establish the rules for properly formatting one.

### Formatting Rules

1. Each set of curly braces **must** stay together always, like Kenan & Kel or Wayne & Garth.
2. Expressions are **case sensitive**.
3. Hyphens and underscores are **not** interchangeable.
4. Whitespace between the curly braces and inner text is **recommended**, but optional.
5. You **can** break up an expression onto multiple lines.

Consistency is important. We recommend using single spaces between braces, lowercase variable names, and underscores as word separators. Picking your style and stick to it. Future you will thank you, but don't expect a postcard.

```
// This is great!
{{ perfectenschlag }}

// This is allowed.
{{squished}}

// This can make sense when you have lots of parameters.
{{
  testimonials
  limit="5"
  order="username"
}}

// This is terrible in every way.
{{play-sad_Trombone            }}
```

---

## Displaying Data

You can display data passed into your Antlers views by wrapping the variable name in curly braces.

Let's take the following data as an example:

``` yaml
---
title: DJ Jazzy Jeff & The Fresh Prince
songs:
  - Boom! Shake the Room
  - Summertime
  - Just Cruisin'
---
```

You can display the contents of the `title` variable like this:
```
<h1>{{ title }}</h1>

// Output
<h1>DJ Jazzy Jeff & The Fresh Prince</h1>
```

### Arrays
Arrays are a collection of elements (values or variables). You can loop through the elements of the array using the `{{ value }}` variable, or reach in and pluck out specific elements by their index.

#### Looping
```
{{ songs }}
  <li>{{ value }}</li>
{{ /songs }}

// Output
<li>Boom! Shake the Room</li>
<li>Summertime</li>
<li>Just Cruisin'</li>
```

#### Plucking

```
<p>Time to {{ songs:0 }} cuz we're {{ songs:2 }}.</p>

// Output
<p>Time to Boom! Shake the Room cuz we're Just Crusin'.</p>
```

### Dictionaries
Dictionaries are represented in YAML by nested key:value pairs, _inside_ another variable name. These are sometimes called element maps, or associative arrays.

``` yaml
mailing_address:
  address: 123 Foo Ave
  city: Barville
  province: West Exampleton
  country: Docsylvania
```

#### Accessing Data
You can access the keys inside the dictionary by "gluing" the parent/child keys together you want to traverse through, much like breadcrumbs.

```
I live in {{ mailing_address:city }}.

// Output
I live in Barville.
```

### Multi-Dimensional Arrays
More complex data is stored in objects or arrays inside arrays. This is usually called a multi-dimensional array.

``` yaml
skaters:
  -
    name: Tony Hawk
    style: Vert
  -
    name: Rodney Mullen
    style: Street
```

If you know the names of the variables inside the array, you can loop through the items and access their variables.

```
{{ skaters }}
<div class="card">
  <h2>{{ name }}</h2>
  <p>{{ style }}</p>
</div>
{{ /skaters }}

// Output
<div class="card">
  <h2>Tony Hawk</h2>
  <p>Vert</p>
</div>
<div class="card">
  <h2>Rodney Mullen</h2>
  <p>Street</p>
</div>
```

### Dynamic Access
If you don't know the names of the keys inside the array – which can happen when working with dynamic or user submitted data – you can access the elements dynamically using variables for the key names.

Using the mailing list example, we could use a `field` variable to pluck out specific keys.

```
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

You can use this same syntax with literal key names as well.

```
// These are equivalent
{{ mailing_address:city }}
{{ mailing_address['city'] }}
```

You can combine literal and dynamic keys and get real fancy if you need to.

```
{{ complex_data:3[field]['title'] }}
```

## Modifying Data

The way data is stored is not always the way you want it presented. The simplest way of modifying data is through the use of variable modifiers.

### Variable Modifiers

Each variable modifier is a function that accepts the value of a variable, manipulates it in some way, and returns it. Modifiers can be chained and are executed in sequence, from left to right inside the Antlers statement.

Let's look at an example.

```
---
title: Nickelodeon Studios
---

// NICKELODEON STUDIOS rocks!
<h1>{{ title | upper | ensure_right:rocks! }}</h1>

// NICKELODEON STUDIOS ROCKS! (order matters)
<h1>{{ title | ensure_right:rocks! | upper }}</h1>
```

There are over 130 built in [modifiers][modifiers] that do everything from find and replace to automatically write HTML for you.

Modifiers can be written in two styles in order to support different use cases and improve readability.

### String/Shorthand Style

Modifiers are separated by `|` pipe delimiters. Parameters are delimited by `:` colons. This is usually the recommended style while working with string variables, conditions, and when you don't need to pass multi-word arguments in a parameter.

```
{{ string_var | modifier_1 | modifier_2:param1:param2 }}
```

If you use this string/shorthand style on arrays, you need to make sure the closing tag matches the opening one **exactly**. You may notice this looks terrible and is quite annoying. That's why we also have the...

### Array/Tag Parameter Style

Modifiers on array variables are formatted like Tag parameters. Parameters are separated with `|` pipes. You can’t use modifiers in conditions when you format them this way.

```
{{ array_var modifier="param1|param2" }}
  // Magic goes here
{{ /array_var }}
```

> You **cannot** mix and match modifier styles.
> ie. This totally won't work: `{{ var | foo | bar="baz" }}`

### Escaping Data

By default, Antlers `{{ }}` statements are _not_ automatically escaped. Because content is often stored along with HTML markup, this is the most logical default behavior. **But remember: never render user-submitted data without escaping it first!**

The simplest way to escape data is by using the [sanitize](/modifiers/sanitize) modifier. This will run the data through PHP's `htmlspecialchars()` function and prevent XSS attacks and other potential nastiness.

```
{{ user_submitted_content | sanitize }}
```

---

## Logic & Conditions {#conditions}

Antlers can handle logic and conditional statements, just like native PHP. You can use logic to check settings, variables, or even user data and alter the output of your page.

You may construct conditional statements using the `if`, `else`, `elseif`, `unless` keywords, and use any of PHP's [comparison](https://www.php.net/manual/en/language.operators.comparison.php) and [logical](https://www.php.net/manual/en/language.operators.logical.php) operators.

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


<blockquote class="tip"><strong>Antlers variables are null by default.</strong> Keep your logic statements simple and skip checking for existence altogether.</blockquote>

### Shorthand Conditions (Ternary)

Basic ternary operators will let you write a simple if/else statement all in one line.

```
// Basic: verbose
This item is {{ if is_sold }}sold{{ else }}available{{ /if }}.

// Ternary: nice and short
This item is {{ is_sold ? "sold" : "available" }}.
```

Learn more about [ternary operators][ternary] in PHP.

### Modifiers Inside Conditions

If you want to manipulate a variable with [modifiers](/modifiers) before evaluating a condition, wrap the expression in (parenthesis).

```
{{ if (number_of_bedrooms | count) > 10 }}
  <p>Who are you, Dwane Johnson?</p>
{{ /if }}
```

### Variable Fallbacks (Null Coalescence)

When all you need to do is display a variable and set a fallback when it’s null, use the null coalescence operator (`??`).

```
{{ meta_title ?? title ?? "No Title Set" }}
```

### Conditional Variable Fallbacks

What if you want to combine an `is set` check with a ternary operator? No problem.

```
// Short and sweet
{{ show_title ?= title }}

// Longer and bitterer
{{ if show_title }}{{ title }}{{ /if }}
```

### Using Tags in Conditions

Yes, you can even use tags in conditions. When working with [tags][tags] instead of variables, you **must** wrap the tag in a pair of additional single braces to tell the parser to run that logic first.

```
{{ if {session:some_var} == "Statamic is rad!" }}
  ...
{{ /if }}
```
---

## Code Comments {#comments}

Antlers also allows you to define comments in your views. However, unlike HTML comments, Antlers are not included in the rendered HTML. You can use these comments to "turn off" chunks of code, document your work, or leave notes for yourself and other developers.

```
{{# Remember to replace the lorem ipsum this time. #}}
```

---

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

---

## Prevent Parsing

You may find you need to prevent Antlers statements from being parsed. This is common if you're using a JavaScript library like [Vue.js][vue], or perhaps you want to display code examples (like we do in these docs). In either case, you have a few options.

First, you may use an `@` symbol to tell Antlers to leave it alone like a jellyfish on the beach. The `@` symbol will be stripped out automatically leaving nothing but your expression behind.

```
Hey, look at that @{{ noun }}!
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

## Using PHP in Antlers

PHP is disabled by default, but if you change your view's file extension from `.antlers.html` to `.antlers.php`, you can write all the PHP you want in that template.

## IDEs & Syntax Highlighters

Syntax highlighting packages are available for most of the popular IDEs. Make life sweeter, like they do with tea in the south.

- [Antlers for Atom](https://github.com/addisonhall/language-antlers)
- [Antlers for Sublime](https://github.com/addisonhall/antlers-statamic-sublime-syntax)
- [Antlers for VS Code](https://github.com/addisonhall/ahdesign.antlers)


[ternary]: https://www.php.net/manual/en/language.operators.comparison.php#language.operators.comparison.ternary
[vue]: https://vuejs.org
[modifiers]: /modifiers
[tags]: /tags

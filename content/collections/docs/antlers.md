---
title: 'Antlers Templates'
intro: 'Antlers is a simple and powerful templating engine provided with Statamic.  It can fetch and filter content, displaying and modify data, tap into core features like user authentication and search, and handle complex logic.'
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1568806133
blueprint: page
template: page
stage: 2
id: dcf80ee6-209e-45aa-af42-46bbe01996e2
---
## Overview

Antlers view files are often called templates. Any files in your `resources/views` directory that use the `.antlers.html` file extension will be parsed with the Antlers engine.


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

```.language-yaml
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

Arrays are a collection of elements (values or variables). You can loop through the elements of the array to access and display their contents.

```
{{ songs }}
  <li>{{ value }}</li>
{{ /songs }}

// Output
<li>Boom! Shake the Room</li>
<li>Summertime</li>
<li>Just Cruisin'</li>
```

---

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
<h1>{{ title | uppercase | ensure_right:rocks!}}</h1>

// NICKELODEON STUDIOS ROCKS! (order matters)
<h1>{{ title | ensure_right:rocks! | uppercase }}</h1>
```

There are over 130 built in [modifiers][modifiers] that do everything from find and replace to automatically write HTML for you.

Modifiers can be written in two styles in order to support different use cases and improve readability.

### String/Shorthand Style

Modifiers are separated by `|` pipe delimiters. Parameters are delimited by `:` colons. This is usually the recommended style while working with string variables, conditions, and when you don't need to pass multi-word arguments in a parameter.

```
{{ string_var | modifier_1 | modifier_2:param1:param2 }}
```

If you use this string/shorthand style on arrays, you need to be sure to make sure the closing tag matches the opening one **exactly**. You may notice this looks terrible and is quite annoying. That's why we also have the...

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

By default, Antlers `{{ }}` statements are _not_ automatically escaped. Because content is often stored along with HTML markup, this default state is logical. **Never rendered user-submitted data without escaping it first!**

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

### Variable Fallbacks (Null Coalescence)

When all you need to do is display a variable and set a fallback when it’s falsey, use the null coalescence operator (`??`).

```
{{ meta_title ?? title ?? "No Title Set" }}
```

### Conditional Variable Fallbacks (Null Coalescing Assignment)

What if you want to combine an `is set` check with a ternary operator? We've got that covered too.

```
// Short and sweet
{{ show_title ??= title }}

// Longer and bitterer
{{ if show_title }}{{ title }}{{ /if }}
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

## Syntax Highlighting

Syntax highlighting packages are available for most of the popular IDEs. Make life that much sweeter.

- [Antlers for Atom](https://github.com/addisonhall/language-antlers)
- [Antlers for Sublime](https://github.com/addisonhall/antlers-statamic-sublime-syntax)
- [Antlers for VS Code](https://github.com/addisonhall/ahdesign.antlers)


[ternary]: https://www.php.net/manual/en/language.operators.comparison.php#language.operators.comparison.ternary
[vue]: https://vuejs.org
[modifiers]: /modifiers
[tags]: /tags

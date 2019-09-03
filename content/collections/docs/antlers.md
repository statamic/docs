---
title: Antlers
intro: 'Antlers is a simple and powerful templating engine provided with Statamic.  It can fetch and filter content, displaying and modify data, and handle logic. Antlers view files (also called templates) use the `.antlers.html` file extension and are typically stored in the `resources/views` directory.'
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1567519954
blueprint: page
id: dcf80ee6-209e-45aa-af42-46bbe01996e2
---
## Antlers Syntax

Most of the what Antlers can do is provided through the use of curly brace statements. Those curly braces – often called double mustaches or squiggly braces – look a whole lot like _antlers_ to us, hence the name.

```
{{ this_is_an_antlers_tag }}
```

### Formatting Tips

Here are a few tips and gotchas to look for.

- **Variables and Tag names are case sensitive**. That means `{{ ninjaturtle }}` and `{{ ninjaTurtle }}` are not interchangeable.
- **Hyphens and underscores are not interchangeable.** For example, `{{ space_jam }}` and `{{ space-jam }}` might as well be from separate planets.
- Spaces between braces and inner text are optional.

We recommend using spaces between braces, lowercase variable names, and underscores as word separators. Consistency is key, so whatever your preference, stick to it.

```
// How we do it.
{{ perfectenschlag }}

// Stop it.
{{sad-trombone_plays    }}
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

### Escaping Data

By default, Antlers `{{ }}` statements are _not_ automatically escaped. Because content is often stored along with HTML markup, this default state is logical. **Never rendered user-submitted data without escaping it first!**

The simplest way to escape data is by using the [sanitize](/modifiers/sanitize) modifier. This will run the data through PHP's `htmlspecialchars()` function and prevent XSS attacks and other potential nastiness.

```
{{ user_submitted_content | sanitize }}
```

---

## Comments

Antlers also allows you to define comments in your vies. However, unlike HTML comments, Antlers are not included in the rendered HTML. You can use these comments to "turn off" chunks of code, document your work, or leave notes for yourself and other developers.

```
{{# Remember to replace the lorem ipsum this time. #}}
```

---

## Conditional Statements

Antlers can also handle logic and conditional statements, much like native PHP.

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


<blockquote class="tip"><strong>Antlers variables are null by default.</strong> Keep your logic statements simple and skip checking for existence.</blockquote>

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



[ternary]: https://www.php.net/manual/en/language.operators.comparison.php#language.operators.comparison.ternary
[vue]: https://vuejs.org
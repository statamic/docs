---
title: YAML
intro: YAML is a data storage format designed to be human readable and easily manipulated by hand. It's interchangeable with JSON and in most cases easier to write. Statamic uses YAML extensively to store data, content, and settings.
template: page
id: 93cf3f23-24c4-4722-a6e2-5b369e952a3b
blueprint: page
---
## What is YAML?

`<tangent>`YAML stands for "YAML Ain't Markup Language". It's a rare example of the elusive [recursive acronym][recursive-acronym]. At one point it stood for "Yet Another Markup Language" but semantically-oriented people quickly shut it down, denoting the fact that nothing was being marked up, but rather data was being structured. So on that fateful day (probably a Wednesday), YAML became self-referential. `</tangent>`.

YAML complies with the JSON spec, making it easy to interchange it with nearly any native data format. It consists of key and value pairs delimited by a colon then a space.

```yaml
variable_name: value
```

YAML is usually stored in `.yaml` or `.yml` files, but can often (and in Statamic's case) can be found inside and top of other text files. This is referred to as "Front Matter" and looks like this:

```md
---
title: Hello there! this is Front Matter!
---
Letters are strung together in a specific order down here.
```

## Strings

A string is a single sequence of characters. It might be a single word or a huge chunk of HTML, but it's always a single element. These following variable definitions, in different languages and formats, are equivalent:

```yaml
school: Flatside High
```

```php
$school = "Flatside High";
```

```js
var school = "Flatside High";
```

### String Escaping

As YAML is a **structured** data format, you will occasionally need to quote your strings to prevent rogue apostrophes, commas, and other reserved constructs from confusing the parser, allowing you to structure your data exactly as desired.

:::tip
YAML uses **2 spaces** for indentation. Not 3, not 4, not 12, but 2.
:::

You can also use quotes to force or typecast another datatype as a string, For example, if your key or value is `10` but you want it to return a String and not an Integer, write `'10'` or `"10"`.

```yaml
# Probably broken
cartoon: Rocko's Modern Life

# Perfection
cartoon: "Rocko's Modern Life"
```

### Preserving Newlines

You can preserve the line breaks in your string block by using the `|` pipe symbol followed by a line break and indented content. This is useful if you're writing Markdown or preserving HTML line breaks.

```yaml
lyrics: |
  When I wake up in the morning
  And the alarm gives out a warning
  And I don't think I'll ever make it on time
  By the time I grab my books
  And I give myself a look
  I'm at the corner just in time to see the bus fly by
```

### Collapsing Newlines

Completely ignore line breaks with a `>` character and indent the rest of the content.

```yaml
test: >
  These
  lines will
  be collapsed
  into a single
  paragraph.

  Blank lines are
  treated as
  paragraph breaks.
```

## Numbers

Numbers are represented as numerals without any "string quotes". Those quotes were meant to demonstrate what string quotes are, not [mock them](https://media.giphy.com/media/Kc7qzYMnOTcDb0aEw5/giphy.gif).

```yaml
# an integer
number: 12

# a float
number: 26.2

# a hexadecimal
number: 0xC

# an exponential number
number: 1.2e+34
```

## Nulls

Nulls in YAML are expressed with `null` or `~`.

## Booleans

Booleans in YAML are expressed with `true` and `false`.

## Collections

YAML collections can be a sequence (or list). Arrays are lists of values. They can be formatted like a plain-text bulleted list or comma delimited inside brackets, similar to JSON.

```yaml
# These are both valid YAML arrays
to_buy:
  - sunglasses
  - sandals
  - surfboard

to_sell: [aloe vera, winter coat, mittens]
```

To render the values from a YAML array:


### Element Map

```yaml
antisocial:
  facebook: http://facebook.com/statamic
  twitter: http://twitter.com/statamic
```

```php
$antisocial = [
    "facebook" => "http://facebook.com/statamic",
    "twitter" => "http://twitter.com/statamic"
];
```

::tabs

::tab antlers
```antlers
<a href="{{ antisocial:facebook }}">Facebook</a>
<a href="{{ antisocial:twitter }}">Twitter</a>
```
::tab blade
```blade
<a href="{{ $antisocial['facebook'] }}">Facebook</a>
<a href="{{ $antisocial['twitter'] }}">Twitter</a>
```
::

### Nesting mappings and sequences

You can create mappings of sequences, and those sequences can have mappings, and those mappings can have their own sequences and mappings, and so on and on and on until you choose to skip the rest of the paragraph and go onto the next.

This is a very common pattern in Statamic. Bard, Grid, and Replicator fieldtypes all use nested mappings and sequences.

```yaml
students:
  -
    name: Zack Slater
    school: Bayside High
  -
    name: Jack McDade
    school: Flatside High
```

Look at how pretty the data is.

```php
$students = [
    0 => [
        "name" => "Zach Slater",
        "school" => "Bayside High"
    ],
    1 => [
        "name" => "Jack McDade",
        "school" => "Flatside High"
    ]
];
```

### Mixing and Matching

You can build multidimensional arrays full of associative arrays, and vice versa.

```yaml
trips:
  vacation:
    - Miami
    - Malibu
  work:
    - Orlando
    - San Fransisco
```

## Comments

You can comment out any line of YAML by prefixing it with a `#` hash symbol.

```yaml
# title: I Quit My Day Job!
title: Another Monday
```

## Explicit Typing

YAML autodetects the datatype of the entity. Sometimes you'll want to cast the datatype explicitly, like when a single word string looks like a number or  boolean may need disambiguation by surrounding it with quotes or use of an explicit datatype tag.

```yaml
a: 42                      # integer
2: "42"                    # string, disambiguated by quotes
d: 42.0                    # float
l: !!float 42              # float via explicit data type
m: !!str 42                # string, disambiguated by explicit type
n: !!str Yes               # string via explicit type
o: Yes                     # string
p: Yes we have No whiskey  # string, disambiguated by context.
```

## Related Reading

So there you have it &mdash; YAML in its many shapes and forms. To learn how to render all this lovely data in a template, check out the [Antlers][antlers] section.

You can also refer to the [Symfony YAML component][symfony-yaml] and [YAML format][yaml-format] documentation for even more technical and in-depth knowledge gains.

**Bonus points** for reading the full [YAML 1.2 specification document][yaml-spec]. We've done it and it's as dry as a mouthful of cinnamon.

[recursive-acronym]: https://en.wikipedia.org/wiki/Recursive_acronym
[antlers]: /antlers
[symfony-yaml]: https://symfony.com/doc/current/components/yaml.html
[yaml-format]: https://symfony.com/doc/current/components/yaml/yaml_format.html
[yaml-spec]: https://yaml.org/spec/1.2/spec.html

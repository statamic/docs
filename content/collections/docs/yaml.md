---
title: YAML
intro: YAML is a data storage format designed to be human readable and easily manipulated by hand. It interchangeable with JSON and in most cases easier to write. Statamic uses YAML extensively to store data, content, and settings.
template: page
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1568645112
id: 93cf3f23-24c4-4722-a6e2-5b369e952a3b
blueprint: page
---
## What is YAML?

YAML stands for "YAML Ain't Markup Language". It's a rare example of the elusive [recursive acronym][recursive-acronym]. At one point it stood for "Yet Another Markup Language" but semantically-oriented people quickly shut that down, denoting the fact that nothing was being marked up, but rather data was being structured. So on that fateful day (probably a Wednesday), YAML became self-referential. `</tangent>`.

YAML complies with the JSON spec, making it easy to interchange it with nearly any native data format. It consists of key and value pairs delimited by a colon then a space.

```.language-yaml
variable_name: value
```

YAML is usually stored in `.yaml` or `.yml` files, but can often (and in Statamic's case) can be found inside and top of other text files. This is referred to as "Front Matter" and looks like this:

```.language-markdown
---
title: Hello there! this is Front Matter!
---
Letters are strung together in a specific order down here.
```

## Strings

A string is a single sequence of characters. It might be a single word or a huge chunk of HTML, but it's always a single element. These following variable definitions, in different languages and formats, are equivalent:

```.language-yaml
school: Flatside High
```

```.language-php
$school = "Flatside High";
```

```.language-javascript
var school = "Flatside High";
```

## String Escaping

As YAML is a **structured** data format, you will occasionally need to quote your strings to prevent rogue apostrophes, commas, and other reserved constructs from confusing the parser, allowing you to structure your data exactly as desired.

You can also use quotes to force or typecast another datatype as a string, For example, if your key or value is `10` but you want it to return a String and not an Integer, write `'10'` or `"10"`.

```.language-yaml
# Probably broken
cartoon: Rocko's Modern Life

# Perfection
cartoon: "Rocko's Modern Life"
```

## String Block Literals

You may have thought to yourself: "But my string has many lines! It's pile of HTML with lots of quotes, characters, indentation, and tender loving care! What then?" No sweat. YAML supports multi-line strings and they can be written in two ways.

> YAML uses **2 spaces** for indentation. Not 3, not 4, not 12, but 2.

### Preserving Newlines

You can preserve the line breaks in your string block by using the `|` pipe symbol followed by a line break and indented content. This is useful if you're writing Markdown or preserving HTML line breaks.

```.language-yaml
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

```.language-yaml
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

## Lists (Indexed Arrays) {#lists}

Lists can be structured like a plain-text bulleted list or comma delimited inside brackets, much like JSON.

```.language-yaml
to_buy:
  - sunglasses
  - sandals
  - surfboard

to_sell: [aloe vera, winter coat, mittens]
```

When parsed, the data will be converted into typical indexed arrays:

```.language-php
$to_buy = [
    0 => "sunglasses",
    1 => "sandals",
    2 => "surfboard"
];

$to_sell = [
    0 => "aloe vera",
    1 => "winter coat"
    2 => "wittens"
];
```

## Named Lists (Associative Arrays) {#named-lists}

```.language-yaml
antisocial:
  facebook: http://facebook.com/statamic
  twitter: http://twitter.com/statamic
```

```.language-php
$antisocial = [
    "facebook" => "http://facebook.com/statamic",
    "twitter" => "http://twitter.com/statamic"
];
```

```
<a href="{{ antisocial:facebook }}">Facebook</a>
<a href="{{ antisocial:twitter }}">Twitter</a>
```

### Lists of Lists (Multidimensional Arrays) {#lists-of-lists}

You can create lists of lists, and those lists can have lists, and those lists can have their own lists and lists of lists and -- now you should think carefully before you go any deeper but -- those lists can also have some of their very own lists and lists of lists. Got it?

This is a very common pattern in Statamic. Entries Listings, Grid and Replicator fieldtypes, and Search results all use multidimensional array data.

```.language-yaml
students:
  -
    name: Zack Slater
    school: Bayside High
  -
    name: Jack McDade
    school: Flatside High
```

Look at how pretty that data is.

```.language-php
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

### Mixing and Matching {#mixing-and-matching}

You can build multidimensional arrays full of associative arrays, and vice versa.

```.language-yaml
trips:
  vacation:
    - Miami
    - Malibu
  work:
    - Orlando
    - San Fransisco
```

### Comments {#comments}

You can comment out any line of YAML by prefixing it with a `#` hash symbol.

```.language-yaml
# title: I Quit My Day Job!
title: Another Monday
```

### Casting Data Types {#type-casting}

YAML autodetects the datatype of the entity. Sometimes you'll want to cast the datatype explicitly, like when a single word string that looks like a number or  boolean may need disambiguation by surrounding it with quotes or use of an explicit datatype tag.

```.language-yaml
a: 42                      # integer
b: "42"                    # string, disambiguated by quotes
c: 42.0                    # float
d: !!float 42              # float via explicit data type
e: !!str 42                # string, disambiguated by explicit type
f: !!str Yes               # string via explicit type
g: Yes                     # string
h: Yes we have No whiskey  # string, disambiguated by context.
```

## Conclusion {#conclusion}

So there you have it &mdash; YAML in its many shapes and forms. To learn how to render all this lovely data in a template, check out the [Antlers][antlers] section.

Happy YAMLing!

[recursive-acronym]: https://en.wikipedia.org/wiki/Recursive_acronym
[antlers]: /antlers

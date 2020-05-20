---
title: Modifiers
intro: Modifiers manipulate the data of your variables on the fly in Antlers templates. They can modify strings, filter arrays and lists, perform comparisons, handle basic math, simplify your markup, and even help you debug.
template: modifiers.index
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1568558617
blueprint: page
mount: modifiers
stage: 1
id: 9c1efbc5-c6a4-46f1-acce-d38b20122bd6
---
## Overview

Modifiers are available exclusively in [Antlers][antlers] templates. Each modifier is a function that accepts the value of the variable it's attached to, can do just about anything with that data, and then returns it. Multiple modifiers chained onto a variable will be executed in sequence, each passing its modified value onto the next.

## Example

You could take some text, render it as markdown, uppercase it, and ensure there are no widows (lines with only one word on them) like this:

```
// This...
{{ "Ruth, Ruth, Ruth! Baby Ruth!" | markdown | uppercase | widont }}

// Becomes this!
<p>RUTH, RUTH, RUTH! BABY&nbsp;RUTH!</p>
```

## Related Reading

Eager for more knowledge? Check out [Antler's modifier syntax](/antlers#modifying-data) and discover how to [build your own](#).

## Core Modifiers

[antlers]: /antlers

---
title: Modifiers
intro: Modifiers manipulate the data of your variables on the fly in Antlers templates. They can modify strings, filter arrays and lists, perform comparisons, handle basic math, simplify your markup, and even help you debug.
blueprint: page
mount: modifiers
id: 9c1efbc5-c6a4-46f1-acce-d38b20122bd6
---
## Overview

Modifiers are available exclusively in [Antlers][antlers] templates. Each modifier is a function that accepts the value of the variable it's attached to, can do just about anything with that data, and then returns it. Multiple modifiers chained onto a variable will be executed in sequence, each passing its modified value onto the next.

## Example

You could take some text, render it as markdown, uppercase it, and ensure there are no widows (lines with only one word on them) like this:

::tabs

::tab antlers
```antlers
// This...
{{ "Ruth, Ruth, Ruth! Baby Ruth!" | markdown | upper | widont }}

// Becomes this!
<p>RUTH, RUTH, RUTH! BABY&nbsp;RUTH!</p>
```
::tab blade
```blade
{!! Statamic::modify("Ruth, Ruth, Ruth! Baby Ruth!")->markdown()->upper()->widont() !!}

// Becomes this!
<p>RUTH, RUTH, RUTH! BABY&nbsp;RUTH!</p>
```
::

## Related reading

Eager for more knowledge? Check out [Antler's modifier syntax](/antlers#modifying-data) and discover how to [build your own](/extending/modifiers#creating-a-modifier).

## Core modifiers

You can find a [full list of modifiers](/reference/modifiers) included with Statamic in the reference section.

[antlers]: /antlers

---
id: 3d5efc5c-17b1-480b-bb77-53faf3d9552c
blueprint: page
title: 'Data Inheritance'
intro: 'Statamic sets data in a series of scopes that can inherit and override each other in order. We call this data inheritance model **The Cascade**.'
template: page
---
## Overview

Statamic provides a unique approach to data inheritance. The value of any given variable in your views can depend on the URL you're on. If a value of a variable doesn't exist on an entry URL, Statamic will check for a fallback value. If that fallback doesn't exist, it will fall back further, and so on. If it never finds anything, the value is `null`.

We call this fallback logic "the cascade", because the value of any given variable "cascades" down from the "top" until it finds where its defined.

This approach allows you to create views that are less repetitive and are easier to read because a "missing" variable will never throw an error, it will only ever be null.

:::tip
You can easily set variable fallbacks and "catch" the first value that exists without having to write a series of ugly `if/else` conditions.

::tabs

::tab antlers
```antlers
<h1>{{ nav_title ?? breadcrumb_title ?? title }}</h1>
```
::tab blade
```blade
<h1>{{ $nav_title ?? $breadcrumb_title ?? $title }}</h1>
```
::
:::



## Cascade Order

Here's the cascading order in which Statamic will look for the value of a given variable:

1. Are we inside a [partial](/tags/partial)? If so, has the variable been explicitly passed in?
2. If not, has it been set in a [ViewModel](/view-models)?
3. If not, has it been set on the [entry](/collections)?
4. If not, and this entry has been translated from another [origin](/multi-site), is it set on the origin entry?
5. If not, is it set on the collection via [inject](/collections#inject)?
6. If not, is it a [global variable](/globals)?
7. If not, is it a [system variable](/variables)?
8. Well okay then, `null` it is.

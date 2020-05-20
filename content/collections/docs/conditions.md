---
title: Conditions
template: page
stage: 2
id: 9751908a-a10c-4c36-abd3-2251e83fbc65
intro: Conditions allow you filter the results of your content tags (e.g. Collections, Taxonomies) using the data inside them, much like WHERE clauses do with SQL.
---
> Are you looking "if/else" conditions? You probably want this page: [Antler's Logic & Conditions](/antlers#conditional)

## Overview

Quite often you'll find that you don't want to fetch _all_ entries from a collection, or _all_ terms from a taxonomy. Conditions give the ability to fetch only the content that meets the criteria of your choosing.

For example, you may want to list all entries that _aren't_ the one you're viewing, are after your birthday 🎂 but before Christmas 🎄, or have a custom field like `pinned` 📌 set to `true`. Piece of cake. Piece of crumb cake. 🥮

_Note: These conditions currently apply to the [collections](/tags/collections), [taxonomy](/tags/taxonomy), and [users](/tags/users) tags._

## Syntax

The conditions syntax has 3 parts: the field name, the condition name, and the value.

<div class="font-mono bg-grey-300 text-purple rounded inline-block p-2 mb-6 text-sm">
<span class="bg-pink text-white px-1 rounded-sm">field_name</span>:<span class="bg-purple text-white px-1 rounded-sm">condition</span><span class="px-1">=</span>"<span class="bg-teal text-white px-1 rounded-sm">value</span>"
</div>

### Comparisons

For conditions where you're matching or comparing a value `is` or `starts_with`, you'd do:

```
{{ collection:blog title:starts_with="Once upon a time..." }}
```

### Boolean

For boolean conditions like `exists` or `null`, specify a value of `true`:

```
{{ collection:blog hero_image:exists="true" }}
```

For _negative_ boolean conditions, _don't_ use `="false"`. Instead, pick the inverse condition, like `:exists` instead of `:doesnt_exist`.

```
 // Nope
{{ collection:articles related_articles:exists="false" }}

// Yup
{{ collection:articles related_articles:doesnt_exist="true" }}
```

### Multiple Conditions

Need multiple conditions? Yeah, we support that.

```
{{ collection:drinks type:is="tiki" ingredients:in="Orgeat" }}
    <a href="{{ url }}">
        {{ title }}
    </a>
{{ /collection:drinks }}
```

## String Conditions

The following conditions apply to fields with data stored as strings.

| Condition | Description |
| :--- | :--- |
| `is` / `equals` | Check if field **is equal** to value. |
| `not` / `isnt` | Check if field is **not equal** to value. |
| `exists` / `isset` | Check if field **exists**. |
| `doesnt_exist` / `is_empty` / `null` | Check if field **doesn't exist**. |
| `contains` | Check if field **contains** value. |
| `doesnt_contain` | Check if field **doesn't contain** value. |
| `starts_with` | Check if field **starts with** value. |
| `doesnt_start_with` | Check if field **doesn't start** with value. |
| `ends_with` | Check if field **ends with** value. |
| `doesnt_end_with` | Check if field **doesn't end with** value. |
| `gt` | Check if field is **greater than** value. |
| `gte` | Check if field is **greater than or equal to** value. |
| `lt` | Check if field is **less than** value. |
| `lte` | Check if field is **less than or equal to** value. |
| `matches` / `regex` | Check if field **matches** regex. |
| `doesnt_match` | Check if field **doesn't match** regex. |
| `is_alpha` | Check if field contains **only alphabetical characters**. |
| `is_numeric` | Check if field contains **only numeric characters**. |
| `is_alpha_numeric` | Check if field contains **only alphanumeric characters**. |
| `is_url` | Check if field **is a valid URL**. |
| `is_embeddable` | Check if field **is an embeddable video URL**. |
| `is_email` | Check if field **is valid email address**. |
| `is_after` | Check if field **is after** date. |
| `is_before` | Check if field **is before** date. |
| `is_numberwang` | Check if field **is numberwang**. |

## Array/Object Conditions

The following conditions apply to fields with data stored as arrays or objects.

| Condition | Description |
| :--- | :--- |
| `in` | Check if an array field **has** value. |
| `not_in` | Check if an array field **does not have** value. |

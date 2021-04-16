---
title: Conditions
template: page
stage: 2
id: 9751908a-a10c-4c36-abd3-2251e83fbc65
intro: Conditions allow you to filter the results of your content tags (e.g. Collections, Taxonomies) using the data inside them, much like WHERE clauses do with SQL.
---
> Are you looking "if/else" conditions? You probably want this page: [Antler's Logic & Conditions](/antlers#conditions)

## Overview

Quite often you'll find that you don't want to fetch _all_ entries from a collection, or _all_ terms from a taxonomy. Conditions give the ability to fetch only the content that meets the criteria of your choosing.

For example, you may want to list all entries that _aren't_ the one you're viewing, are after your birthday 🎂 but before Christmas 🎄, or have a custom field like `pinned` 📌 set to `true`. Piece of cake. Piece of crumb cake. 🥮

_Note: These conditions currently apply to the [collections](/tags/collection), [taxonomy](/tags/taxonomy), and [users](/tags/users) tags._

## Syntax

The conditions syntax has 3 parts: the field name, the condition name, and the value.

<div class="font-mono bg-grey-300 text-purple rounded inline-block p-2 mb-6 text-sm">
<span class="bg-pink text-white p-1 rounded-sm">{field_name}</span>:<span class="bg-purple text-white p-1 rounded-sm">{condition}</span><span class="p-1">=</span>"<span class="bg-teal text-white p-1 rounded-sm">{value}</span>"
</div>

### Using a variable reference
If you prefix the field name with a colon, it will use the value of a variable in your view

```
:author:is="author"
```


### Multiple values
You can pass multiple values by separating them with a pipe.

```
taxonomy:category="happy|radical"
```

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

### Passing multiple values

## String Conditions

The following conditions apply to fields with data stored as strings.

| Condition | Description |
| :--- | :--- |
| `is` / `equals` | Include if field **is equal** to value. |
| `not` / `isnt` | Include if field is **not equal** to value. |
| `exists` / `isset` | Include if field **exists**. |
| `doesnt_exist` / `is_empty` / `null` | Include if field **doesn't exist**. |
| `contains` | Include if field **contains** value. |
| `doesnt_contain` | Include if field **doesn't contain** value. |
| `in` | Include if field value is **in** the provided array. |
| `not_in` | Include if field value is **not_in** the provided array. |
| `starts_with` | Include if field **starts with** value. |
| `doesnt_start_with` | Include if field **doesn't start** with value. |
| `ends_with` | Include if field **ends with** value. |
| `doesnt_end_with` | Include if field **doesn't end with** value. |
| `gt` | Include if field is **greater than** value. |
| `gte` | Include if field is **greater than or equal to** value. |
| `lt` | Include if field is **less than** value. |
| `lte` | Include if field is **less than or equal to** value. |
| `matches` / `regex` | Include if field **matches** case insensitive regex. |
| `doesnt_match` | Include if field **doesn't match** case insensitive regex. |
| `is_alpha` | Include if field contains **only alphabetical characters**. |
| `is_numeric` | Include if field contains **only numeric characters**. |
| `is_alpha_numeric` | Include if field contains **only alphanumeric characters**. |
| `is_url` | Include if field **is a valid URL**. |
| `is_embeddable` | Include if field **is an embeddable video URL**. |
| `is_email` | Include if field **is valid email address**. |
| `is_after` | Include if field **is after** date. |
| `is_before` | Include if field **is before** date. |
| `is_numberwang` | Include if field **is numberwang**. |

## Taxonomy Conditions

[Taxonomy](/taxonomies) conditions are a little bit different. They start with `taxonomy:`, followed by the taxonomy name, and finally the term you're seeking.

<div class="font-mono bg-grey-300 text-purple rounded inline-block p-2 mb-6 text-sm">
<span class="bg-pink text-white p-1 rounded-sm">taxonomy</span>:<span class="bg-purple text-white p-1 rounded-sm">{taxonomy_name}</span><span class="p-1">=</span>"<span class="bg-teal text-white p-1 rounded-sm">{term}</span>"
</div>

| Condition | Description |
| :--- | :--- |
| `{term}` | Include if entry **has** a specific term. |

## Snippets

Here are some common and useful conditions snippets to grab on your next project.

### Exclude the current entry

```
:id:not="id"
```

### Entries with specific "tags"

Assuming you have a taxonomy named "Tags"...
```
taxonomy:tags="review|colorful"
```

### Show draft (unpublished) entries

```
status:is="draft"
```


### Published before a specific date

Let's use Y2K as the example date.

```
date:is_before="2000-01-01"
```

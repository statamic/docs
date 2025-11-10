---
id: 9751908a-a10c-4c36-abd3-2251e83fbc65
blueprint: page
title: 'Tag Conditions'
template: page
intro: 'Conditions allow you to filter the results of your content tags (e.g. Collections, Taxonomies) using the data inside them, much like WHERE clauses do with SQL.'
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1632512130
---
:::tip
Are you looking for "if/else" conditions? You probably want this page: [Antler's Logic & Conditions](/antlers#conditions)
:::

## Overview

Quite often you'll find that you don't want to fetch _all_ entries from a collection, or _all_ terms from a taxonomy. Conditions give the ability to fetch only the content that meets the criteria of your choosing.

For example, you may want to list all entries that _aren't_ the one you're viewing, are after your birthday 🎂 but before Christmas 🎄, or have a custom field like `pinned` 📌 set to `true`. Piece of cake. Piece of crumb cake. 🥮

_Note: These conditions currently apply to the [collections](/tags/collection), [taxonomy](/tags/taxonomy), and [users](/tags/users) tags._

## Syntax

The conditions syntax has 3 parts: the field name, the condition name, and the value.

<div class="c-syntax-explainer">
<span class="c-syntax-explainer__1">{field_name}</span>:<span class="c-syntax-explainer__2">{condition}</span><span>=</span>"<span class="c-syntax-explainer__3">{value}</span>"
</div>

### Field name
The field name is the name of the field you're filtering on.



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

::tabs

::tab antlers
```antlers
{{ collection:blog title:starts_with="Once upon a time..." }}
```
::tab blade
```blade
<s:collection:blog
  title:starts_with="Once upon a time..."
>

</s:collection:blog>
```
::

### Boolean

For boolean conditions like `exists` or `null`, specify a value of `true`:

::tabs

::tab antlers
```antlers
{{ collection:blog hero_image:exists="true" }}
```
::tab blade
```blade
<s:collection:blog
  hero_image:exists="true"
>

</s:collection:blog>
```
::

For _negative_ boolean conditions, _don't_ use `="false"`. Instead, pick the inverse condition, like `:exists` instead of `:doesnt_exist`.

::tabs
::tab antlers
```antlers
 // Nope
{{ collection:articles related_articles:exists="false" }}

// Yup
{{ collection:articles related_articles:doesnt_exist="true" }}
```
::tab blade
```blade
// Nope
<s:collection:articles
  related_articles:exists="false"
>
</s:collection:articles>

// Yup
<s:collection:articles
  related_articles:doesnt_exist="true"
>
</s:collection:articles>
```
::

### Multiple Conditions

Need multiple conditions? Yeah, we support that.

::tabs

::tab antlers
```antlers
{{ collection:drinks type:is="tiki" ingredients:in="Orgeat" }}
    <a href="{{ url }}">
        {{ title }}
    </a>
{{ /collection:drinks }}
```
::tab blade
```blade
<s:collection:drinks
  type:is="tiki"
  ingredients:in="Orgeat"
>
  <a href="{{ $url }}">
    {{ $title }}
  </a>
<s:/collection:drinks>
```
::

### Passing multiple values

To pass multiple _values_ in a condition, separate them with `|` pipes.

::tabs

::tab antlers
```antlers
{{ collection:drinks ingredients:in="rum|falernum" }}
    <a href="{{ url }}">
        {{ title }}
    </a>
{{ /collection:drinks }}
```
::tab blade
```blade
<s:collection:drinks
  ingredients:in="rum|falernum"
>
  <a href="{{ $url }}">
    {{ $title }}
  </a>
</s:collection:drinks>
```
::

### Sub fields

You can apply conditions to "sub fields", like date ranges:

```yaml
event_date:
  start: 2023-12-01
  end: 2023-12-03
```

::tabs

::tab antlers
```antlers
{{ collection:events :event_date.start="today" }}
{{ collection:events :event_date.end="today" }}
```
::tab blade
```blade
<s:collection:events
  :event_date.start="$today"
>
</s:collection:events>

<s:collection:events
  :event_date.end="$today"
>
</s:collection:events>
```
::

## String conditions

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
| `not_in` | Include if field value is **not in** the provided array. |
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

## Array conditions

The following conditions apply to fields with data stored as an array.

| Condition | Description |
| :--- | :--- |
| `overlaps` | Include if any field value **matches** the provided array (has). |
| `doesnt_overlap` | Include if **no** value **matches** the provided array (has not). |

## Taxonomy conditions

[Taxonomy](/taxonomies) conditions are a little bit different. They start with `taxonomy:`, followed by the taxonomy name, an optional modifier argument, and finally the term you're seeking.

<div class="font-mono bg-grey-300 text-purple rounded inline-block p-2 mb-6 text-sm"><span class="bg-pink text-white p-1 rounded-sm">taxonomy</span>:<span class="bg-purple text-white p-1 rounded-sm">{handle}</span>:<span class="bg-black text-white p-1 rounded-sm">{modifier}</span><span class="p-1">=</span>"<span class="bg-teal text-white p-1 rounded-sm">{term}</span>"
</div>

### Query modifiers {#taxonomy-query-modifiers}

You may optionally control the behavior of the condition filter by passing the desired modifier into the tag method call. If you don't set a modifier, it will use `any` by default.

#### Any (default) {#taxonomy-any}

Fetch all entries that have _any_ of one or more taxonomy terms.

#### Not {#taxonomy-not}

Fetch all entries that _don't_ have one or more taxonomy terms.

#### All {#taxonomy-all}

Fetch all entries that contain _each_ of one or more taxonomy terms.

### Examples {#taxonomy-examples}

::tabs

::tab antlers
```antlers
<!-- Get all featured articles -->
{{ collection:articles taxonomy:tags:any="featured" }}
{{ collection:articles taxonomy:tags="featured" }} (shorthand)

<!-- Get all but sports-related articles -->
{{ collection:articles taxonomy:tags:not="sports" }}

<!-- Get all "featured" articles about gaming -->
{{ collection:articles taxonomy:tags:all="gaming|featured" }}
```
::tab blade
```blade
<!-- Get all featured articles -->
<s:collection:articles taxonomy:tags:any="featured">
</s:collection:articles>

<s:collection:articles taxonomy:tags="featured"> (shorthand)
</s:collection:articles>


<!-- Get all but sports-related articles -->
<s:collection:articles taxonomy:tags:not="sports">
</s:collection:articles>


<!-- Get all "featured" articles about gaming -->
<s:collection:articles taxonomy:tags:all="gaming|featured">
</s:collection:articles>

```
::

## Arguments

| Argument | Description |
| :--- | :--- |
| `{handle}` | Handle of the Taxonomy you wish to query. |
| `{modifier}` | Control the behavior of the condition filtering. Available options: `all`, `not`, and `any`. Default: `any`.  |
| `{term}` | Term(s) to query. You may pass multiple terms by separating them with `\|` pipe delimiters. |

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

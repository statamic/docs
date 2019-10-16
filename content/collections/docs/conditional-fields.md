---
title: 'Conditional Fields'
intro: Conditional fields are used to show and hide fields in your publish forms based on conditions and triggers. For example, you may only want to show a caption field if an asset field has an image selected, or a whole block of fields if a toggle switch is enabled.
template: page
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1568645321
id: dd52c1f6-661b-4408-83c6-691fa341aaa7
blueprint: page
stage: 1
---
## Overview

Field conditions are set on individual field settings in [blueprints](/blueprints). For example, you could create a `meta_description` field that is only shown when the `content` field is longer than 140 characters.

<figure>
    <img src="/img/field-conditions.png" alt="Statamic conditional field rule builder">
    <figcaption>The conditional field rule builder</figcaption>
</figure>

You may specify various rules for showing a field under either the `if` / `show_when` keys, or hiding a field under the `unless` / `hide_when` keys.

## Boolean

A simple example might be to show a field when a toggle is set to 'on':

```yaml
-
  handle: has_author
  field:
    type: toggle
-
  handle: author
  field:
    type: text
    if:
      has_author: true
```

## Empty

If you need to show a field based on whether another field is empty or not, you can use `empty` or `not empty`:

```yaml
-
  handle: favorite_food
  field:
    type: text
-
  handle: second_favorite_food
  field:
    type: text
    if:
      favorite_food: not empty
```

## Equality Comparison

Maybe you might wish to show various fields based on the value of a select field:

```yaml
-
  handle: post_type
  field:
    type: select
    options:
      - text
      - video
-
  handle: content
  field:
    type: text
    if:
      post_type: text
-
  handle: youtube_id
  field:
    type: text
    if:
      post_type: video
```

## Advanced Comparison

For more advanced comparisons, several operators and right-hand-side literals/options are available to you.  For example, we could show an `email` field if age is greater than or equal to `16`:

```yaml
-
  handle: age
  field:
    type: text
-
  handle: email
  field:
    type: text
    if:
      age: '>= 16'
```

Available operators include:

| Operator | Description |
| :--- | :--- |
| `is` `equals` `==` | Loose equality comparison (inferred if no operator is used). |
| `not` `isnt` `!=` | Loose inequality comparison. |
| `===` | Strict equality comparison. |
| `!==` | Strict inequality comparison. |
| `>` | Greater than comparison. |
| `>=` | Greater than or equal to comparison. |
| `<` | Less than comparison. |
| `<=` | Less than or equal to comparison. |
| `contains` `includes` | Check if array contains a value, or if a string contains a sub-string. |

Available right-hand-side literals/options include:

| Literal / Option | Description |
| :--- | :--- |
| `null` | Will be evaluated as a literal `null`. |
| `true` | Will be evaluated as a literal `true`. |
| `false` | Will be evaluated as a literal `false`. |
| `empty` | Will intelligently check if value is empty. |

## Multiple Field

If you define multiple field conditions, all conditions need to pass for the field to be shown (or hidden if you use the `unless` / `hide_when` parent key).  For example, the following will show the field when `this_field` is `bacon` *__AND__* `that_field` is `cheeseburger`:

```yaml
if:
  this_field: bacon
  that_field: cheeseburger
```

If you want to show a field when _any_ of the conditions pass, you can append `_any` onto the parent key.  For example, the following will show the field when `this_field` is `bacon` *__OR__* `that_field` is `cheeseburger`:

```yaml
if_any:
  this_field: bacon
  that_field: cheeseburger
```

## Nested Field

You may use dot notation to access nested values when necessary.  For example, maybe you would like to show a field when an `array` fieldtype's `country` value is `Canada`:

```yaml
if:
  address.country: Canada
```

## Field Context

By default, conditions are performed against values in current level of `fields` in your blueprint.  If you need access to values outside of this context (eg. if you are in a replicator, trying to compare against fields outside of the replicator), you can access root VueX store values by prepending your field with `root`:

```yaml
if:
  root.favorite_foods: includes bacon
```

## Custom Logic

If you need something more complex than the YAML syntax provides, you may write your own logic.  In a JS script or addon, you can define custom functions using the `$conditions` JS API:

```javascript
Statamic.$conditions.add('reallyLovesFood', function (values) {
    return values.favorite_foods.length > 10;
});
```

Furthermore, if you need access to values outside of the current `fields` context (see [field context](#field-context)), we also provide a `root` values parameter, as well as an `extra` object parameter with additional access to the VueX store (via `extra.store` and `extra.storeName`):

```javascript
Statamic.$conditions.add('reallyLovesFood', function (values, root, extra) {
    return root.favorite_foods.length > 10;
});
```

Then reference the name in the YAML:

``` yaml
if: reallyLovesFood
```
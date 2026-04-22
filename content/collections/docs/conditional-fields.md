---
title: 'Conditional Fields'
intro: Show and hide fields in your publish forms based on conditions and triggers. For example, you may only want to show a caption field if an asset field has an image selected, or a whole block of fields if a toggle switch is enabled.
template: page
id: dd52c1f6-661b-4408-83c6-691fa341aaa7
blueprint: page
related_entries:
  - aa96fcf1-510c-404b-9b63-cea8942e1bf8
  - 54548616-fd6d-44a3-a379-bdf71c492c63
---
## Overview

Field conditions are set on individual field settings in [blueprints](/blueprints). For example, you could create a `meta_description` field that is only shown and submitted when the `content` field is longer than 140 characters.

<figure>
    <img src="/img/field-conditions.png" alt="Statamic conditional field rule builder">
    <figcaption>The conditional field rule builder</figcaption>
</figure>

You may specify various rules for showing a field under either the `if` / `show_when` keys, or hiding a field under the `unless` / `hide_when` keys.

### Data flow

Only visible fields are submitted with your form data. This allows you to control data flow, and [conditionally apply validation](#validation) to visible fields when needed.

If you require conditionally hidden fields to be saved with your data, you may use the `always_save` config option (read more about [field data flow](/fields#field-data-flow)).

:::tip
If you want to cosmetically hide a larger set of fields to get them out of the user's way, you can use the [Revealer](/fieldtypes/revealer) fieldtype to hide them until the user needs them without disrupting data flow on form submission.
:::

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

## Equality

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

## Contains

If you are dealing with an array of options, you can conditionally show fields when an array contains specific value(s) using `contains` or `contains_any`:

```yaml
-
  handle: favorite_foods
  field:
    type: checkboxes
    options:
      - pizza
      - lasagna
      - oatmeal
-
  handle: favorite_topping
  field:
    type: text
    if:
      favorite_foods: 'contains pizza'
-
  handle: favorite_italian_singer
  field:
    type: text
    if:
      favorite_foods: 'contains_any pizza, lasagna'
```

If you are dealing with a string value, `contains` and `contains_any` will perform sub-string checks instead:

```yaml
-
  handle: favorite_food
  field:
    type: text
-
  handle: favorite_topping
  field:
    type: text
    if:
      favorite_food: 'contains pizza'
-
  handle: favorite_italian_singer
  field:
    type: text
    if:
      favorite_food: 'contains_any pizza, lasagna'
```

### Taxonomy Terms

When you want to compare against a taxonomy term, the `contains` term needs to include the taxonomy handle, like `taxonomy::slug`:

```yaml
-
  handle: favorite_food
  field:
    type: text
-
  handle: food_groups
  field:
    type: terms
    taxonomies:
      - food_groups
    display: Food Groups
    mode: select
-
  handle: favorite_vegetables
  field:
    type: text
    if:
      favorite_food: 'contains food_group::vegetables'
```

## Advanced comparisons

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
| `contains` `includes` | Check if array contains a value, or if a string contains a sub-string value. |
| `contains_any` | Check if any of a comma-separated list of values is contained in an array or string (also matches sub-strings). |
| `includes_any` | Check if any of a comma-separated list of values is included in an array or matches a string exactly. |

Available right-hand-side literals/options include:

| Literal / Option | Description |
| :--- | :--- |
| `empty` | Will intelligently check if value is empty (ie. `null`, `''`, `[]`, or `{}`). |
| `null` | Will be evaluated as a **literal** `null`. |
| `true` | Will be evaluated as a **literal** `true`. |
| `false` | Will be evaluated as a **literal** `false`. |

## Multiple conditions

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

## Nested fields

You may use dot notation to access nested values when necessary.  For example, maybe you would like to show a field when an `array` fieldtype's `country` value is `Canada`:

```yaml
if:
  address.country: Canada
```

## Field context

By default, conditions are performed against values in the current level of `fields` in your blueprint.  If you need access to values outside of this context (eg. if you are in a replicator, trying to compare against fields outside of the replicator), you can access parent field values by prepending your field with `$parent`:

```yaml
if:
  $parent.favorite_foods: includes bacon
```

You can also access values at the top-level of your blueprint with `$root`:

```yaml
if:
  $root.favorite_foods: includes bacon
```

## Custom logic

If you need something more complex than the YAML syntax provides, you may write your own logic.  In a [JS script](/extending/control-panel) or addon, you can define custom functions using the `$conditions` JS API:

```yaml
if:
  quote: custom isCanadian
```

```javascript
Statamic.$conditions.add('isCanadian', ({ target }) => {
    return new RegExp('eh|bud|hoser').test(target);
});
```

:::warning
It's worth noting that custom conditions only work in the Control Panel, not in the context of frontend forms.
:::

### Parameters

You may also pass parameters to your custom functions:

```yaml
if:
  hero_video_url: 'custom isFiletype:mp4'
  hero_image_url: 'custom isFiletype:jpg,png'
```

```javascript
Statamic.$conditions.add('isFiletype', ({ target, params }) => {
    return new RegExp(params.join('|') + '$').test(target);
});
```

### Without Target

If you need to perform a condition against multiple hardcoded values, you can bypass setting a target field in the yaml by referencing your function name at the top of your `if` condition:

```yaml
if: reallyLovesFood
```

```javascript
Statamic.$conditions.add('reallyLovesFood', ({ values }) => {
    return (values.meals.length + values.desserts.length) > 10;
});

```

### Field context

Furthermore, if you need access to values outside of the current [field context](#field-context), we also provide a `root` values parameter, as well as access to the VueX store via `store` and `storeName`:

```javascript
Statamic.$conditions.add('...', ({ root, store, storeName }) => {
    //
});
```

## Validation

If you wish to conditionally apply validation to conditionally shown fields, we recommend using the `sometimes` [Laravel validation rule](https://laravel.com/docs/validation#validating-when-present).

```yaml
-
  handle: online_event
  field:
    type: toggle
-
  handle: venue
  field:
    type: text
    if:
      online_event: false
    validate:
      - sometimes
      - required
```

The above example will only _sometimes_ apply the `required` rule to the `venue` field; Only when it exists in the submitted form data (see notes on [data flow](#data-flow) above).

:::tip
For more advanced conditional validation, take a look at Laravel's `required_if`, `required_with`, etc. [validation rules](https://laravel.com/docs/validation#rule-required-if).
:::

## Templating

You can take advantage of Conditional Fields on your front-end Forms to automatically generate dynamic forms and logic. [Learn more about it](/tags/form-create#conditional-fields).

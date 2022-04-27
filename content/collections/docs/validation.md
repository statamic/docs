---
id: 268d444c-88e3-4b52-bfc6-165749ef3ec1
blueprint: page
title: Validation
intro: 'Statamic allows you to validate your data using Laravel''s validation system.'
template: page
---

## Overview

While configuring a [blueprint or fieldset field](/blueprints), switch to the **Validation** tab where you can choose from [any built in Laravel rule][laravel-validation].

<div class="screenshot">
    <img src="/img/field-validation.png" width="521" alt="Field validation"/>
    <div class="caption">Add validation rules (with a shortcut for requiring)</div>
</div>

In this screenshot, you can see that the field has an `alpha_dash` and `min:4` rule which means you can only type letters and dashes, like a slug, and that it
must be at least 4 characters. You have plenty of options to be creative and confident that your data will be entered the way you need it to be.

Here's a peek at how that YAML is structured.

```yaml
-
  handle: your_field
  field:
    type: text
    validate:
      - alpha_dash
      - 'min:4'
```

:::tip
If you're interested in customizing user password validation, you can read about that [here](/users#password-validation).
:::


## Required Fields

Being the most common type of validation rule, we give you a shortcut for that. Simply toggle it on, or add `required: true` to the YAML.


## Validating Nestable Fields

Statamic's [Grid](/fieldtypes/grid), [Replicator](/fieldtypes/replicator), and [Bard](/fieldtypes/bard) fields can all contain sub-fields.

You can add validation to those sub-fields as you would with any top level fields.

However, if you want to use validation rules that target other fields, and the target field is in the same context (e.g. in the same Grid row, or same Replicator set), you may use the `{this}` placeholder. The path to the nested field will be expanded by Statamic for you.

```yaml
-
  handle: variations
  field:
    type: grid
    fields:
      -
        handle: purchasable
        type: toggle
      -
        handle: price
        type: integer
        validate: 'required_with:{this}.purchasable'
```

This would make sure that the `price` field is only required if the `purchasable` toggle is true within that same set. Without `{this}`, it would be checking for a `purchasable` field at the top level of your form.

:::best-practice
Rather than reaching for `{this}`, you can consider using conditional fields along with the `sometimes|required` rules.

```yaml
    fields:
      -
        handle: purchasable
        type: toggle
      -
        handle: price
        type: integer
        if:
          purchasable: true
        validate:
          - sometimes
          - required
```
:::


## Available Rules

### All Laravel Rules

You may use any validation rule provided by Laravel. You can view the complete list [on their documentation][laravel-validation].

### Unique Entry Value

```yaml
-
  handle: highlander
  field:
    type: text
    validate: 'unique_entry_value:{collection},{id},{site}'
```

This works like Laravel's `unique` validation rule, but for Statamic entries. The rule should be used verbatim as shown above. Statamic will replace the `collection`, `id`, and `site` behind the scenes.

You can then customize the error message right in your `resources/lang/{lang}/validation.php` file, like so

```php
'custom' => [
    'highlander' => [
        'unique_entry_value' => 'There can be only one!',
    ]
],
```

### Unique Term Value

```yaml
-
  handle: foo
  field:
    type: text
    validate: 'unique_term_value:{taxonomy},{id},{site}'
```

This works like the `unique_entry_value` rule, but for taxonomy terms.

### Unique User Value

```yaml
-
  handle: login
  field:
    type: text
    validate: 'unique_user_value:{id}'
```

This works like the `unique_entry_value` rule, but for users.




[laravel-validation]: https://laravel.com/docs/8.x/validation#available-validation-rules

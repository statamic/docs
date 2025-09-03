---
id: 9a1d8b88-c600-46f2-8727-1deb56f2e87a
blueprint: page
title: 'Fieldtypes Overview'
intro: 'Fieldtypes are customizable form [fields](/fields) used to structure your content and provide an intuitive content management experience. Each fieldtype has its own UI, data format, and configuration options.'
template: page
options_content: 'Each fieldtype has a common set of options in addition to any unique ones specific to that type.'
options:
  -
    name: display
    type: text
    description: "The field's label shown in the Control Panel."
    required: false
  -
    name: handle
    type: text
    description: "The field's template variable. Avoid using [reserved words](/tips/reserved-words#as-field-names) as handles."
    required: true
  -
    name: instructions
    type: text
    description: 'Provide additional field instructions like this text. Markdown formatting is supported.'
    required: false
  -
    name: instructions_position
    type: text
    description: 'Where the instructions should be positioned relative to the field. Options: `above` or `below`.'
    required: false
  -
    name: variant
    type: text
    description: 'Show the field under its label or beside it. Options: `block` (Stacked), `inline` (Side by Side). Default: `block`.'
    required: false
  -
    name: listable
    type: mixed
    description: 'Controls whether the field should be shown in Control Panel listings. Options: `hidden`, `true`, or `false`. Default: `hidden`.'
    required: false
  -
    name: visibility
    type: mixed
    description: 'Controls whether the field should be shown in Control Panel publish forms. Options: `visible`, `read_only`, [`computed`](/computed-values) or `hidden`. Default: `visible`.'
    required: false
  -
    name: sortable
    type: toggle
    description: 'Control if the field should be sortable in listing views.'
    required: false
  -
    name: replicator_preview
    type: toggle
    description: 'Control preview visibility in Replicator/Bard sets.'
    required: false
  -
    name: duplicate
    type: toggle
    description: 'Control if the field should be included when duplicating the item.'
    required: false
  -
    name: actions
    type: toggle
    description: 'Show or hide field action controls, such as fullscreen mode.'
    required: false
  -
    name: conditions
    type: mixed
    description: 'Configure rules that control whether the field should be shown or hidden. Learn more about [conditional fields](/conditional-fields).'
    required: false
  -
    name: required
    type: boolean
    description: 'Control whether or not this field is required.'
    required: false
  -
    name: validate
    type: array
    description: 'Configure rules that validate the value of this field before allowing the user to save. Learn more about [validation](/blueprints#validation).'
    required: false
related_entries:
  - 9a1d8b88-c600-46f2-8727-1deb56f2e87a
  - 54548616-fd6d-44a3-a379-bdf71c492c63
  - 2940c834-7062-47a1-957c-88a69e790cbb
  - dd52c1f6-661b-4408-83c6-691fa341aaa7
  - dcf80ee6-209e-45aa-af42-46bbe01996e2
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1632748812
nav_title: Overview
---
## Overview

Fieldtypes are essentially different types of form inputs you can choose from when building a [blueprint](/blueprints). They range from simple text fields and select boxes, to more complex WYSIWYG-style editors like Bard.

:::watch https://www.youtube.com/embed/cs_jL6fCaA8
Watch how to add fields to a blueprint.
:::

## List of Fieldtypes

Check out the full list of [all fieldtypes](/reference/fieldtypes) in our reference section.

## Data Format

Fieldtypes are [augmented](/augmentation) to alter the output of your saved content according to how the field is expected to be used.

For example, a [markdown field](/fieldtypes/markdown) will automatically convert your plain text input into HTML according to your markdown options of choice. Given the very same input in a [textarea field](/fieldtypes/textarea), what you enter is what you return because that fieldtype doesn't alter the content. The documentation for each fieldtype will detail if any augmentation happens.

These same rules apply whether you're using [Antlers](/antlers), [Blade](/blade), [GraphQL](/graphql), or the [REST API](/rest-api).

:::tip
You can retrieve the original, un-augmented data by using the [raw modifier](/modifiers/raw), like so:

```
{{ markdown_field | raw }}
```
:::
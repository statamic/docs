---
title: Fieldtypes
intro: Fieldtypes are customizable form [fields](/fields) used to structure your content and provide an intuitive content management experience. Each fieldtype has its own UI, data format, and configuration options.
template: page
id: 9a1d8b88-c600-46f2-8727-1deb56f2e87a
blueprint: page
options_content: Each fieldtype has a common set of options in addition to any unique ones specific to that type.
options:
  -
    name: display
    type: text
    description: >
      The label shown above the field.
  -
    name: handle
    type: text
    description: >
      The field's template variable.
  -
    name: instructions
    type: text
    description: >
      Help text shown along with the field.
  -
    name: instructions_position
    type: text
    description: >
      Where the instructions should be positioned relative to the field.
      Options: `Above` or `Below`.
  -
    name: listable
    type: text
    description: >
      Controls whether the field should be shown in control panel listings.
      Options: `hidden`, `visible`, or `listable`.
  -
    name: conditions
    type: mixed
    description: >
      Configure rules that control whether the field should be shown or hidden. Learn more about [conditional fields](/conditional-fields).
  -
    name: required
    type: boolean
    description: >
      Control whether or not this field is required.
  -
    name: validation
    type: boolean
    description: >
      Configure rules that validate the value of this field before allowing the user to save. Learn more about [validation](/blueprints#validation).
---
## Overview

Fieldtypes are essentially different types of form inputs you can choose from when building a [blueprint](/blueprints). They range from simple text text fields and select boxes, to more complex WYSIWYG-style editors like Bard.

:::watch https://www.youtube.com/embed/cs_jL6fCaA8
Watch how to add fields to a blueprint.
:::

## List of Fieldtypes

Check out the full list of [all fieldtypes](/reference/fieldtypes) in our reference section.

## Data Format

Fieldtypes are [augmented](/augmentation) to alter the output of your saved content according to how the field is expected to be used.

For example, a [markdown field](/fieldtypes/markdown) will automatically convert your plain text input into HTML according to your markdown options of choice. Given the very same input in a [textarea field](/fieldtypes/textarea), what you enter is what you return because that fieldtype doesn't alter the content. The documentation for each fieldtype will detail if any augmentation happens.

These same rules apply whether you're using [Antlers](/antlers), [Blade](/blade), [GraphQL](/graphql), or the [REST API](/rest-api).

You can always retrieve the original, unaugmented data by using the [raw modifier](/modifiers/raw), like so:

```
{{ markdown_field | raw }}
```

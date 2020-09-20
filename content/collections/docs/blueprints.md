---
title: Blueprints
intro: Blueprints are a key component of the [content modeling](/content-modeling) process. Inside a blueprint you define your fields, which field types they'll implement, group them into sections if you desire, and define conditions controlling their visibility. The control panel uses blueprints to render publish forms so you can manage content.
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1568645146
id: 54548616-fd6d-44a3-a379-bdf71c492c63
blueprint: page
stage: 1
---
## Overview

Think of blueprints as stencils for your content. They control what [fields](/fields) users get to work with when publishing content, as well as the schema of the data developers will be tapping into to build the [front-end](/front-end) of your site.

Each blueprint belongs to an item:

- You can define multiple Blueprints for collections, and each entry will have the opportunity to choose from one of them.
- Same goes for taxonomies and their terms.
- Global sets, Asset containers, and Forms each get their own Blueprint.
- Users all share a Blueprint.

<figure>
    <img src="/img/blueprints.png" alt="The Statamic 3 blueprint configuration screen">
    <figcaption>A glimpse at configuring a blueprint.</figcaption>
</figure>

## Creating Blueprints

There are 3 ways to create blueprints:

- In the respective areas of the control panel. For instance, the collections area will let you define its blueprints.
  The forms area will let you define its blueprints, and so on.
- In the **Blueprints** area of the control panel. This page serves as a hub to jump over to managing blueprints in various areas.
- Creating a YAML file in the appropriate place within `resources/blueprints/`. More on that in a moment.

Once created, you can begin to define fields and the sections that hold them. If you have more than one section, each becomes a tab in the publish form.

## Directory Structure

Whether you manually create your blueprint's YAML file, or use the control panel, they will all end up as YAML files in the `resources/blueprints` directory.

``` files
resources/
`-- blueprints/
    |-- collections/
    |   `-- blog/
    |       |-- basic_post.yaml
    |       `-- art_directed_post.yaml
    |-- taxonomies/
    |   `-- tags/
    |       `-- tag.yaml
    |-- globals/
    |   |-- global.yaml
    |   `-- company.yaml
    |-- assets/
    |   `-- main.yaml
    |-- forms/
    |   `-- contact.yaml
    `-- user.yaml
```

Collections and Taxonomies have their available blueprints organized in subdirectories named after their collections.
When you create an entry or term, you will be able to choose which blueprint to use (if there are multiple).

Globals, Asset Containers, and Forms can only have one blueprint per item, so they are organized into their own subdirectories, where each YAML file is the handle of the item.

All users will share the same blueprint, and it hangs out in the root of the directory.

## Conditional Fields

It’s possible to have fields be displayed only under certain conditions. For example, you may only want to show a caption field if an asset field has an image selected, or a whole block of fields if a toggle switch is enabled.

<figure>
    <img src="/img/field-conditions.png" alt="Statamic conditional field rule builder">
    <figcaption>The conditional field rule builder</figcaption>
</figure>

To learn what's possible and how implement the various rules, head over to the article on [conditional fields](/conditional-fields).

## YAML Structure

At its most basic, a blueprint has an array of sections.

``` yaml
sections: []
```

A section has a handle, a display name, and an array of fields:

``` yaml
sections:
  main:
    display: Main
    fields:
      -
        handle: content
        type: markdown
  meta:
    display: SEO Metadata
    fields:
      -
        handle: meta_title
        type: text
      -
        handle: meta_description
        type: textarea
```

> Blueprint fields are **sequence indexed** instead of keyed by handle. This format allows maximum flexibility: you can reference fields from other blueprints one or more times, override their settings inline, and even reference existing fields for [Bard](/fieldtypes/bard), [Replicator](/fieldtypes/replicator), and [Grid](/fieldtypes/grid) sets.

## Reusable Fields

A section's fields can be comprised of references to fields in fieldsets (so you can reuse fields) or inline field definitions.

### Field References

You will likely want to pre-configure reusable fields to pull into your blueprints.

For example, you might have a rich text field configured with all your favorite buttons, which you've called `content` and stored in the `common` fieldset.

You can pull it into your blueprint like so:

``` yaml
fields:
  -
    handle: my_content_field
    field: common.content
  -
    handle: another_content_field
    field: common.content
```

This way, you are free to reuse the same field as many times as you like. Update the field in the fieldset and it will be reflected across all your blueprints.

### Customizing Fields

You may customize a referenced field by adding a `config` array. Any keys found in this will _override_ whatever was defined in your fieldset.

``` yaml
fields:
  -
    handle: my_content_field
    field: common.content
    config:
      display: My Content Field
      validate: required|max:200
```

Here, the `display` and `validate` would replace whatever was defined in the fieldset.

**Note:** This only applies to referenced fields. For inline fields, you can just set everything right there.

### Importing Fieldsets

Fieldsets still exist in Statamic 3! They serve to create reusable sets of fields, just like v2. You may import an entire fieldset at any point by using the `import` key, for example:

``` yaml
# blueprint

fields:
  -
    import: survey
    prefix: favorite_
  -
    import: survey
    prefix: least_favorite_
```

``` yaml
# the survey.yaml fieldset

fields:
  -
    handle: food
    type: text
  -
    handle: food_reason
    type: textarea
```

Doing the above would result in a blueprint like this:

``` yaml
fields:
  -
    handle: favorite_food
    field:
      type: text
  -
    handle: favorite_food_reason
    field:
      type: textarea
  -
    handle: least_favorite_food
    field:
      type: text
  -
    handle: least_favorite_food_reason
    field:
      type: textarea
```

It would bring every field inline and prefix each field's handle appropriately.

If you omit the `prefix` you won't be able to import them more than once at the same level because they would have the same handle and overwrite each other.


## Required Fields

Fields can be required, enforcing the need for content creators fill them out before saving or publishing.

While configuring a field, switch to the **Validation** tab and add the rule for `required` to the list.

<div class="screenshot">
    <img src="/img/required-field.png" width="521" alt="Required field validation"/>
    <div class="caption">This is how you make a field required.</div>
</div>

Here's a peek at how that YAML is structured.

```yaml
-
  handle: your_field
  field:
    type: text
    validation:
      - required
```


## Grid Fieldtype

The [Grid fieldtype](/fieldtypes/grid) lets you define a set of sub-fields, which it will allow you to repeat as many times as you like.

You should define its fields using the blueprint field syntax. This will allow you to reference other fields and/or import entire fieldsets.

<div class="screenshot">
    <img src="/img/grid.png" alt="An example grid field" />
    <div class="caption">This is an example Grid field.</div>
</div>

``` yaml
links:
  type: grid
  fields:
    -
      handle: url
      field: links.url
    -
      handle: text
      field: links.text
    -
      handle: external
      field: links.external
```


## Unlisted Fields

While [conditional fields](#conditional-fields) allow you to control field visibility on the publish form, you may also customize column visibility on **entry listings** in the control panel.

```yaml
listable: false
```

This hides the field column from entry listings, which can be useful for toggle fields etc, which may never make sense in the context of an entry listing.

```yaml
listable: hidden
```

This will hide the field from entry listings by default, but still allows a user to toggle visibility using the column selector, and save those column preferences for his/her preferred workflow.

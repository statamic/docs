---
id: 2940c834-7062-47a1-957c-88a69e790cbb
blueprint: page
title: Fieldsets
template: page
intro: 'Fieldsets are used to store and organize reusable fields.'
related_entries:
  - 54548616-fd6d-44a3-a379-bdf71c492c63
  - 9a1d8b88-c600-46f2-8727-1deb56f2e87a
---
## Overview

Fieldsets are almost functionally equivalent to [Blueprints](/blueprints), except that they exist for you to be able to create reusable fields.

While Blueprints attach directly to content like collections or forms, Fieldsets are not directly attached to anything.

Fieldsets contain [fields](/fields), just like Blueprints, but the benefit of using a Fieldset is that you can import their fields (or the whole thing) into other Blueprints. You can even import fieldsets into certain fieldtypes, like [Grid](/fieldtypes/grid), [Replicator](/fieldtypes/replicator), or [Bard](/fieldtypes/bard).

Fieldsets can be a simple flat list of fields, or organized into [sections](#sections) when you want to group related fields together for reuse across blueprints.

## Creating fieldsets

There are 2 ways to create fieldsets:

- In the **Fieldsets** area of the control panel.
- Creating a YAML file in the appropriate place within `resources/fieldsets/`. More on that in a moment.

Once created, you can begin to define its fields.

## Directory structure

Whether you manually create your fieldsets's YAML file, or use the control panel, they will all end up as YAML files in the `resources/fieldsets` directory.

``` files theme:serendipity-light
resources/
  fieldsets/
    bard-image.yaml
    bard-quote.yaml
    common.yaml
```

You can even nest fieldsets in subdirectories to further organize them. Use `.` in the handle to indicate a subdirectory.

### Customizing the path

You can change where fieldsets are stored by setting the `fieldsets_path` option in `config/statamic/system.php`:

```php
'fieldsets_path' => resource_path('fieldsets'),
```

## YAML structure

At its most basic, a fieldset has an array of fields.

```yaml
fields:
  -
    handle: content
    type: markdown
  -
    handle: featured
    type: toggle
```

## Sections

Fieldsets can optionally organize their fields into sections, just like blueprints. This is useful when you're building a reusable set of fields that you want grouped visually (like SEO metadata, Open Graph tags, or address fields) wherever they're imported.

A fieldset uses either a flat `fields` array _or_ a `sections` array. If you save a fieldset with a single, unnamed section, Statamic collapses it back down to the flat `fields` structure automatically.

```yaml
title: SEO
sections:
  -
    display: Metadata
    fields:
      -
        handle: meta_title
        field:
          type: text
      -
        handle: meta_description
        field:
          type: textarea
  -
    display: Open Graph
    instructions: Controls how this page appears when shared on social media.
    collapsible: true
    collapsed: true
    fields:
      -
        handle: og_title
        field:
          type: text
      -
        handle: og_image
        field:
          type: assets
          max_files: 1
```

Each section supports the following keys:

| Key | Description |
|-----|-------------|
| `display` | The section's display name. |
| `instructions` | Optional helper text shown under the section heading. |
| `collapsible` | Set to `true` to let users collapse the section on publish forms. |
| `collapsed` | When combined with `collapsible`, renders the section collapsed by default. |
| `fields` | The array of fields in the section. |

## Using fields

As mentioned earlier, a Fieldset is not inherently attached to anything. In order to use a field (or fields) in a fieldset, you'll need to approach it from the Blueprint side.

See the [Reusable Fields](/blueprints#reusable-fields) section of the Blueprint docs for more details.

### Importing a sectioned fieldset

When a blueprint imports a fieldset that has sections, you can control how those sections appear in the final publish form using `section_behavior`.

```yaml
# blueprint
sections:
  main:
    display: Main
    fields:
      -
        handle: content
        field:
          type: markdown
      -
        import: seo
        section_behavior: preserve
```

| Behavior | Description |
|----------|-------------|
| `preserve` _(default)_ | The imported fieldset's sections are kept intact. They are split out of the current section and rendered as their own publish sections. Any fields that appear _after_ the import stay in their own section below the imported sections. |
| `flatten` | All fields from the imported fieldset are merged directly into the current section as if it were a flat fieldset. |

The control panel surfaces this automatically — when you link a fieldset that contains sections, the "Section Behavior" control appears in the import settings, and a badge on the field indicates whether sections are being preserved or ignored.

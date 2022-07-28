---
id: cb21fabb-65ba-4869-9acd-f6aa2fb58a01
blueprint: page
title: Fields
template: page
intro: 'While in the control panel all content is managed inside fields. They come in many types, from basic text and select boxes, to rich text fields and image pickers. Fields are grouped into blueprints and fieldsets and can be reused in a number of different ways.'
related_entries:
  - 9a1d8b88-c600-46f2-8727-1deb56f2e87a
  - 54548616-fd6d-44a3-a379-bdf71c492c63
  - 2940c834-7062-47a1-957c-88a69e790cbb
  - 9b2f6f55-5355-4334-b90d-d1236fb58887
  - dd52c1f6-661b-4408-83c6-691fa341aaa7
---
## Configuration

### Common Settings

All fields share the following settings regardless of type:

- **Display** – The field's label shown throughout the control panel
- **Handle** – The field's variable name used in templates
- **Instructions** – Help text shown to your authors
- **Listable** – Whether to show the field as a column in the control panel's entry list
- **Visibility** – Allows you to control [field visibility](#field-visibility) on publish forms
- **Always Save** – Allows you to override [field data flow](#field-data-flow) on save
- **Localizable** – Whether the field can be translated in [other sites](#localization)

<figure>
    <img src="/img/field-settings.png" alt="Textarea field settings">
    <figcaption>A textarea field's settings screen.</figcaption>
</figure>

### Field Visibility

Fields are always visible by default, but you can configure custom visibility to any of the following options:

- **Visible** - Always visible
- **Read Only** - Prevent editing, but still submit current value on save
- **Computed** - Show read-only [computed value](/computed-values), and never submit this value on save
- **Hidden** - Always hide field on publish form, but still submit it's current value on save

:::tip
You can also dynamically show and hide your fields using [Conditional Fields](/conditional-fields) and/or [Revealer Fields](/fieldtypes/revealer).

**Note:** Unless you are using a Revealer, hiding a field using conditions will generally prevent its value from being submitted on save. Learn more about [Field Data Flow](#field-data-flow) to get the most out of this feature!
:::

### Field Data Flow

Fields are always submitted on save, except for in the following situations:

- If the field is configured to show a [computed value](/computed-values)
- If the field is dynamically hidden using [field conditions](/conditional-fields)

If you want to override the above-mentioned field condition data flow behaviour, you can either use a [Revealer Field](/fieldtypes/revealer), or set the following configuration on your field:

<figure>
    <img src="/img/field-always-save.png" alt="Always save field setting">
</figure>

## Blueprints & Fieldsets

[Blueprints](/blueprints) determine what fields are shown in your publish forms. You can configure the fields order, each field's width, and group them into sections and tabs.

Blueprints are attached to collections, taxonomies, global sets, assets, users, and even forms, all which help to determine their content schema.

[Fieldsets](/fieldsets) are used to store and organize **reusable fields**. Blueprints can reference fields or entire fieldsets, helping you keep your configurations nice and [DRY][dry].

## Fieldtypes

The visual UI and storage format for any given field is determined by its [fieldtype](/fieldtypes). There are 40+ included fieldtypes to help you design intuitive content management experiences for your authors.

<figure>
    <img src="/img/fieldtypes.png" alt="Statamic 3 fieldtype picker">
    <figcaption>The fieldtype picker thingamajig</figcaption>
</figure>

## Augmentation

Each field type has its own data storage format. Text and Markdown fields store strings (simple text), lists and YAML fields store arrays, Bard stores ProseMirror document objects, and so on.

Each fieldtype has the ability to _augment_ this data when accessed from the frontend of your site, transforming it into whatever format is easiest to work with.  In Statamic v2 this would need to be done manually with [modifiers](/modifiers). For example:

- **Asset** fields will return Asset objects with access to meta data and any additional fields
- **Bard** fields will transform ProseMirror document objects into an array of structured data and HTML.
- **Markdown** fields will automatically parse content and return HTML.
- **Relationship** fields will return the content objects of the entries they refer to.

:::tip
**Augmentation** is only performed when a field is defined in a blueprint. Data created "on the fly" in Front Matter may still require [modifiers](/modifiers) to transform it according to your whims and fancies.
:::

## Localization

Fields can be localized, allowing you to translate or modify content in a multi-site project.

For example, you could build the website for a multi-national company with headquarters in the United States and branches in the UK, and Germany.

- 🇺🇸 The "base" site the US/English version, and all content is created with that location and audience in mind.

- 🇬🇧 In the UK version you only need to localize a few fields, replacing "color" and "favorite" with "colour" and "favourite", and swapping out company phone numbers and addresses.

- 🇩🇪 In the German version of the site, however, all written content would need to be translated.

To accomplish this you can configure your Statamic install as a multi-site instance, enable localization on all appropriate fields, and switch between sites with the site switcher dropdown in the global nav, or the locale list in the sidebar of your publish forms.

Learn more about configuring Statamic for [multi-site](/multi-site) projects.




[dry]: https://en.wikipedia.org/wiki/Don%27t_repeat_yourself

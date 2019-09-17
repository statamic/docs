---
title: Partial
overview: Import fields from another fieldset.
options:
  -
    name: fieldset
    type: string
    description: Name of the fieldset to include.
id: 2c61bce9-6671-4d54-bfde-6d02afc8f670
---
## Usage

The Partial fieldset technically _isn't_ a Fieldset. It's a mechanism that allows you to import the fields from another Fieldset. This is handy when you want to reuse common fields throughout a number of other fieldsets, like a pile of metadata fields.

> You cannot use conditional logic on Fieldset Partials. They are imported and resolved before the logic is parsed. You can, however, add conditions on the contained fields themselves.

## Example

The `blog_post.yaml` fieldset, which is what you'll be associating to posts using `fieldset: blog_post`:

``` .language-yaml
fields:
  title:
    type: title
  seo: # this key can be anything as long as it's unique.
    type: partial
    fieldset: seo
  content:
    type: markdown
```

The `seo.yaml` field, which we'll reference as a partial from within `blog_post.yaml` above.

``` .language-yaml
fields:
  meta_description:
    type: text
  meta_keywords:
    type: text
```

When using the `blog_post` fieldset on the publish page, the fields from the partial will be brought inline and
rendered in the following order, as if they were all part of a single fieldset:

- `title`
- `meta_description`
- `meta_keywords`
- `content`

> **Important Caveat:** The field name of the partial does not matter _**as long as it's unique.**_ It will be replaced by the fields in the partial without any reference to the original name.

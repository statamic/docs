---
id: cbc7ecef-155f-45c0-9ac4-e815e120fa99
blueprint: fieldtype
title: Slug
screenshot: fieldtypes/screenshots/slug.png
description: A text input that automatically "slugifies" the value of another field.
overview: >
  A text field that has the ability to automatically "slugify" the value of any other string field to create-your-very-own-lowercase-without-spaces string of your own. This is primarily used to create a entry URL slugs based on the `title` field of that same entry.
options:
  -
    name: from
    type: string
    description: >
      Target field to automatically create a slug from. **Default:** `title`
  -
    name: generate
    type: boolean
    description: >
      Whether to generate the slug automatically. **Default:** `true`
---

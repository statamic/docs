---
id: d630ea15-d94f-4404-84d2-0926a898e672
blueprint: fieldtype
title: Form
screenshot: fieldtypes/screenshots/form.png
description: 'Pick a form, any form.'
overview: |
  Use this fieldtype to create a relationship with one of your site's [forms](/forms).
options:
  -
    name: max_items
    type: integer
    required: false
    description: 'The maximum number of forms that may be selected.'
  -
    name: placeholder
    type: string
    description: |
      Set the non-selectable placeholder text. Default: none.
  -
    name: query_scopes
    type: string
    description: >
      Allows you to specify a [query scope](/extending/query-scopes-and-filters#scopes) which should be applied when retrieving selectable forms.
related_entries:
  - fdb45b84-3568-437d-84f7-e3c93b6da3e6
  - aa96fcf1-510c-404b-9b63-cea8942e1bf8
---
## Overview

The Form fieldtype is gives your users a way to pick a form to include along with the current entry. How that form is implemented or shows up on the page is up to you.

## Data Storage

The Form fieldtype stores the `handle` of a single form as a string, or an array of handles if `max_items` is greater than 1.

## Templating

The Form fieldtype uses [augmentation](/augmentation) to return Form instances.

```
{{ form_field }}
    {{ fields }}
      <div class="p-2">
          <label>{{ display }}</label>
          <div class="p-1">{{ field }}</div>
          {{ if error }}
              <p class="text-gray-500">{{ error }}</p>
          {{ /if }}
      </div>
  {{ /fields }}
  <button type="submit">Submit</button>
{{ /form_field }}
```

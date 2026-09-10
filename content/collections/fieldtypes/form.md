---
id: d630ea15-d94f-4404-84d2-0926a898e672
blueprint: fieldtype
title: Form
screenshot: fieldtypes/screenshots/v6/form.webp
screenshot_dark: fieldtypes/screenshots/v6/form-dark.webp
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
      Allows you to specify a [query scope](/extending/query-scopes-and-filters#scopes) which should be applied when retrieving selectable forms. You should specify the query scope's handle, which is usually the name of the class in snake case. For example: `MyAwesomeScope` would be `my_awesome_scope`.
related_entries:
  - fdb45b84-3568-437d-84f7-e3c93b6da3e6
  - aa96fcf1-510c-404b-9b63-cea8942e1bf8
---
## Overview

The Form fieldtype is gives your users a way to pick a form to include along with the current entry. How that form is implemented or shows up on the page is up to you.

Not to be confused with [form fieldtypes](/forms#form-fieldtypes) — the fields you add _inside_ a form when building it. This fieldtype is for selecting an entire form from elsewhere, like an entry.

## Data Storage

The Form fieldtype stores the `handle` of a single form as a string, or an array of handles if `max_items` is greater than 1.

When an entry overrides a [unique instances](/frontend/forms-pro#unique-instances) form's settings, the value is stored as an array with `form` and `config` keys instead.

## Templating

The Form fieldtype provides a few useful variables:

* `handle`
* `title`
* `fields`
* `api_url`
* `honeypot`

You can pass the `handle` to the [`{{ form:create }}`](/tags/form-create) tag to render a `<form>` on your page:

::tabs

::tab antlers
```antlers
{{ form:create :in="form_fieldtype:handle" }}
    ...
{{ /form:create }}
```
::tab blade
```blade
<s:form:create :in="$form_fieldtype->handle">
    ...
</s:form:create>
```
::

## Unique Instances

When the selected form has [Unique Instances](/frontend/forms-pro#unique-instances) enabled (a [Forms Pro](/frontend/forms-pro) feature), the fieldtype does a little more on the entry's publish form:

- A **Configure** option lets you override the form's Access settings — close date, submission limit, closed message, and require login — and its [connections](/forms#connections), for that entry. Anything you leave blank, or any connection you don't touch, falls back to the form's setting.
- A **View Submissions** button opens the entry's submissions in a stack.

---
title: "Form:Fields"
id: 14d5eff2-1cd6-4318-1b35-67bc514be4ff
intro: >
  To be used within the [form:create](/tags/form-create#dynamically-rendering-fields) tag when dynamically rendering fields.
description: Recursive fields loop helper.
parameters:
  -
    name: get
    type: string
    description: >
      Get and render one specific field by its handle.
  -
    name: only
    type: string
    description: >
      Loop over only the specified field handles (pipe separated).
  -
    name: except
    type: string
    description: >
      Loop over all except the specified field handles (pipe separated).
stage: 4
---
## Example
This tag can recursively loop over the `fields` array context provided within the [form:create](/tags/form-create#dynamically-rendering-fields) tag pair.

::tabs

::tab antlers
```antlers
{{ form:fields }}
    <div class="p-2">
        <label>{{ display }}</label>
        <div class="p-1">{{ field }}</div>
        {{ if error }}
            <p class="text-gray-500">{{ error }}</p>
        {{ /if }}
    </div>
{{ /form:fields }}
```
::tab blade
```blade
<s:form:fields>
    <div class="p-2">
        <label>{{ $field['display'] }}</label>
        <div class="p-1">{{ $field['field'] }}</div>
        @if ($field['error'])
            <p class="text-gray-500">{{ $field['error'] }}</p>
        @endif
    </div>
</s:form:fields>
```
::

:::tip
Learn more about which [fields array variables](/tags/form-create#fields-array-variables) are available to this fields loop!
:::

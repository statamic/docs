---
id: e8956d9b-bba6-4270-b410-cba1046435bd
blueprint: tag
title: Get Errors
intro: 'This tag allows you to interact with a Laravel `ViewErrorBag` object to output validation errors.'
description: 'Gets validation errors'
stage: 1
parameters:
  -
    name: bag
    type: string
    description: 'The error bag. Defaults to `default`. You may have differently named bags if you have multiple forms on a page.'
---
## List all validation errors

The most common use case is to list all the validation errors. You can do this with the `all` tag.

If there are no errors, the tag will output nothing at all, so you can put your wrapping html around the inner `messages` tag pair.

::tabs

::tab antlers
```antlers
{{ get_errors:all }}
<div class="errors">
  <p>Oops, something went wrong!</p>
  <ul>
    {{ messages }}
      <li>{{ message }}</li>
    {{ /messages }}
  </ul>
</div>
{{ /get_errors:all }}
```
::tab blade
```blade
<s:get_errors:all>
<div class="errors">
  <p>Oops, something went wrong!</p>
  <ul>
    @foreach ($messages as $message)
      <li>{{ $message['message'] }}</li>
    @endforeach
  </ul>
</div>
</s:get_errors:all>
```
::

## List errors for a specific field

You can replace `all` with a field's handle to get errors for just that field.

::tabs

::tab antlers
```antlers
{{ get_errors:fieldname }}
<div class="errors">
  <p>Oops, something went wrong!</p>
  <ul>
    {{ messages }}
      <li>{{ message }}</li>
    {{ /messages }}
  </ul>
</div>
{{ /get_errors:fieldname }}
```
::tab blade
```blade
<s:get_errors:fieldname>
  <p>Oops, something went wrong!</p>
  <ul>
    @foreach ($messages as $message)
      <li>{{ $message['message'] }}</li>
    @endforeach
  </ul>
</s:get_errors:fieldname>
```
::

## Get the first error for a specific field
Useful for outputting inline errors, you can use the `get_error` tag.

::tabs

::tab antlers
```antlers
{{ get_error:fieldname }}
    <div class="inline-error">{{ message }}</div>
{{ /get_error:fieldname }}
```
::tab blade
```blade
<s:get_error:fieldname>
  <div class="inline-error">{{ $message }}</div>
</s:get_error:fieldname>
```
::

:::tip Note
That's `get_error` (singular), not `get_errors`.
:::


## Getting all errors, grouped by field

Using the standalone tag, you can loop through fields and then their errors.

::tabs

::tab antlers
```antlers
{{ get_errors }}
  <div class="errors">
    Oops!
    {{ fields }}
      <p>{{ field }}</p>
      <ul>
        {{ messages }}
          <li>{{ message }}</li>
        {{ /messages }}
      </ul>
    {{ /fields }}
  </div>
{{ /get_errors }}
```
::tab blade
```blade
<s:get_errors>
  <div class="errors">
    Oops!
    @foreach ($fields as $field)
      <p>{{ $field['field'] }}</p>
      <ul>
        @foreach ($field['messages'] as $message)
          <li>{{ $message['message'] }}</li>
        @endforeach
      </ul>
    @endforeach
  </div>
</s:get_errors>
```
::

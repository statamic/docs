---
id: e8504150-db55-4986-b567-19c046cc03de
blueprint: page
title: 'Blade Form Field Templates'
intro: 'By default, [Pre-rendered Field](tags/form-create#prerendered-field-html) templates are implemented in Antlers. If you prefer to use Blade, you may use the following snippets as a starting point in your project.'
---

## Publishing Existing Templates

You can publish the existing field templates by running `php artisan vendor:publish --tag=statamic-forms`. It will expose editable templates snippets in your `views/vendor/statamic/forms/fields` directory that will be used by each fieldtype.

These templates are used when rendering the pre-rendered `field` variable inside a [form](/forms):

```blade
@foreach ($fields as $field)
  <div class="mb-2">
    <label class="block">{{ $field['display'] }}</label>
    {!! $field['field'] !!}
  </div>
@endforeach
```

## Assets

`resources/views/vendor/statamic/forms/fields/assets.blade.php`

```blade
@php
  $isMultiple = ! isset($max_files) || $max_files !== 1;
  $fieldName = $handle;

  if ($isMultiple) {
    $fieldName .= '[]';
  }
@endphp

<input
  type="file"
  name="{{ $fieldName }}"
  @if (isset($js_driver)) {!! $js_attributes !!} @endif
  @if ($isMultiple) multiple @endif
  @required(in_array('required', $validate ?? []))
>
```

## Checkboxes

`resources/views/vendor/statamic/forms/fields/checkboxes.blade.php`

```blade
@php
  $inline = isset($inline) && $inline === true;
@endphp

<input type="hidden" name="{{ $handle }}[]">
@foreach ($options as $option => $label)
  <label>
    <input
      type="checkbox"
      name="{{ $handle }}[]"
      value="{{ $option }}"
      @if (isset($js_driver)) {!! $js_attributes !!} @endif
      @checked(in_array($option, $value ?? []))
      @required(in_array('required', $validate ?? []))
    >
    {{ $label === null ? $option : $label }}
  </label>
  @unless ($inline) <br> @endunless
@endforeach
```

## Default

`resources/views/vendor/statamic/forms/fields/default.blade.php`

```blade
<input
   type="{{ $input_type ?? 'text' }}"
   name="{{ $handle }}"
   value="{{ $value ?? '' }}"
   @if (isset($placeholder)) placeholder="{{ $placeholder }}" @endif
   @if (isset($character_limit)) maxlength="{{ $character_limit }}" @endif
   @if (isset($js_driver)) {!! $js_attributes !!} @endif
   @required(in_array('required', $validate ?? []))
>
```

## Dictionary

`resources/views/vendor/statamic/forms/fields/dictionary.blade.php`

```blade
@php
  $isMultiple = ! isset($max_items) || $max_items !== 1;
  $inline = isset($inline) && $inline === true;
  $placeholderText = $placeholder ?? __('Please select...');

  $fieldName = $handle;

  if ($isMultiple) {
    $fieldName .= '[]';
  }
@endphp

<select
  name="{{ $fieldName }}"
>
  @unless ($isMultiple)
    <option value>{{ $placeholderText }}</option>
  @endunless
  @foreach ($options as $option => $label)
    @php
      $selected = false;

      if ($isMultiple) {
        $selected = in_array($option, $value ?? []);
      } else {
        $selected = $option == $value;
      }
    @endphp
    <option
      value="{{ $option }}"
      @selected($selected)
    >{{ $label === null ? $option : $label }}</option>
  @endforeach
</select>
```

## Files

`resources/views/vendor/statamic/forms/fields/files.blade.php`

```blade
@php
  $isMultiple = ! isset($max_files) || $max_files !== 1;
  $fieldName = $handle;

  if ($isMultiple) {
    $fieldName .= '[]';
  }
@endphp

<input
  type="file"
  name="{{ $fieldName }}"
  @if (isset($js_driver)) {!! $js_attributes !!} @endif
  @if ($isMultiple) multiple @endif
  @required(in_array('required', $validate ?? []))
>
```

## Radio

`resources/views/vendor/statamic/forms/fields/radio.blade.php`

```blade
@php
  $inline = isset($inline) && $inline === true;
@endphp

@foreach ($options as $option => $label)
  <label>
    <input
      type="radio"
      name="{{ $handle }}"
      value="{{ $option }}"
      @if (isset($js_driver)) {!! $js_attributes !!} @endif
      @checked($value == $option)
      @required(in_array('required', $validate ?? []))
    >
    {{ $label === null ? $option : $label }}
  </label>
  @unless ($inline) <br> @endunless
@endforeach
```

## Select

`resources/views/vendor/statamic/forms/fields/select.blade.php`

```blade
@php
  $isMultiple = isset($multiple) && $multiple == true;
  $inline = isset($inline) && $inline === true;
  $placeholderText = $placeholder ?? __('Please select...');

  $fieldName = $handle;

  if ($isMultiple) {
    $fieldName .= '[]';
  }
@endphp

<select
  name="{{ $fieldName }}"
  @if (isset($js_driver)) {!! $js_attributes !!} @endif
  @if ($isMultiple) multiple @endif
  @required(in_array('required', $validate ?? []))
>
  @unless ($isMultiple)
    <option value>{{ $placeholderText  }}</option>
  @endunless
  @foreach ($options as $option => $label)
    @php
      $selected = false;

      if ($isMultiple) {
        $selected = in_array($option, $value ?? []);
      } else {
        $selected = $option == $value;
      }
    @endphp
    <option
            value="{{ $option }}"
            @selected($selected)
    >{{ $label === null ? $option : $label }}</option>
  @endforeach
</select>
```

## Text

`resources/views/vendor/statamic/forms/fields/text.blade.php`

```blade
<input
  type="{{ $input_type ?? 'text' }}"
  name="{{ $handle }}"
  value="{{ $value ?? '' }}"
  @if (isset($placeholder)) placeholder="{{ $placeholder }}" @endif
  @if (isset($character_limit)) maxlength="{{ $character_limit }}" @endif
  @if (isset($autocomplete)) autocomplete="{{ $autocomplete }}" @endif
  @if (isset($js_driver)) {!! $js_attributes !!} @endif
  @required(in_array('required', $validate ?? []))
>
```

## Textarea

`resources/views/vendor/statamic/forms/fields/textarea.blade.php`

```blade
<textarea
  name="{{ $handle }}"
  rows="5"
  @if (isset($placeholder)) placeholder="{{ $placeholder }}" @endif
  @if (isset($character_limit)) maxlength="{{ $character_limit }}" @endif
  @if (isset($js_driver)) {!! $js_attributes !!} @endif
  @required(in_array('required', $validate ?? []))
>{{ $value }}</textarea>
```

## Toggle

`resources/views/vendor/statamic/forms/fields/toggle.blade.php`

```blade
<label>
  <input type="hidden" name="{{ $handle }}" value="0">
  <input
    type="checkbox"
    name="{{ $handle }}"
    value="1"
    @if (isset($js_driver)) {!! $js_attributes !!} @endif
    @checked($value && $value !== '0')
    @required(in_array('required', $validate ?? []))
  >
  @if (isset($inline_label)) {{ $inline_label }} @endif
</label>
```
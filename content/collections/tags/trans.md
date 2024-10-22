---
title: Translate
intro: |
  Retrieve a string from a language file in the current locale.
parameters:
  -
    name: key
    type: tagpart|string
    description: 'The key of the translation string to find. Include both the filename and string key delimited with dots. Can be used as a tag part or a `key` parameter. If your key contains a namespace, you should use the key parameter instead of the tag part.'
  -
    name: locale|site
    type: string
    description: 'The locale to be used when translating.'
  -
    name: 'any parameters'
    type: string
    description: 'Any additional parameters will be treated as parameters that should be replaced in the string.'
  -
    name: count
    type: 'integer *1*'
    description: 'When using `trans_choice`, this is the number that defines the pluralization.'
id: 8ff99539-8b1a-4380-adf7-bdad979f8afd
---
This tag is the equivalent of the [trans and trans_choice methods](https://laravel.com/docs/localization) provided by Laravel.

:::tip
There's also a [modifier](/modifiers/trans) version that you may prefer.
:::

## Usage

Get the `bar` string from the `resources/lang/en/foo.php` translation file (where `en` is the current locale).

```php
<?php
return [
    'bar' => 'Bar!',
    'welcome' => 'Welcome, :name!',
    'apples' => 'There is one apple|There are :count apples',
];
```

::tabs

::tab antlers
```antlers
{{ trans:foo.bar }} or {{ trans key="foo.bar" }}
```
::tab blade
```blade
{{ trans('foo.bar') or {{ __('foo.bar') }}
```
::

```html
Bar!
```

## Replacements

Any additional tag parameters will be treated as parameters that should be replaced in the string.

::tabs

::tab antlers
```antlers
{{ trans:foo.welcome name="Bob" }}
```
::tab blade
```blade
{{ trans('foo.welcome', ['name' => 'Bob']) }}
```
::

```html
Welcome, Bob!
```

## Pluralization

To pluralize, use the `trans_choice` tag with a `count` parameter.

::tabs

::tab antlers
```antlers
{{ trans_choice:foo.apples count="2" }}
```
::tab blade
```blade
{{ trans_choice('foo.apples', 2) }}
```
::

```html
There are 2 apples
```

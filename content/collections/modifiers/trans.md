---
id: c77b02b6-3ce5-40e0-964c-a669685c12d3
blueprint: modifiers
title: Trans
---
Retrieve a string from a language file in the current locale. It is the equivalent of the [trans and trans_choice methods](https://laravel.com/docs/localization) provided by Laravel.

> There's also a [tag](/tags/trans) version that you may prefer.

## Usage {#usage}

Get the `bar` string from the `resources/lang/en/foo.php` translation file (where `en` is the current locale).

```php
<?php
return [
    'bar' => 'Bar!',
    'welcome' => 'Welcome, :name!',
    'apples' => 'There is one apple|There are :count apples',
];
```

``` yaml
key: 'foo.bar'
this_many: 2
```

```
{{ key | trans }} or {{ "foo.bar" | trans }}
```

```html
Bar!
```

## Replacements

Parameter replacements are only supported in the [tag version](/tags/trans).

## Pluralization {#pluralization}

To pluralize, use the `trans_choice` modifier with the count as the parameter. You can use a number or a variable.

```
{{ "foo.apples" | trans:2 }}
{{ "foo.apples" | trans:this_many }}
```

```html
There are 2 apples
```

## Strings

As you can see above, you may use the modifier on inline strings. Instead of translation keys, you can use simple strings.
These will be referenced from `resources/lang/fr.json` (where `fr` is the locale).

``` json
{
  "Hello": "Bonjour"
}
```

```
{{ "Hello" | trans }}
```

```html
Bonjour
```

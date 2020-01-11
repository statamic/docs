---
title: Markdown
id: be292d2b-dc0e-48dc-bce4-0058df27ccc6
---

## Basic Usage

You may parse Markdown in Statamic by using the `Markdown` facade.

``` php
Statamic\Facades\Markdown::parse('# Hello World!');
```
``` output
<h1>Hello World!</h1>
```

By default, Statamic follows the [CommonMark spec](https://spec.commonmark.org/current/) with a few extra features:

- GFM Tables
- HTML Attributes (eg. `# heading {.someclass #someid}`)
- Strikethrough (eg. `~~strikethrough~~`)

A few other extensions are available, but disabled by default:

- Autolinking
- HTML escaping
- Automatic line breaks


## Customizing Markdown behavior

Under the hood, we're using the [league/commonmark](https://commonmark.thephpleague.com/) package which supports all sorts of customization using extensions.

You may add an extension with the `addExtension` or `addExtensions` methods. For example, in the `boot` method of your `AppServiceProvider`, return an extension instance, or an array of them.

``` php
Markdown::addExtension(function () {
    return new EmojiExtension;
});
```
``` php
Markdown::addExtensions(function () {
    return [new EmojiExtension, new FootnotesExtension];
});
```

### Helper Methods

In addition to manually defining and configuring extensions, some frequently used behaviors are wrapped up in methods for you to use.

| Method | Description |
|--------|-------------|
| `withAutoLinks()` | Convert URLs and email addresses into links. (eg. `http://example.com` becomes `<a href="http://example.com">http://example.com</a>`) |
| `withSmartPunctuation()` | Convert plain quotes, dashes, ellipsis, etc into their unicode equivalents. Commonly referred to as "smartypants". (eg. `"CommonMark is the PHP League's Markdown parser"` becomes `“CommonMark is the PHP League’s Markdown parser”`) |
| `withMarkupEscaping()` | Converts HTML to entities. Useful for securing input from untrusted users. (eg. `<div>` becomes `&lt;div/&gt;`) |
| `withAutoLineBreaks()` | Converts newlines into `<br>` tags. Without this, you need to end a line with a `\` or two spaces. |
| `withStatamicDefaults()` | Enable the default set of extensions that Statamic uses (tables, strikethrough, etc). Without this, you will get a plain parser. |
| `newInstance($config)` | Gives you a new parser instance using an existing one as a starting point. It will inherit all the extensions and config. Accepts an array that will be merged into the config. |


## Custom Parsers

Any methods on the `Markdown` facade are forwarded onto the `default` Parser. This includes the `addExtension` methods described above.

You are free to create additional parsers that are configured independently, with their own configuration and extensions.

``` php
Markdown::makeParser($config) // Accepts an optional league/commonmark config array.
    ->withAutoLinks()
    ->addExtensions(...)
    ->parse('# Heading');
```

If you intend to reuse a parser, you may prefer to create it in one place (like a service provider), and then reference it elsewhere.

``` php
Markdown::extend('special', function ($parser) {
    return $parser
        ->withStatamicDefaults()
        ->addExtensions(...);
});
```
``` php
Markdown::parser('special')->parse('# Heading');
```

The closure provides you with a fresh `Parser` instance which you can customize as needed.

### Using a custom parser in a modifier

The `markdown` modifier accepts an optional argument to choose which parser to use.

```
{{ text | markdown:special }}
```

### Using a custom parser in a fieldtype

The `markdown` fieldtype allows you define the `parser`. This will be used when it augments the value, so you don't need the markdown modifier.

``` yaml
-
  handle: content
  field:
    type: markdown
    parser: special
```

---
title: Customizing Markdown
stage: 1
id: be292d2b-dc0e-48dc-bce4-0058df27ccc6
---

## Basic Usage

You may parse Markdown in Statamic by using the `Markdown` facade.

``` php
Statamic\Facades\Markdown::parse('# Hello World!');
```
```html
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

### Configuration

You may customize the behavior of the markdown parser by providing a CommonMark config array in `config/statamic/markdown.php`. All the available options are outlined in the CommonMark docs. You can override the [base options](https://commonmark.thephpleague.com/2.4/configuration/) as well as any [extension](https://commonmark.thephpleague.com/2.4/extensions/overview/)'s options.

You only need to provide the specific options you want to override. For example:

```php
'configs' => [
    'default' => [
        'allow_unsafe_links' => false, // [tl! ++:start]
        'heading_permalink' => [
            'symbol' => '#',
        ], // [tl! ++:end]
    ]
]
```

### Adding extensions

You may add an extension with the `addExtension` or `addExtensions` methods. For example, in the `boot` method of your `AppServiceProvider`, return an extension instance, or an array of them.

``` php
<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Statamic\Facades\Markdown;
use League\CommonMark\Extension\Footnote\FootnoteExtension;
use League\CommonMark\Extension\TableOfContents\TableOfContentsExtension;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Add one extension... [tl! focus:start]
        Markdown::addExtension(function () {
            return new FootnoteExtension;
        });

        // or multiple.
        Markdown::addExtensions(function () {
            return [new FootnoteExtension, new TableOfContentsExtension];
        }); // [tl! focus:end]
    }
}
```

:::tip
You can find a long list of Markdown Extensions [on the CommonMark site](https://commonmark.thephpleague.com/2.4/extensions/overview/), or around on GitHub. We love this [Hint Extension](https://github.com/ueberdosis/commonmark-hint-extension) by Ueberdosis – you're seeing it in action, powering this "Hot Tip" box.
:::

Statamic 5.0+ uses CommonMark 2.4, while previous versions used either CommonMark 2.2 or CommonMark 1.6. Keep this in mind when reading docs and looking for extension packages.

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

:::tip
If you need to provide a config to your custom parser, you can either [define it in the config file](#configuration) or pass an array as the second option.

```php
Markdown::extend('special', $config, function ($parser) {
    //
});
```
:::

### Using a custom parser in a modifier

The `markdown` modifier accepts an optional argument to choose which parser to use.

::tabs

::tab antlers
```antlers
{{ text | markdown:special }}
```
::tab blade
```blade
{!! Statamic::modify($text)->markdown('special') !!}
```
::

### Using a custom parser in a fieldtype

The `markdown` fieldtype allows you define the `parser`. This will be used when it augments the value, so you don't need the markdown modifier.

``` yaml
-
  handle: content
  field:
    type: markdown
    parser: special
```

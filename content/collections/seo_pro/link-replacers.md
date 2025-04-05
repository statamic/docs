---
id: 9bad1545-eeaa-4376-b132-61e26abd9062
blueprint: seo_pro
title: 'Link Replacers'
---
Link replacers are closely related to content mapping, and perform the actual link insertion when users [accept link suggestions](/seo-pro/the-link-manager#accepting-link-suggestions) within the [Link Manager](/seo-pro/the-link-manager).

Content mapping provides the path to the individual fields and their content, and link replacers are responsible for performing the update on the field's raw value. For example, the Bard link replacer works to decorate existing content nodes with the appropriate `href` marks, while the Textarea link replacer might do a simpler string replace.

SEO Pro ships with default replacer implementations for the following fieldtypes:

* [Bard](/fieldtypes/bard)
* [Markdown](/fieldtypes/markdown)
* [Textarea](/fieldtypes/textarea)
* [Text](/fieldtypes/text)

## Custom replacer implementations

Custom link replacer implementations must implement the `Statamic\SeoPro\Contracts\Linking\Links\FieldtypeLinkReplacer` interface.

As an example, the default `TextReplacer` implementation is as follows:

```php
<?php

namespace Statamic\SeoPro\Content\LinkReplacers;

use Illuminate\Support\Str;
use Statamic\Fieldtypes\Text;
use Statamic\SeoPro\Content\ReplacementContext;
use Statamic\SeoPro\Contracts\Linking\Links\FieldtypeLinkReplacer;

class TextReplacer implements FieldtypeLinkReplacer
{
    public static function fieldtype(): string
    {
        return Text::handle();
    }

    public function canReplace(ReplacementContext $context): bool
    {
        return Str::contains(
            $context->field->getValue(),
            $context->replacement->phrase
        );
    }

    public function replace(ReplacementContext $context): bool
    {
        $html = Str::replaceFirst(
            $context->replacement->phrase,
            $context->render('html'),
            $context->field->getValue()
        );

        $context->field->update($html)->save();

        return true;
    }
}

```

The static `fieldtype` method lets SEO Pro know the handle of the fieldtype the replacer is intended for.

The `canReplace` method returns a value indicating if the SEO Pro will be able to insert the link, while the `replace` method performs the actual content update.

## Registering custom replacers

Each custom replacer implementation needs to be registered. You may register them with the shared `LinkReplacer` instance:

```php
use Statamic\SeoPro\Content\LinkReplacer;

class MyServiceProvider extends ServiceProvider
{
    public function boot()
    {
      /** @var \LinkReplacer $replacer */
      $replacer = $this->app->make(LinkReplacer::class);
      
      $replacer->registerReplacers([
          CustomReplacer::class,
      ]);
    }
}
```
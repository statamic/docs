---
id: 14e56924-d3e2-4912-9a53-8e19cbad063e
blueprint: seo_pro
title: 'Parsing Content & Content Mapping'
intro: "SEO Pro's content linking features need to parse and analyze the content of pages within a site. SEO Pro does this making web requests to each eligible entry and parsing the HTML response."
---
## Template updates

For most sites, you will not need to do anything special since SEO Pro will locate and parse the contents of any `<article></article>` tags within the web response.

If a page does not contain these tags, if you would like to have more control over the content parsed by SEO Pro, you may use the `seo_pro:content` tag pair:

::tabs

::tab antlers
```antlers
{{ seo_pro:content }}
  <!-- Existing Content Here -->
{{ /seo_pro:content }}
```
::tab blade
```blade
<s-seo_pro:content>
  <!-- Existing Content Here -->
</s-seo_pro:content>
```
::

The `seo_pro:content` tag pair may be used multiple times. This tag works be emitting special HTML comments, but only when SEO Pro is scanning your site for content and links.

Once SEO Pro has retrieved the content for an entry, it will then perform a "content mapping" step, which works to associate the raw field data with the rendered output. This information is then used when producing link suggestions or updating entry contents.

## Content mapping

Content mapping is a sub-feature that maps the raw fieldtype data of your site's entries to their content and final HTML output. This allows SEO Pro to update and insert links within your content automatically.

### How content mapping works

Content mapping works by iterating all of the fields within an entry and building up an internal path to the field's final contents. Because of this, each fieldtype needs its own content mapper in order to work correctly with SEO Pro's linking features. SEO Pro ships with support for the following content mappers by default:

* [Bard](/fieldtypes/bard)
* [Grid](/fieldtypes/grid)
* [Group](/fieldtypes/group)
* [Markdown](/fieldtypes/markdown)
* [Replicator](/fieldtypes/replicator)
* [Text](/fieldtypes/text)
* [Textarea](/fieldtypes/textarea)

The results of the content mapping process are stored within the `seopro_entry_links.content_mapping` database column. This column contains a key/value pair of all discovered content paths and their raw content.

The structure of a simple content path, such as one for a text fieldtype, is as follows:

```json
{
  "title{display_name:Title}{type:text}":
  "I had a really good idea but got sidetracked and forgot it."
}
```

The key of the content mapping provides information that allows SEO Pro to relocate the content within your entry's content, as well as additional metadata, such as the field's handle, type, and display name. The field handle will always appear first, with additional information appearing after it within curly braces.

A more complicated content path for a nested grid might look like this:

```json
{
  "options{display_name:Options}{type:grid}[4]type{type:text}":
  "string",
  "options{display_name:Options}{type:grid}[4]description{type:markdown}":
  "Sort and order by field name. E.g. `'title:desc'`. Defaults to the collection's settings." 
}
```

This content path also includes square brackets, which will be common in fieldtypes like Bard, Replicator, or the Grid, which may allow for multiple array values.

### Implementing custom content mappers

All content mappers must implement the `Statamic\SeoPro\Contracts\Content\FieldtypeContentMapper` interface. The simplest way to do this is to extend SEO Pro's `Statamic\SeoPro\Content\Mappers\AbstractFieldMapper` and implement the required methods:

```php
<?php

use Statamic\SeoPro\Content\Mappers\AbstractFieldMapper;

class CustomMapper extends AbstractFieldMapper
{

    /**
     * The fieldtype's handle.
     */
    public static function fieldtype(): string
    {
        return \Statamic\Fieldtypes\Text::handle();
    }

    public function getContent(): void
    {
        // Custom implementation here.
    }
}
```

Once you've implemented a custom content mapper you need to register it:

```php
use Statamic\SeoPro\Content\ContentMapper;

class MyServiceProvider extends ServiceProvider
{
    public function boot()
    {
      /** @var ContentMapper $contentMapper */
        $contentMapper = $this->app->make(ContentMapper::class);
      
      $contentMapper->registerMappers([
        CustomMapper::class,
      ]);
    }
}
```

### Disabling content mapping for a field

To disable content mapping for a specific field, you may add the `seo_pro_map_content` key to the field's configuration within the blueprint and set it to `false`:

```yaml
title: Blog
sections:
  main:
    display: Main
    fields:
      -
        handle: title
        field:
          type: text
          required: true
          validate:
            - required
      -
        handle: intro
        field:
          type: bard
          display: Intro
          seo_pro_map_content: false
```
---
id: 6a18eac8-6139-419c-9d64-a2c960ccc3cd
blueprint: page
title: Taxonomies
intro: 'A taxonomy is a system of classifying data around a set of unique characteristics. Scientists have been using this system for years, grouping all living creatures into Kingdoms, Class, Species and so on. Taxonomies are the primary means for grouping content together by topic or a shared attribute.'
related_entries:
  - 7202c698-942a-4dc0-b006-b982784efb03
  - ba832b71-a567-491c-b1a3-3b3fae214703
  - 3f5506d6-03e0-4fcf-b4e8-334c48d51f81
  - 420f083d-99be-4d54-9f81-3c09cb1f97b7
---
## Overview

Taxonomies give you the ability to tag your entries and then fetch and sort all the entries that share any given tag. `Categories` and `tags` are probably the most common taxonomies, but you're not limited to those two. There are many useful taxonomies that can help group and sort your content. For example, `topic`, `color`, `genre`, and `size`.

Practically speaking, taxonomies are very similar to [collections](/collections). They can have their own fields as defined by [blueprints](/blueprints) and also have their own URLs.

Each entry in a taxonomy is often called a **term**.

:::watch https://youtube.com/embed/vssXeEC118M
Watch how to set up your first Taxonomy
:::

## Collections

Each collection defines which taxonomies are part of its content model in their blueprint. Thus, taxonomies and their terms are connected to entries _through_ the collection in a strict relationship. Once you attach a taxonomy to a collection, the fields, variables, and routes are added automatically.

Taxonomies can be attached to any number of collections but their terms are _global_, which means that any data stored on each term will be the same no matter the collection it's being related through. This is usually what you want, but if it isn't you can create additional taxonomies for specific collections. For example: `product_tags` in addition to `tags`.

## Blueprints

Each taxonomy uses blueprints to define the available fields when creating and editing its terms.

If you don't explicitly create a blueprint, your terms will have a basic set of fields: title, markdown content, slug, etc. Of course, you're able to create your own.

If you create _more than_ one blueprint you'll be given the option to choose which one you want when creating a new term.

## Routing

Taxonomy routes are automatically created for you **if the corresponding view exists**.

:::tip
URLs use slugs with dashes, and views use handles with underscores.
:::

- **Global Taxonomy Details**
  - Display the details of the taxonomy, so you can list the terms.
  - Accessible at `/{taxonomy-slug}` (eg. `/tags`)
  - The `{taxonomy_handle}/index` view will be used (eg. `tags/index.antlers.html`)
- **Global Term details**
  - Display the details of the term, so you can list the entries.
  - Accessible at `/{taxonomy-slug}/{term-slug}` (eg. `/tags/t-shirts`)
  - The `{taxonomy_handle}/show` view will be used. (eg. `tags/show.antlers.html`)

For each taxonomy [assigned to a collection](#collections) you will also get these routes:

- **Collection Taxonomy Details**
  - Display the details of the taxonomy, so you can list the terms.
  - Only terms that have been used in entries in the collection will be displayed.
  - Accessible at `/{collection-url}/{taxonomy-slug}` (eg. `/products/tags`)
  - The `{collection_handle}/{taxonomy_handle}/index` view will be used (eg. `products/tags/index.antlers.html`)
- **Collection Term details**
  - Display the details of the term, so you can list the entries.
  - Only entries that exist in the collection will be displayed.
  - Accessible at `/{collection-url}/{taxonomy-slug}/{term-slug}` (eg. `/products/tags/t-shirts`)
  - The `{collection_handle}/{taxonomy_handle}/show` view will be used. (eg. `products/tags/show.antlers.html`)

## Term Values and Slugs

A term **value** is how you might identify a term in your content. For example, “Star Wars”.

A term **slug** is the URL-safe version, and is what Statamic uses internally to track terms, e.g. `star-wars`. The slug is created automatically based on a few rules. Let’s cover them now.

How we slugify your terms:

``` yaml
tags:
  - Star Wars
  - Tatooine
  - Droids We're Not Looking For
```

- The value `Star Wars` will be converted to lowercase, and all spaces and special characters will be replaced with hyphens: `star-wars`.
- If a term with the slug `star-wars` already exists, the relation is made.
- If no such term yet exists one will be created, and the entered value (`Star Wars`) will become the title.

Titles are saved on a first-come, first-serve basis, which means consistency is important. If you enter `Star Wars` in one entry, and `star wars` in another, whichever term Statamic encounters first will be used as the title.

To further clarify, `Star wars`, `star wars`, `StAr WaRS`, and `star-wars` are all treated as the same term. If case-sensitivity is important, you can add a `title` field to the taxonomy blueprint.

## Templating

### Views

Taxonomies use the following view template naming convention:

| Purpose | View |
|---|---|
| Taxonomy Index  | `{taxonomy_name}/index` |
| Single Term | `{taxonomy_name}/show` |
| Taxonomy Index (for collection)  | `{collection}/{taxonomy_name}/index` |
| Single Term (for collection) | `{collection}/{taxonomy_name}/show` |

For example, you would set up your "topics" index page in `resources/views/topics/index.antlers.html` and then a specific topic with a list of all entries inside it at `resources/views/topics/show.antlers.html`.

The collection equivalents would automatically filter terms that have been associated to entries in that collection.

### Outputting Terms

Term values will be [augmented](/augmentation) into term objects and will have access to all data

``` yaml
tags:
  - awesome
  - sauce
```

::tabs

::tab antlers
```antlers
{{ tags }}
  {{ title }}, {{ url }}, {{ slug }}, etc
{{ /tags }}
```
::tab blade
```blade
@foreach ($tags as $tag)
  {{ $tag->title }}, {{ $tag->url }}, {{ $tag->slug }}, etc
@endforeach
```
::

```
Awesome, /tags/awesome, awesome, etc
Sauce, /tags/sauce, sauce, etc
```

When the collection can be inferred, the `url` and `permalink` values will include the collection's URL. (eg. `/blog/tags/awesome` instead of just `/tags/awesome`)
- ✅ Looping through tags on an entry's page.
- ✅ Looping through tags while inside a collection tag pair.
- ✅ Looping through terms in a taxonomy tag pair, using the collection parameter.
- ❌ Looping through terms in a taxonomy tag pair, without specifying a collection.

### Listings and Indexes

When on a [taxonomy route](#routing), you can list the terms by using a `terms` tag pair. For example:

::tabs

::tab antlers
```antlers
<ul>
  {{ terms }}
    <li><a href="{{ url }}">{{ title }}</a></li>
  {{ /terms }}
</ul>
```

:::tip
You can replace the `terms` tag with the name of the taxonomy. eg. `{{ tags }}` or `{{ categories }}`
:::

:::tip
If your taxonomy name conflicts with a [tag](/tags), you will need to [disambiguate](/antlers#disambiguating-variables) it by using a dollar symbol (`$`).

For example, if your taxonomy is named `section`, there is also a [tag named section](/tags/section).

```
{{ $section }}...{{ /$section }}
```
:::

::tab blade
```blade
<ul>
  @foreach ($terms as $term)
    <li><a href="{{ $term->url }}">{{ $term->title }}</a></li>
  @endforeach
</ul>
```

:::tip
You can replace the `terms` tag with the name of the taxonomy. eg. `$tags` or `$categories`
:::
::


### Listing Term Entries

When on a [term route](#routing), you can list the entries by using an `entries` tag pair. For example:

::tabs

::tab antlers
```antlers
{{ entries paginate="5" }}
  <ul>
  {{ results }}
    <li><a href="{{ url }}">{{ title }}</a></li>
  {{ /results }}
  </ul>
{{ /entries }}
```
::tab blade
```blade
@php($results = $entries->paginate(5))

<ul>
	@foreach ($results->items() as $result)
		<li><a href="{{ $result->url }}">{{ $result->title }}</a></li>
	@endforeach
</ul>
```
::

## Search Indexes

You can configure search indexes for your collections to improve the efficiency and relevancy of your users searches. Learn [how to connect indexes](/search#connecting-indexes).

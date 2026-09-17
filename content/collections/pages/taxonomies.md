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

If the taxonomy is [nestable](#nested-term-urls), term URLs include the slugs of the term's ancestors.

## Term values and slugs

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

## Ordering and hierarchy

Flick on the **Orderable** switch in the "Ordering & Hierarchy" area of a taxonomy's settings and you'll have a drag and drop UI in the control panel to order and nest the terms. The taxonomy is now "structured". Learn more about [structures](/structures).

Existing terms are added to the tree in their current sort order, so turning the switch on doesn't rearrange anything on its own.

### Constraining depth

A structured taxonomy will **not** have a maximum depth unless you set one, allowing you to nest terms as deep as you like. Set the **Max Depth** option to limit this behavior. Setting it to `1` gives you a flat, reorderable list — order without nesting, and term URLs stay flat.

``` yaml
# content/taxonomies/product_categories.yaml
title: 'Product Categories'
structure:
  max_depth: 3
```

:::tip
Max depth is enforced on the server, not just in the tree UI. Nesting a term too deep — by dragging it, or by choosing a parent when creating one — will be rejected.
:::

### Nested term URLs

Once a taxonomy is nestable (structured with a max depth other than `1`), the default term route gains a `{parent_uri}` segment:

```url
/{taxonomy-slug}/{parent_uri}/{term-slug}
```

So a `shirts` term nested under `clothing` lives at `/product-categories/clothing/shirts`. Root terms have an empty `parent_uri` and keep their existing URL.

### The tree

A taxonomy's tree is stored in a single file at `content/trees/taxonomies/{taxonomy_handle}.yaml`, and each branch references a term by slug.

``` yaml
tree:
  -
    term: clothing
    children:
      -
        term: shirts
  -
    term: footwear
```

:::tip
You *can* edit the tree in the file. You *shouldn't*, unless you enjoy YAML indentation as a hobby. The Control Panel's drag-and-drop UI is the move.
:::

### Multi-site

**Taxonomy trees are not per-site.** There is one tree per taxonomy, shared by every site — which is why there's only one tree file, with no site directory. Shape and order are global. Titles, slugs, and therefore parent URIs *are* localized, exactly as they already were for terms.

This is a **deliberate divergence from [collection structures](/collections#ordering)**, which do have a tree per site. A long-standing complaint about collection trees is that people want to arrange things once and have it apply everywhere, which is closer to how terms already work.

Two consequences are worth stating outright, because both read the other way round at first glance:

- **The site selector on a taxonomy switches which site the tree is _rendered_ in, not which tree you are editing.** It swaps the titles, slugs, and URLs shown on each branch. Dragging a term to a new position applies that move to every site. The same control on a collection means something different.
- **The `site` parameter on the [tree endpoint](/rest-api#taxonomy-tree) localizes the term payloads, not the tree's shape or order.** The parameter reads as though it selects a tree; it doesn't.

Branches reference a term by its slug in the default site, so renaming a slug in a secondary site never moves a term in the tree.

### Hierarchy variables

On a structured taxonomy, terms get these variables in addition to the usual ones.

| Variable | Description |
|----------|-------------|
| `parent` | The term one level up, or `null` for a root term. |
| `children` | The terms directly beneath this one. |
| `ancestors` | Every term above this one, root first. |
| `depth` | How deep the term sits in the tree. Root terms are `1`. |

::tabs

::tab antlers
```antlers
{{ ancestors }}
  <a href="{{ url }}">{{ title }}</a> /
{{ /ancestors }}

<h1>{{ title }}</h1>

<ul>
  {{ children }}
    <li><a href="{{ url }}">{{ title }}</a></li>
  {{ /children }}
</ul>
```
::tab blade
```blade
@foreach ($ancestors as $ancestor)
  <a href="{{ $ancestor->url }}">{{ $ancestor->title }}</a> /
@endforeach

<h1>{{ $title }}</h1>

<ul>
  @foreach ($children as $child)
    <li><a href="{{ $child->url }}">{{ $child->title }}</a></li>
  @endforeach
</ul>
```
::

:::tip
Terms don't have an `is_root` variable. To check whether you're on a top-level term, compare the depth — `{{ if depth == 1 }}` in Antlers, or `@if ($depth == 1)` in Blade. That's the same check Statamic uses internally.

If you're writing PHP, don't reach for `LocalizedTerm::isRoot()` for this. It's unrelated, and answers a different question: whether the term is in the default site.
:::

### Descendant entries

Filtering entries by a term on a nestable taxonomy **includes the entries of that term's whole subtree by default**. Asking for entries in `clothing` gets you everything tagged `shirts` and `shoes` too, which is almost always what you want from a category page.

When it isn't, pass `with_descendants="false"` to limit the results to entries tagged with that exact term.

::tabs

::tab antlers
```antlers
{{ collection:products taxonomy:product_categories="clothing" with_descendants="false" }}
  {{ title }}
{{ /collection:products }}
```
::tab blade
```blade
<statamic:collection:products
    taxonomy:product_categories="clothing"
    with_descendants="false"
>
    {{ $title }}
</statamic:collection:products>
```
::

The opt-out is available wherever you can filter entries by a term:

| Where | How |
|-------|-----|
| [Collection tag](/tags/collection) | `with_descendants="false"` |
| `{{ entries }}` on a [term route](#routing) | `with_descendants="false"` |
| The `{{ query }}` tag, and any other tag pair that loops over a query builder | `with_descendants="false"` |
| [REST API](/rest-api#entries) collection entries | `?with_descendants=false` |
| [REST API](/rest-api#taxonomy-term-entries) term entries | `?with_descendants=false` |
| [GraphQL](/graphql#entries-query) `entries` query | `with_descendants: false` |

On a flat taxonomy — or one with a max depth of `1` — there are no descendants, so the parameter does nothing.

:::tip
In PHP, call `withTaxonomyDescendants(false)` on the [query builder](/content-queries).

```php
Entry::query()
    ->whereTaxonomy('product_categories::clothing')
    ->withTaxonomyDescendants(false)
    ->get();
```
:::

The `entries_count` variable counts descendants too, so it agrees with what `{{ entries }}` gives you. It has no opt-out — query the entries yourself if you need a count of only the directly tagged ones.

### Turning it off

:::warning
Switching **Orderable** back off **deletes the taxonomy's tree file immediately**, without a confirmation, and there's no undoing it.

Your terms are untouched, but they stop being nested — so every nested term's URL moves. A term that lived at `/product-categories/clothing/shirts` is now at `/product-categories/shirts`, and the old URL returns a 404. Set up [redirects](/routing#redirects) before you flip the switch on a live site.

Structured collections behave the same way when you turn **Orderable** off.
:::

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

### Outputting terms

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

### Listings and indexes

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


### Listing term entries

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

On a nestable taxonomy this includes the entries of the term's [descendants](#descendant-entries). Add `with_descendants="false"` to get only the entries tagged with this exact term.

## Search indexes

You can configure search indexes for your collections to improve the efficiency and relevancy of your users searches. Learn [how to connect indexes](/search#connecting-indexes).

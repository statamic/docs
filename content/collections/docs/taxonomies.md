---
title: Taxonomies
template: page
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1568558383
id: 6a18eac8-6139-419c-9d64-a2c960ccc3cd
blueprint: page
---
Taxonomies are kept in `content/taxonomies`, each with their own YAML file, and their entries in a subdirectory.

```
taxonomies/
|-- tags.yaml
|-- tags/
    |-- good.yaml
    |-- great.yaml
    |-- best.yaml
```

Each Taxonomy's YAML file can configure various things, such as the route for the terms.
It can also define data that should cascade down to all of its terms.

``` yaml
title: Tags
route: 'tags/{slug}'
```

## Assigning to Collections

A taxonomy (or multiple taxonomies) can be assigned to a collection.

``` yaml
# content/collections/blog.yaml

title: Blog
taxonomies:
  - tags
```

When editing an entry in that collection, taxonomy fields will be automatically added.

## Taxonomizing Entries

To taxonomize an entry, you can add [term values](#term-values-and-slug) to a field named **exactly** the same as the taxonomy's handle.

``` yaml
title: My Entry
tags:
  - foo
  - bar
  - baz
```

Now when listing entries that belong to the `foo`, `bar`, or `baz` terms, the entry will appear.

>  Make sure that the field is named exactly the same as the taxonomy handle, otherwise it will not be considered part of that taxonomy term.

## Routing

You don't need to manually set up any routes, they are automatically generated for you.

For each taxonomy, a number of routes will exist:

- **Global Taxonomy Details**
  - Display the details of the taxonomy, so you can list the terms.
  - Accessible at `/{taxonomy slug}` (eg. `/tags`)
  - The `taxonomy` view will be used.
- **Global Term details**
  - Display the details of the term, so you can list the entries.
  - Accessible at `/{taxonomy slug}/{term slug}` (eg. `/tags/retrowave`)
  - The `term` view will be used.

For each taxonomy [assigned to a collection](#assigning-to-collections), and when [the collection has been mounted](/guide/collections.html#mounting), you will also get these routes:

- **Collection Taxonomy Details**
  - Display the details of the taxonomy, so you can list the terms.
  - Only terms that have been used in entries in the collection will be displayed.
  - Accessible at `/{collection url}/{taxonomy slug}` (eg. `/blog/tags`)
  - The `taxonomy` view will be used.
- **Collection Term details**
  - Display the details of the term, so you can list the entries.
  - Only entries that exist in the collection will be displayed.
  - Accessible at `/{collection url}/{taxonomy slug}/{term slug}` (eg. `/blog/tags/retrowave`)
  - The `term` view will be used.

### Customizing Collection Views

If you want to use specific views for the collection's automatic routes, you can add the following to the collection's YAML file:

``` yaml
taxonomies:
  tags:
    routes:
      index: tags.index
      show: tags.show
```

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

To further clarify, `Star wars`, `star wars`, `StAr WaRS`, and `star-wars` are all treated as the same term. If perfect consistency is important, you can add a title field to a term’s [additional data](#additional-term-data).

## Templating

### Outputting Terms

Term values will be augmented into term objects (assuming you haven't overidden the fieldtype in your blueprint).

``` yaml
tags:
  - awesome
  - sauce
```

```
{{ tags }}
  {{ title }}, {{ url }}, {{ slug }}, etc
{{ /tags }}
```

```
Awesome, /tags/awesome, awesome, etc
Sauce, /tags/sauce, sauce, etc
```

When the collection can be inferred, the `url` and `permalink` values will include the collection's URL. (eg. `/blog/tags/awesome` instead of just `/tags/awesome`)
- ✅ Looping through tags on an entry's page.
- ✅ Looping through tags while inside a collection tag pair.
- ✅ Looping through terms in a taxonomy tag pair, using the collection parameter.
- ❌ Looping through terms in a taxonomy tag pair, without specifying a collection.

### Listing Taxonomy Terms

When on a [taxonomy route](#routing), you can list the terms by using either a `terms` tag pair. For example:

``` html
{{ terms paginate="5" }}
  <ul>
  {{ results }}
    <li><a href="{{ url }}">{{ title }}</a></li>
  {{ /results }}
  </ul>
{{ /terms }}
```

>  You can replace the `terms` tag with the name of the taxonomy. eg. `{{ tags }}` or `{{ categories }}`

### Listing Term Entries

When on a [term route](#routing), you can list the entries by using an `entries` tag pair. For example:

``` html
{{ entries paginate="5" }}
  <ul>
  {{ results }}
    <li><a href="{{ url }}">{{ title }}</a></li>
  {{ /results }}
  </ul>
{{ /entries }}
```

## Additional Term Data

Additional data (custom fields) can be added to a term by creating a yaml file matching the term’s [slug](#term-values-and-slugs).

```
site/content/taxonomies
|-- tags.yaml
`-- tags
    |-- foo.yaml
    `-- bar.yaml
```

In the YAML file, add data like so:

``` yaml
food: bacon
drink: whisky
```

Whenever referencing the Terms in your templates, now `{{ food }}` and `{{ drink }}` would output `bacon` and `whiskey` respectively.

Just like entries, these values will be augmented automatically in your templates depending on the blueprint.
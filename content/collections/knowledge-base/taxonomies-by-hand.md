---
title: 'Working with Taxonomies by Hand'
intro: 'Sometimes you just don''t feel like using a control panel.'
id: 3f5506d6-03e0-4fcf-b4e8-334c48d51f81
---
## Creating Taxonomies

Taxonomies are kept in `content/taxonomies`, each with their own YAML file, and their entries in a matching subdirectory.

```
taxonomies/
|-- tags.yaml
|-- tags/
    |-- good.yaml
    |-- great.yaml
    |-- best.yaml
```

Each Taxonomy's YAML file can contain its title, as well as any data that should be injected into all its terms.

``` yaml
title: Tags
inject:
  foo: bar
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

## Additional Term Data

Additional data (custom fields) can be added to a term by creating a yaml file matching the term’s [slug](/taxonomies#term-values-and-slugs).

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

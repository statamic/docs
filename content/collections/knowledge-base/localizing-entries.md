---
title: 'Localizing Entries'
id: 4bc357de-4711-4010-8b83-77ca7337e90b
---

> You can use the `php please multisite` to automate converting from a single to a multisite installation.

## Defining Sites

When using [multiple sites](/multi-site), you'll need to specify in the collection's YAML file which sites this collection can be used in.

``` yaml
# content/collections/blog.yaml
sites:
  - en
  - fr
```

## Folder Structure

The folder structure will differ from the single site structure explained in the [entries guide](/collections). Now, entries should be organized into the respective sites.

``` files
collections
|-- blog.yaml
|-- blog/
|   |-- en/
|   |   |-- 2015-01-18.my-first-day.md
|   |   |-- 2015-01-19.paperwork-and-snowshoeing.md
|   |   |-- 2015-03-08.spring-wonderful-spring.md
|   |   |-- 2015-05-16.speeder-bikes-and-wookies.md
|   `-- fr/
|       `-- 2015-01-18.my-first-day.md
|       `-- 2017-07-14.bastille-day.md
|-- news.yaml
`-- news/
    `-- en/
       `-- 2017-04-01.its-happening.md
```


<mark>An entry will only be available in that site if the entry has explicitly been localized.</mark> For example, in the blog above, `my-first-day` would appear in both English and French sites, where `bastille-day` would only appear in the French site.

> This behavior is different from what you may be used to in Statamic v2, where if the entry existed in the default locale, it would be visible in subsequent locales.

## Localizable fields

In a [Blueprint](/blueprints), you can define which fields are localizable.

While editing a localized entry, only the localizable fields will be editable. The non-localizable fields will be read-only.


## Entry origins

A localized entry should define where it originated, and will inherit any undefined values from its origin.

For example, you can create an entry in the English site, then choose to localize it into the French site, and vice versa.

``` yaml
# en/2015-01-18.my-first-day.md
id: 123
title: My First Day
image: forest.jpg
```

``` yaml
# fr/2015-01-18.my-first-day.md
origin: 123
id: 456
title: Mon Premier Jour
```

Here you can see that since the French version does not have `image` defined, it will inherit it from the English version.

> Notice that the French version has a different ID from the English version. In Statamic v3, <mark>every entry has its own ID</mark>, which is different from the Statamic v2 behavior.

---
id: 4bc357de-4711-4010-8b83-77ca7337e90b
title: 'Localizing Entries'
template: page
categories:
  - localization
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1622821157
---
:::tip
You can use the `php please multisite` to automate converting from a single to a multisite installation.
:::

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

:::tip
This behavior is different from what you may be used to in Statamic v2, where if the entry existed in the default locale, it would be visible in subsequent locales.
:::

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

:::tip
Notice that the French version has a different ID from the English version. In Statamic v3, <mark>every entry has its own ID</mark>, which is different from the Statamic v2 behavior.
:::

## Deleting

As explained above, when you localize an entry, an `origin` is added to the localization. If you were to delete the original entry, the localization would then
be referencing an entry that no longer exists. This could cause some confusion to Statamic!

If you want to delete an origin, you need to make a decision on how to handle any of its localizations. When deleting entries through the Control Panel, you will be presented with two options:

![](/img/knowledge-base/delete-localization-modal.png)

### Option 1: Delete

If you no longer need the localized version, then you can choose to just delete them.

An example of this may be when you have an entry and then you've simply translated it. It probably doesn't make sense to keep a translated version if the original no longer exists.

When dealing with files, simply make sure that you've also deleted the localization.

### Option 2: Detach

Detaching essentially turns the localizations into their own standalone entries.

An example of this may be when you have a product being sold in multiple locations. You may have created the product
in one location, and localized the price in other locations. Then, you discontinue the product in the original location.
You probably still want the product to exist in the other location.

What will happen with this option is that any data that you haven't overridden on the localization will be copied to it.
The `origin` will also be removed.

When dealing with files, make sure that you remove the origin, and copy any leftover data across manually.

---
id: 660e700e-0602-49fc-a8fb-ac47b9884e52
title: 'Localizing Globals'
template: page
categories:
  - localization
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1622821162
---
:::tip
You can use the `php please multisite` to automate converting from a single to a multisite installation.
:::

## Defining Sites

When using [multiple sites](/multi-site), you'll need to specify in the globals's YAML file which sites this collection can be used in.

``` yaml
# content/collections/blog.yaml
sites:
  - en
  - fr
```

## Folder Structure

The folder structure will differ from the single site structure explained in the [globals guide](/globals). Now, the `data` will be relocated into separate files organized into sites. The meta level information will remain in the existing YAML file.

``` files theme:serendipity-light
globals/
  global.yaml
  footer.yaml
  english/
    global.yaml
    footer.yaml
  french/
    global.yaml
    footer.yaml
```

In these nested files, the data can exist at the top level.

``` yaml
# english/global.yaml
food: bacon
drink: whisky
sport: football
```
``` yaml
# french/global.yaml
origin: english
food: baguette
drink: champagne
```

:::tip
A global set will be considered unavailable for a particular site if a file doesn't exist in its subdirectory.
:::


## Localizable fields

In a [Blueprint](/blueprints), you can define which fields are localizable.

While editing a localized global set, only the localizable fields will be editable. The non-localizable fields will be read-only.


## Origins

A localized global set should reference the origin. In the example above, the french set originates from the english, so the `sport` variable will be inherited.

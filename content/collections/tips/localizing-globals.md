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

When using [multiple sites](/multi-site), you'll need to specify in the Control Panel which sites this global set can be used in.

![/img/globals-site-config.png](/img/globals-site-config.png)


## Localizable fields

In a [Blueprint](/blueprints), you can define which fields are localizable.

While editing a localized global set, only the localizable fields will be editable. The non-localizable fields will be read-only.


## Origins

A localized global set should reference the origin. In the example above, the french set originates from the english, so the `sport` variable will be inherited.

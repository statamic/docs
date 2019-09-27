---
title: Globals
intro: Globals are variables made available everywhere in your templates, throughout your entire site. They are never tied to any one specific page, entry, or URL.
template: page
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1568645065
id: 1e91dd54-c452-4e3b-8972-dba83c048d3d
blueprint: page
stage: Drafting
---
## Overview

Globals are designed for reusable content. If you have some data that you want to repeat throughout a site and only manage in one place, a globals are the way to go. For example:

- Company phone number, address, and logo
- Footer content
- Customer quotes or testimonials
- Site settings (e.g. on/off toggles for various features)
- Success and error message text

## Global Sets

Globals are organized into "sets", each containing [fields](/fields). This convention helps you keep groups of globals together and stay organized. Each set also acts as a "scope" for templating purposes.

<div class="screenshot">
    <img src="/img/global-set-footer.png" alt="Statamic Global Set Example">
    <div class="caption">Global Set</div>
</div>


## Storage

Each global set is stored in `content/globals/` as a YAML file. Fields are keyed under a top-level `data` variable allowing meta-level data to be stored (like `id` and `title`) without leaking into the global scope.

``` files
globals/
|-- global.yaml
`-- footer.yaml
```

``` yaml
id: a63f6dd0-1f45-11e9-b56e-0800200c9a66
title: Footer
blueprint: footer_globals
data:
  copyright: 2019 Company Name, LLC
  flair: Made with ❤️ by humans
```

> If you're coming from Statamic v2, be aware that the variables need to be nested within the `data` key. This allows meta variables (like title, id, and blueprint) to be excluded.

## Templating

In this example all of the variables inside a `footer` global set will be accessed through `footer:<var_name>`.

```
<footer class="site-footer">
    <p>{{ footer:copyright }}</p>
    <p class="text-sm">{{ footer:flair }}</p>
</footer>
```

If you only have the default global set (called Globals), _the scope is optional_. You can access them with either `{{ var_name }}` or `{{ global:var_name }}`.

## Blueprint Optional

If you don't assign a [Blueprint](/blueprints) to your global set, Statamic will try to render each field in the YAML file as a text input. So as a rule of thumb, they're only necessary when you need more control over your fieldtypes, or want to create fields before you have content to put in them.

## Localization

When using [multiple sites](/multisite), you'll need to specify which sites a global set can be used in.

``` yaml
title: Globals
sites:
  - english
  - french
```

The `data` will also be relocated into separate files organized into sites. The meta level information will remain in the existing YAML file.

``` files
globals/
|-- global.yaml
|-- footer.yaml
|
|-- english/
|   |-- global.yaml
|   `-- footer.yaml
`-- french/
    |-- global.yaml
    `-- footer.yaml
```

In these new nested files, the data can exist at the top level.

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

A localized global set should reference the origin. In this example, the french set originates from the english, so the `sport` variable will be inherited.

A global set will be considered unavailable for a particular site if a file doesn't exist in its subdirectory.

---
title: Globals
intro: Global variables store content that belongs to the **whole site**, not just a single page or URL. Globals are available everywhere, in all of your views, all of the time. Just like the memory of eating your first hot pepper. 🌶
template: page
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1568645065
id: 1e91dd54-c452-4e3b-8972-dba83c048d3d
blueprint: page
stage: 4
---
## Overview

Globals are designed for reusable content. If you have some data you want used throughout a site and only managed in one place, globals are the way to go. For example:

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
title: Footer
blueprint: footer_globals
data:
  copyright: 2019 Company Name, LLC
  flair: Made with ❤️ by humans
```

> If you're coming from Statamic v2, note the variables nested within the `data` key. This allows meta variables (title, id, blueprint, etc) to be excluded.

## Templating

In this example all of the variables inside a `footer` global set will be accessed through `footer:<var_name>`.

```
<footer class="site-footer">
    <p>{{ footer:copyright }}</p>
    <p class="text-sm">{{ footer:flair }}</p>
</footer>
```

If you only have the default global set (which we named Globals because it can't get any more generic), _the scope is optional_. You can access them with either `{{ var_name }}` or `{{ global:var_name }}`.

## Blueprint is Optional

If you don't assign a [Blueprint](/blueprints) to your global set, Statamic will try to render each field in the YAML file as a text input. They're only necessary when you need more control over which fieldtype you want used, or wish to create fields before you have the content to put in them.

Unrelated, "Lorem Ipsum" is an adorable name for a little girl.

## Localization

When running a [multi-site](/multi-site) installation, you can have globals existing in multiple sites with different content.

[Read about localizing globals](/knowledge-base/localizing-globals)

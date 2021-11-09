---
title: Views
intro: Views contain HTML, have access to your data, and are used to render the front-end of your site. Layouts, templates, and partials are all different types of views.
template: page
blueprint: page
id: 74c47654-8c47-49b1-a616-ed940ce19977
---
## Overview
Views contain the HTML served by the frontend of your site and are stored in the `resources/views` directory. A simple view might look something like this (but should it?):

```
// resources/views/greeting.antlers.html

<html>
  <body>
    <p>The invention of the shovel was ground breaking.</p>
  </body>
</html>
```

Each file inside your `resources/views` directory is a **view**. Each view can be used in different ways — given different roles and responsibilities.

:::watch https://www.youtube.com/embed/leI3qRhzHLQ
See how layouts and templates work together.
:::

## Layouts

**Layouts** are the the foundation of your frontend's HTML. Any markup you want to present no matter what page you're on, no matter where you go, how far you travel, or loud you sing, should go into a layout.

By default, Statamic will look for and use `/resources/views/layout.antlers.html`, but you're welcome to create other layouts and configure specific entries, whole sections, or the whole site to use those instead.

Layouts usually contain `<head></head>` markup, global header, navigation, footer, JavaScript includes, and so on. In between all that HTML is your _template_ area — the magical place where unique, non-global things happen. Use the `{{ template_content }}` variable to set where you'd like that live.

```
// resources/views/layout.antlers.html
<html>
  <head>
    <title>{{ title }} | {{ site_name }}</title>
    <link rel="stylesheet" href="/css/tailwind.css">
  </head>
  <body>
    {{ partial:nav }}
    {{ template_content }}
    <footer>
      &copy; {{ now format="Y" }} {{ site_name }}
    </footer>
    <script src="/js/site.js"></script>
  </body>
</html>
```

An entry can control the layout its rendered with by setting the `layout` system variable.

``` yaml
# Use /resources/views/rss.antlers.html
layout: rss
```

## Templates

Templates are views that can be used by any entry or section on your site. The template's contents will be inserted into the `{{ template_content }}` variable in your layout much like the way a painting goes into an ornate picture frame.

An entry can control the template it's rendered with by setting the `template` system variable.

``` yaml
# This fake entry will use /resources/views/gallery.antlers.html
template: gallery
title: Photo Gallery
```

:::tip
You can use the [template](/fieldtypes/template) fieldtype to make choosing your template in any entry easy. Any [fieldtype](/fieldtypes) that returns a string like in the example above works too, so you have a lot of flexibility.
:::

### Inferring templates from entry blueprints

If you would like to automatically infer collection entry templates from entry blueprints, you can set your collection's default template to `@blueprint`.

``` yaml
# This would go in your collection's yaml config
template: '@blueprint'
```

By doing this, Statamic will look for the corresponding template in `/resources/views/{collection}/{blueprint}.antlers.html`.

For example, if you have an `articles` collection entry that uses a blueprint with the handle of `long`, the `/resources/views/articles/long.antlers.html` template will be used.

Given that this just sets the collection's _default_ entry template, you can still override a template at the entry level as well.

## Partials

Partials are reusable views that may find themselves in any number of other layouts, templates, and other partials. You can use any view as a partial by using the [partial](/tags/partial) tag.

```
// This will import /resources/views/blog/_card.antlers.html
{{ partial:blog/card }}
```

:::best-practice
We recommend prefixing any views intended to be _only_ used as partials with an underscore, `_like-this.antlers.html` and reference them `{{ partial:like-this }}. The underscore is not necessary in the partial tag definition.
:::

:::watch https://www.youtube.com/embed/Ddz6mD-jT7E
We have a video about Partials too!
:::

## Using Blade

If your view ends with `.blade.php` instead of `.antlers.html`, it will be rendered with Laravel's [Blade](https://laravel.com/docs/blade) engine. All of the same data will be injected into the view, but you won't have access to Statamic's [tags](/tags).

This is useful if...

- You want to reuse existing Laravel views and keep your markup DRY.
- You have some gnarly loops to work with and can benefit from temporary variables and the `foreach` loop approach.
- You're really used to using Blade and don't want to learn anything else even if it's really simple, similar, and powerful. You do you.


## Recommended Conventions

We recommend the following conventions for consistency. These are just suggestions, not requirements.

### Naming

- Use lowercase filenames
- Use hyphens to separate words
- Prefix partials with _underscores
- Be consistent with plurality (e.g. blog, <strike>articles</strike>, faq)

### Organizing

There are a few recommended ways to organize your layouts, templates, and partials. But you don't have to take _our_ word for it. 🌈

### Go Super Flat

Partials are indicated by a prefixed underscore (`_header`), layout by the word `layout` and everything else is a template. **Best for small sites.**

``` files theme:serendipity-light
resources/views/
  _header.antlers.html
  about.antlers.html
  article.antlers.html
  layout.antlers.html
  listing.antlers.html
  page.antlers.html
```

### Organize by Type

This is a bit more of a Statamic v2 style where views are grouped by type - partials, layouts, and templates. **Best for medium sized sites.**

``` files theme:serendipity-light
resources/views/
  partials/
    _card.antlers.html
    _footer.antlers.html
    _nav.antlers.html
  layouts/
    amp.antlers.html
    api.antlers.html
    main.antlers.html
  templates/
    about.antlers.html
    article-list.antlers.html
    article-show.antlers.html
    faq-list.antlers.html
    faq-show.antlers.html
    form.antlers.html
```

### Organize by Section

A more Laravel/application approach where views are grouped by section (or collection), along with their own partials and alternate layout files. **Best for large sites.**

``` files theme:serendipity-light
resources/views/
  blog/
    _card.antlers.html
    index.antlers.html
    layout.antlers.html
    rss.antlers.html
    show.antlers.html
  contact/
    index.antlers.html
    success.antlers.html
  faq/
    layout.antlers.html
    index.antlers.html
    show.antlers.html
  layout.antlers.html
```

## Additional Reading

- If you want to learn more about how data gets into your view, check out [The Cascade](/cascade)
- If you'd like to manipulate your data _before_ it arrives in your view, check out [View Models](/view-models).
- If you want to use a third-party template engine (like Twig), check out [Other Template Engines](/template-engines).
- If you want to fetch data from Laravel or do other more programmery-things, you'll want to do that from a [Controller](/controllers).

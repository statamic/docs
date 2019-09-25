---
title: 'Collections & Entries'
intro: Entries are the primary element that holds your content. Entries are grouped into Collections and can be used in many different and powerful ways for a multitude of purposes. A collection may contain entries that represent blog posts, products, recipes, or perhaps even roadside oddities.
template: page
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1568644358
blueprint: page
id: 7202c698-942a-4dc0-b006-b982784efb03
---
## Entries

Each entry has — at the very least — a title, a published status, an id, and some content. The content fields are determined by one or more [blueprints](/blueprints) set on the collection. By default they're stored as Markdown files inside their collection's respective directory (`content/collections/<collection>/entry.md`).

Let's pretend it's the summer of '99. Here's an entry we might be writing if we were covering the X-Games.

<figure>
    <img src="/img/entry-tony-hawk.png" alt="An entry being edited in the Statamic 3 control panel">
    <figcaption>Entry publishing with only the default content fields.</figcaption>
</figure>

And here's what the Markdown file would look like for the very same entry.

``` markdown
<!-- content/collections/blog/1999-07-27.tony-hawks-900.md -->
---
title: Tony Hawk lands the first-ever 900
published: true
id: 3a28f050-f8d2-4a56-ba8a-314a9d46bf38
---
It took skateboarding legend Tony Hawk 11 tries, but he finally landed a 900 at the 1999 Summer X Games in a moment that launched the sport into popular consciousness in a new way.
```

You can create, edit, and delete entries in the control panel _or_ filesystem, it's up to you and what you prefer in the moment.

## Collections

Collections are the containers that hold entries. You can think of them like shoeboxes containing love letters, except they're folders on your server and they're holding text documents. So not really the same thing. Not nearly as romantic anyway.

The collection holds settings that affect all the of entries. It's also responsible for the URL patterns by way of [routes](/routing), which fields are available with [blueprints](/blueprints), as well as any desired [behaviors](#behaviors).

You can also set default values for all entries, including default template, blueprint, and publish status.

A collection is defined by way of a YAML file in the `content/collections` directory. All accompanying entries will be in a sibling with the same directory name. For example, a `blog` collection would look like this:

``` files
├── content/collections/
│   ├── blog.yaml
│   ├── blog/
│   │   ├── hello.md
│   │   ├── is-it-me.md
│   │   ├── youre-looking-for.md
```

## Blueprints

Each Collection needs at least one Blueprint to define the available fields when creating and editing entries.

You **can** set more than one blueprint. If you do, you'll be given the option to choose from them when creating entries.

## Dates

Very often — but not always — entries require a publish date. There are three types of pre-configured date behaviors you can choose from when creating your collection.

- **Articles** - Where publish dates set into the future are private so you can schedule them.
- **Events** - Where publish dates set in the past are private so they automatically expire and remove themself from your front-end.
- **No dates** - Where there are no publish dates. Logically.

These behaviors apply when listing entries with a [collection](/tags/collection) tag as well as each entry's URL.

### Date Behaviors Setting

You can take this a step further in the collection's YAML file. Consider this the "advanced mode".

``` yaml
date_behaviors:
  past: public|private|unlisted
  future: private|private|unlisted
```

- **public** - Entries will be visible in listings and at their own URLs.
- **unlisted** - Entries will be hidden in listings but available at their own URLs.
- **private** - Entries will be hidden in listings, and their own URLs will 404.

### Expirable

If you set an `expires_at` date field, entries will disappear from listings and trigger 404s after that date and time.

> Date behaviors are _defaults_. They can be overridden on the tag level.

## Ordering

Collections can be manually orderable. If you make a dated collection orderable, the manual order will be the default. You can still sort by date with the sort parameter `sort="date"`.

<figure>
    <img src="/img/reorderable-entries.png" alt="A list of reorderable entries">
    <figcaption>Here we see drag & drop entry ordering in action.</figcaption>
</figure>

### Order Settings

A collection's order will be stored in the collection's YAML file.

``` yaml
orderable: true
entry_order:
  - id-of-first-entry
  - id-of-second-entry
```

## Routing

Entries receive their URLs from their collection's route setting. You can use standard meta variables in addition to the variables from the collection's blueprint to define your route rule.

``` yaml
route: /blog/{slug}
```

### Meta variables

| Variable | Available |
|----------|-----------|
| `slug` | always |
| `year` | when in a dated collection |
| `month` | when in a dated collection |
| `day` | when in a dated collection |
| `parent_uri` | when connected to a [structure](/structures) |
| `depth` | when connected to a [structure](/structures) |
| `mount` | when [mounted](#mounting) to an entry |

### Example routes

Here are a few examples of possible route rules for inspiration. 💡

#### Wordpress Style
``` yaml
route: /news/{year}/{month}/{day}/{slug}
# example: /news/2019/01/01/happy-new-year
```

#### For when you don't care about SEO
``` yaml
route: /{id}
# example: /12345-1234-321-12345
```

#### For when you care _too much_ about SEO
``` yaml
route: /{parent_uri}/{slug}.html
# example: /details/project.html
```

## Taxonomies

In Statamic 3, [taxonomies](/taxonomies) are defined on the _collection level_, not the blueprint-level. This enforces a tighter content-model, and reduces complexity when configuring blueprints.

Let's imagine you have a **product** collection. Each entry is a product, and each product _has one or more_ categories. Thus set, no matter what blueprints you configure, each will have a **categories** field in the sidebar. You'll be able to access any categories on your entries with a `{{ categories }}` variable loop.

### Taxonomies Setting

``` yaml
taxonomies:
  - categories
  - tags
```

## Mounting

You may mount a collection onto an entry as a way of saying "all these entries belong to this section". When you do this, two neat things happen:

- The collection will share the URL of the entry.
- If that entry is listed in a structure, you will see shortcut links to **add or edit** entries in that collection.

<figure>
    <img src="/img/mounted-collection.png" alt="Mounted collections in a structure">
    <figcaption>Look at those add and edit links!</figcaption>
</figure>

## Revisions

Revisions allow you to see the history of any given entry over time. Revisions need to be enabled on the site level ([read those docs](/revisions)), and then you can enable them for any collection.

```
revisions: true
```

### Mount Setting

Mount the collection by specify the ID of an entry. You can also use the `mount` variable in the route.

``` yaml
title: Blog
mount: id-of-the-blog-entry
route: '{mount}/{slug}'
```

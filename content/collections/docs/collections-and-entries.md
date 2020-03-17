---
title: 'Collections & Entries'
intro: Entries are the primary element that holds your content. Entries are grouped into Collections and can be used in many different and powerful ways for a multitude of purposes. A collection may contain entries that represent blog posts, products, recipes, or perhaps even roadside oddities.
template: page
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1568644358
blueprint: page
stage: 1
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

### Data Cascade

Entries have their own unique URLs — when you're on them, all of that entry's variables will be available in your views. If an entry is missing a variable, it will fall back to a series of defaults. We call this the cascade.

1. The entry
2. The origin entry (if using localization)
3. The collection

If a value doesn't exist in one place, it'll check the next, and so on.

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

Injecting data into your collection is a handy way of providing default values to your entries. You can do that with the `inject` variable. If entries have these variables set, they will override the collection defaults.

``` yaml
inject:
  author: jason
  show_sidebar: true
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
  future: public|private|unlisted
```

- **public** - Entries will be visible in listings and at their own URLs.
- **unlisted** - Entries will be hidden in listings but available at their own URLs.
- **private** - Entries will be hidden in listings, and their own URLs will 404.

### Expirable

If you set an `expires_at` date field, entries will disappear from listings and trigger 404s after that date and time.

> Date behaviors are _defaults_. They can be overridden on the tag level.

## Ordering

Entries in a collection may be manually ordered by giving it a [Structure](#structure).

If you're using the Control Panel, you can just flick the "Orderable" switch on the Collection's settings page. Statamic will connect
the dots for you.

If you're digging through files, you can add a `structure` to the Collection's YAML file.

> Order will take precedence when sorting. eg. If you make a dated collection orderable, the manual order will be the default. You can still sort by date with the sort parameter `sort="date"`.

<figure>
    <img src="/img/reorderable-entries.png" alt="A list of reorderable entries">
    <figcaption>Here we see drag & drop entry ordering in action.</figcaption>
</figure>

## Structure

An entry with an associated [Structure](/structures) will be how you make its entries "orderable", as well as defining its URL structure.

The structure's tree will dictate how its entries' URLs are generated. If you plan to [allow nesting](#constraining-depth), make sure you include the `parent_uri` in the [route](#routing).

``` yaml
structure:
  tree:
    -
      entry: id-of-first-entry    
      children:
        -
          entry: id-of-child-entry
    -
      entry: id-of-second-entry    
```

Any entries not found in the tree will be assumed to be at the top level.

### Constraining Depth

By default, the structure will **not** have a maximum depth. You can nest entries as deep as you like. 
If you want only allow a certain number of levels, you may set the `max_depth` on the structure:

``` yaml
structure:
  max_depth: 3
  tree: [...]
```

> Setting `max_depth: 1` will replace the page tree UI with a more linear table-based UI.

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
| `parent_uri` | when in an [orderable](#ordering) collection and max_depth > 1 |
| `depth` | when in an [orderable](#ordering) collection and max_depth > 1 |
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

#### Organizing sports brackets with structures
``` yaml
route: /tournament/round-{depth}/{team}
# example: /tournament/round-4/chicago-bulls
```

## Redirects

Adding a `redirect` variable to one of your entries will cause an HTTP redirect when visiting its URL.

``` yaml
---
id: page-book-tickets
title: Book Ticket
redirect: http://booking.mysite.com
```

A particularly useful example of when you might want to do this is if you need an external link in your nav but creating a completely separate nav would be overkill.

The following redirects are supported:
- external links (starting with `http`)
- internal links (starting with `/`)
- other entries or terms (eg. `entry::id-of-entry` or `term::id-of-term`)
- it's first child page (`@child`) - If there are no child pages you will get a 404
- a `404` response

Any other strings will be assumed to be a relative link. (eg. if the page URL is `/my/page` and you have `redirect: is/here`, you will be redirected to `/my/page/is/here`)

### Entry Link Blueprint

When a Collection is structured, you will be presented with the option to create "Links" along with any other available blueprints when you try to create an entry.

This will load a behind-the-scenes blueprint containing `title` and `redirect` fields. You are free to modify what's shown on these pages by creating your own `entry_link` blueprint.

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

### Mount Setting

You can mount a collection to an entry by specifying the ID of said entry. You can also use the `mount` variable in the route to prepend the mounted entry's URL.

So for example, if you mounted a collection to `/blog` with `/{mount}/{slug}`, all your blog URLs will follow the `/blog/entry-url` pattern. If you later move `/blog` to `/articles`, all your entries will follow along with `/articles/entry-url`.

``` yaml
title: Blog
mount: id-of-the-blog-entry
route: '{mount}/{slug}'
```

## Revisions

Revisions allow you to see the history of any given entry over time. Revisions need to be enabled on the site level ([read those docs](/revisions)), and then you can enable them for any collection.

```
revisions: true
```

## Localization

When running a [multi-site](/multi-site) installation, you can have entries that exist in multiple sites with different content,
or have entries exclusive to a site.

[Read about localizing entries](/knowledge-base/localizing-entries)

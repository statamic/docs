---
id: db244b81-13ad-42f1-b593-533c6e165ee6
title: 'Upgrade from 3.1 to 3.2'
intro: 'A guide for upgrading from 3.1 to 3.2'
template: page
blueprint: page
---
First read through this guide to see if there's anything that you might need to adjust.
When upgrading, Statamic may automate some things for you. They'll be noted below.

In your `composer.json`, change the `statamic/cms` requirement:

```json
"statamic/cms": "3.2.*"
```

Then run:

```bash
composer update statamic/cms --with-dependencies
```

---

### Medium impact changes
- [Nav Page IDs](#nav-page-ids)

---

## Nav Page IDs

In a **Navigation**, each branch now has its own automatically generated ID.  
(This doesn't apply to collection trees.)

In 3.1:

``` yaml
-
  url: /some-manually-added-link
-
  entry: some-entry-id
```

In 3.2:

``` yaml
-
  id: abc-def
  url: /some-manually-added-link
-
  id: ghi-jkl
  entry: some-entry-id
```

In 3.1, if you were using a `nav` tag, the `{{ id }}` variable would be the ID of the entry for entry branches and `null` for non-entry branches.

In 3.2, the `{{ id }}` will be the ID of the branch.
To get the ID of the entry, you can use `{{ entry_id }}`.

If you had this in 3.1:
```
{{ nav:links }} ... {{ id }} ... {{ /nav:links }}
```

Change to this for 3.2:
```
{{ nav:links }} ... {{ entry_id }} ... {{ /nav:links }}
```

> If you're using the `nav` tag to output a _collection's_ tree (e.g. your `pages` collection), the `id` will still be the entry ID.

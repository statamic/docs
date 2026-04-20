---
id: de1fb94c-a0e5-43a9-8971-e9b839e373e8
blueprint: modifiers
title: Resolve
modifier_types:
  - array
  - utility
  - relationship
---
Resolves a query builder and returns either a specific item by key/index or the full array of results. Also works on arrays and collections.

Handy for grabbing a single item out of a relationship field (like the first asset from an asset field) without having to loop.

```yaml
gallery:
  - hero.jpg
  - action-shot.jpg
  - outtake.jpg
```

::tabs

::tab antlers
```antlers
<img src="{{ gallery | resolve(0):url }}" />
```
::tab blade
```blade
<img src="{{ Statamic::modify($gallery)->resolve(0)->fetch()['url'] }}" />
```
::

```html
<img src="/assets/hero.jpg" />
```

## Without a key

Omit the key to resolve the query builder into an array of all items. Useful when you want to pass the resolved data into another modifier.

::tabs

::tab antlers
```antlers
{{ gallery | resolve | count }}
```
::tab blade
```blade
{{ Statamic::modify($gallery)->resolve()->count() }}
```
::

```html
3
```

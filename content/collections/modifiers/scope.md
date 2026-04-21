---
id: 4944d222-cc5b-451c-8ff9-17688de7764c
blueprint: modifiers
title: Scope
modifier_types:
  - array
  - utility
---
Adds a named scope prefix to each item in an array or collection, letting you access variables with that prefix to avoid collisions with the parent context.

This is the modifier equivalent of the [`scope` parameter](/tags/collection#scope) on the Collection tag, but usable on any array — like the results of a [`taxonomy`](/tags/taxonomy) tag, a [Replicator](/fieldtypes/replicator) field, or any custom array of entries.

```yaml
title: My Favorite Posts
posts:
  - title: Bear Hibernation Tips
    slug: bear-hibernation
  - title: Cactus Cuddles
    slug: cactus-cuddles
```

Without scoping, `{{ title }}` inside the loop falls back to the page's `title`. Prefix the variables with a scope to get exactly what you want.

::tabs

::tab antlers
```antlers
{{ posts | scope('post') }}
  <a href="/{{ post:slug }}">{{ post:title }}</a>
{{ /posts }}
```
::tab blade
```blade
@foreach (Statamic::modify($posts)->scope('post')->fetch() as $item)
  <a href="/{{ $item['post']['slug'] }}">{{ $item['post']['title'] }}</a>
@endforeach
```
::

```html
<a href="/bear-hibernation">Bear Hibernation Tips</a>
<a href="/cactus-cuddles">Cactus Cuddles</a>
```

The original (unprefixed) variables are still available inside the loop — the scope is added alongside them, not as a replacement.

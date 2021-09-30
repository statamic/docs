---
id: eb68e4e1-c1b2-4806-a477-6c0491616b88
blueprint: modifiers
modifier_types:
  - asset
  - string
  - relationship
title: Url
---
Get the URL of an Asset, Page, Entry, or Taxonomy term from an ID.

```yaml
hero_image: 98hf98-sfq4h8f94-fd9s0fj0l
```

```
{{ hero_image | url }}
```

```html
/assets/flying-bacon-wearing-a-batman-mask.jpg
```

:::tip
If your field is defined in a [Blueprint](/blueprints), Statamic would have already used [augmentation](/augmentation) to convert the ID to an object. You can access the URL like so:

```
{{ hero_image:url }}
```
:::

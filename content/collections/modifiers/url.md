---
id: eb68e4e1-c1b2-4806-a477-6c0491616b88
modifier_types:
  - asset
  - string
  - relationship
---
Get the URL of an Asset, Page, Entry, or Taxonomy term from an ID.

```.language-yaml
hero_image: 98hf98-sfq4h8f94-fd9s0fj0l
```

```
{{ hero_image | url }}
```

```.language-output
/assets/flying-bacon-wearing-a-batman-mask.jpg
```

> If your field is defined in a [Blueprint](/blueprints), Statamic would have already
> used [augmentation](/augmentation) to convert the ID to an object. You can access 
> the URL using array access.
> ```
> {{ hero_image:url }}
> ```

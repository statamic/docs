---
id: d887ae27-c075-42fa-9925-bb89d58015cd
blueprint: seo_pro
title: 'File Usage'
---
For advanced devs, you may bypass the CP and configure your SEO settings through files. There are 3 sorts of values you may save.

## Custom Hardcoded Strings

```yaml
title: "A hardcoded string"
```

## Field References

Prefix a field name with `@seo:` to have that field's value referenced automatically.

A field in a specific fieldset may be specified (this is how the CP will save them). The fieldset is completely optional and currently provides no additional benefit.

```yaml
title: "@seo:title"
title: "@seo:post/title"  # with optional fieldset
```

## Antlers Templating

You may use Statamic Antlers templating in your strings. When doing this, the addon will not apply any automatic parsing rules (limiting the length of the description, for example).

```yaml
description: "{{ content | strip_tags | truncate(250, '...') }}"
```
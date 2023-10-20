---
id: ada24ec2-1b6e-4759-b2c0-06d9d464f3f9
blueprint: modifiers
modifier_types:
  - array
  - utility
title: As
---
Alias an array variable as another name, allowing you to massage your data to reused shared components and templates.

```yaml
blocks:
  -
    type: text
    content: I love to eat tacos in the bathroom.
  -
    type: photo
    photo: /assets/img/baño-tacos.jpg
```

```
{{ blocks as="sets" }}
    {{ sets }}
        {{ partial:type }}
    {{ /sets }}
{{ /blocks }}
```

```html
<!-- Each block would be rendered with its own partial matching the {{ type }} var -->

<div class="text">
  <p>I like to eat tacos in the bathroom.</p>
</div>
<div class="photo">
  <img src="/assets/img/baño-tacos.jpg">
</div>
```

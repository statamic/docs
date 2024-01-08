---
id: 2d555b32-e68c-4f9b-8570-f2e8d185989b
blueprint: modifiers
modifier_types:
  - markup
  - string
  - utility
title: Headline
---
Format the given string (usually a headline) with either AP or MLA style.

```yaml
title: I see a bad-ass mother who don't take no crap off of nobody.
```

```antlers
{{ title | headline }}
```

```
I See a Bad-Ass Mother Who Don't Take No Crap Off of Nobody.
```

```antlers
{{ title | headline('mla') }}
```

```
I See a Bad-ass Mother Who Don't Take No Crap Off of Nobody.
```

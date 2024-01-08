---
id: 2d555b32-e68c-4f9b-8570-f2e8d185989b
blueprint: modifiers
modifier_types:
  - markup
  - string
  - utility
title: Headline
---
Format the given string, usually a headline or title, with either [AP](https://apastyle.apa.org/style-grammar-guidelines/capitalization/title-case) or [MLA](https://style.mla.org/capitalization-of-titles/) style.

Accepts `ap` or `mla` as an argument. Defaults to `ap` if none is specified.

```yaml
title: I see a bad-ass mother who don't take no crap off of nobody.
```

```antlers
{{ title | headline('ap') }}
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

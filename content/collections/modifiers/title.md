---
id: 2293d024-32ad-4bb6-a7ff-46ec2e1d9f2f
blueprint: modifiers
modifier_types:
  - string
title: Title
---
Returns a trimmed string with the first letter of each word capitalized, ignoring articles, coordinating conjunctions, and short propositions: `a`, `an`, `the`, `at`, `by`, `for`, `in`, `of`, `on`, `to`, `up`, `and`, `as`, `but`, `or`, and `nor`.

```yaml
string: It was one of the best adventures of my life
```

```
{{ string | title }}
```

```html
It Was One of the Best Adventures of My Life
```

You can also pass optional parameters to the modifier for strings that should be ignored, like abbriviations.

```yaml
string: Open your first PR to Statamic CMS
```

```
{{ string | title:PR:CMS }}
```

Without passing those parameters, the output would be `Open Your First Pr to Statamic Cms` instead of `Open Your First PR to Statamic CMS`.

---
id: f874e969-d579-4501-9140-e4005945d302
blueprint: modifiers
modifier_types:
  - array
title: Flip
---
Swaps the keys with their corresponding values. The old switcharoo.

```.language-yaml
favorites:
  chicken: nuggets
  nuggets: Denver
```

```
{{ favorites }}
  My favorite {{ key }} is {{ value }}.
{{ /favorites }}

{{ favorites | flip }}
  My favorite {{ key }} is {{ value }}.
{{ /favorites }}
```

```.language-output
My favorite chicken is nuggets.
My favorite nuggets is Denver

My favorite nuggets is chicken
My favorite Denver is nuggets.
```

It's a weird example with bad grammer. Hopefully you're okay with it.

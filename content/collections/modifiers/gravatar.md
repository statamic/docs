---
id: c0a376c1-1ade-447b-8a2d-18722a5446ba
blueprint: modifiers
modifier_types:
  - string
  - utility
title: Gravatar
---
Converts an email string to a Gravatar image URL. The size can be specified by a parameter.

```yaml
email: rswanson@inpra.org
```

```
{{ email | gravatar }}
{{ email | gravatar(80) }}
```

```html
https://www.gravatar.com/avatar/f4650388367dc01cf2acf16b412b3966
https://www.gravatar.com/avatar/f4650388367dc01cf2acf16b412b3966?s=80
```

---
modifier_types:
  - markup
attributes: true
id: 65bcc454-2731-4f83-97cf-03659fb38db5
---
Generate a `mailto` link element with the value as the email address. If it's _not_ an email address, it's going to be one busted link.

```.language-yaml
holler: holler@example.com
```

```
{{ holler | mailto }}
```

```.language-output
<a href="mailto:holler@example.com">holler@example.com</a>
```

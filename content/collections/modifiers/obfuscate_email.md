---
id: 536ac4b3-bfc7-4ced-8c83-d389fb94a262
blueprint: modifiers
modifier_types:
  - markup
attributes: true
title: 'Obfuscate Email'
---
Obfuscates an email address with special characters making it hard for spam bots to sniff out and scrape off your site. Still reads like an email address as far as readers are concerned.

```.language-yaml
holler: holler@example.com
```

```
{{ holler | obfuscate_email }}
```

```.language-output
# output appears as holler@example.com
&#104;o&#108;le&#x72;&#x40;&#x65;&#x78;&#x61;&#109;&#x70;&#108;&#101;&#x2e;&#x63;&#x6f;m
```

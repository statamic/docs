---
id: 84aca464-65b1-4cc9-8bc9-e64b33797579
blueprint: modifiers
modifier_types:
  - markup
  - utility
attributes: true
title: Obfuscate
---
Obfuscates a string with special characters making it hard for spam bots to sniff out and scrape off your site. Still appears like the same string to the reader. This is usually used for email addresses.

```yaml
magic_word: Abracadabra
```

```
{{ magic_word | obfuscate }}
```

```html
# visibly appears as Abracadabra
A&#98;r&#97;&#99;&#x61;d&#97;&#98;&#114;&#97;
```

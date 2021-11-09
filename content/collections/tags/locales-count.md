---
id: 5442a3d6-db7b-41d3-8ab2-2514f8a11eff
blueprint: tag
title: 'Locales:Count'
intro: 'Get the number of localizations.'
---
This tag shares everything from the [locales tag](/tags/locales), except that instead of looping over the results, it will just tell you how many there are.

```
{{ locales:count }}
{{ locales:count self="false" }}
```

```output
3
2
```

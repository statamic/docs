---
types:
  - global
id: 5b84efbc-59d9-48af-9905-90b461c3c44f
---
The site's full locale value as defined in your `system.yaml`'s `locales` array.

``` .language-yaml
locales:
  en:
    name: English
    full: en_US
    url: http://mysite.com/
```

```
{{ locale_full }}
```

``` .language-output
en_US
```

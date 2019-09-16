---
types:
  - global
id: ccf276e6-34a9-4be2-ba0a-911f5e577eff
---
The site's locale url as defined in your `system.yaml`'s `locales` array.

``` .language-yaml
locales:
  en:
    name: English
    full: en_US
    url: http://mysite.com/
```

```
{{ locale_url }}
```

``` .language-output
http://mysite.com/
```

---
id: 8426c6e0-6641-11e6-bdf4-0800200c9a66
types:
  - system
---
Outputs the current environment.

This will be the value of `APP_ENV` in your `.env` file. If you haven't set that, then it will output the default of `production`.

```
{{ environment }}
```

``` .language-output
production
```

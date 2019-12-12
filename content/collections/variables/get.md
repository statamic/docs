---
id: 546c4334-df40-4e9a-aff4-a56c43e839d8
types:
  - system
---
An array of `GET` variables that come from any query strings present in the current URL. It can be used as a tag pair with access to all your parameters or as a single tag to access parameters directly. A counterpart to `{{ post }}`.


Example URL: `/about?show=pants&hide=jeggings`

```
{{ get:show }}

{{ get }}
  {{ show }}
  {{ hide }}
{{ /get }}

```

``` .language-output
pants

pants
jeggings
```

Be sure to escape these values with the `sanitize` modifier if you plan to use them in output in production.

```
<!-- Because let's face it. You really *should* sanitize your jeggings. -->
{{ get:jeggings | sanitize }}
```

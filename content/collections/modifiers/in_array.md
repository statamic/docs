---
id: 4e349523-cba6-4f3b-a0e1-bd4e8b1cf6b9
blueprint: modifiers
modifier_types:
  - array
  - utility
  - conditions
title: 'In Array'
---
Check if an array contains a specific value. Returns `true` if a match is found.

The first parameter is the "needle" to find in the "haystack". It will read from the context if there is a matching variable, otherwise it will use the parameter as the value. You can pass multiple arguments.

```yaml
shopping_list:
  - eggs
  - flour
  - beef jerky
want: eggs
```

```
{{ if (shopping_list | in_array:flour) }} GOT IT! {{ /if }}
{{ if (shopping_list | in_array:want) }} GOT EM! {{ /if }}
{{ if (shopping_list | in_array:eggs:flour) }} YES I DID NOT FORGET! {{ /if }}
```


```html
GOT IT!
GOT EM!
YES I DID NOT FORGET!
```

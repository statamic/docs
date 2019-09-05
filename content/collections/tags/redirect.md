---
title: Redirect
overview: Redirect to another page.
parameters:
  -
    name: url
    type: string
    description: Destination URL
  -
    name: to
    type: string
    description: Alias of `url`
  -
    name: response
    type: 'integer *302*'
    description: The HTTP response code to use.
id: 444d1109-ed96-4162-b86d-24b39f569220
---
## Example {#example}

```
{{ if !open }}
  {{ redirect to="/" }}
{{ /if }}
```

If the `open` tag is not true, this will forward the visitors to the homepage.

---
title: Redirect
description: Redirects visitor to another URL
intro: |
  Anytime this tag is rendered — whether in a template, partial, or content, Statamic will redirect the visitor to the specified URL.
stage: 4
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
    type: integer
    description: 'The HTTP response code to use. Default: `302` (permanent).'
id: 444d1109-ed96-4162-b86d-24b39f569220
---
## Examples

Let's redirect visitors to the homepage if they're not logged in.
```
{{ if ! logged_in }}
  {{ redirect to="/" }}
{{ /if }}
```

How about RickRolling visitors if it's April Fool's Day?
```
{{ if (now|format:m-d) == "04-01" }}
  {{ redirect to="https://www.youtube.com/watch?v=dQw4w9WgXcQ" }}
{{ /if }}
```

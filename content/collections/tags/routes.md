---
title: Routes
description: Accesses data defined in frontend routes
intro: The routes tag gives you access to your frontend routes and access any data set inline.
stage: 4
variables:
  -
    name: url
    type: string
    description: "The route's defined URL"
  -
    name: permalink
    type: string
    description: "The route's fully qualified URL"
  -
    name: template
    type: string
    description: The specified template
  -
    name: \*
    type: mixed
    description: All other defined variables
id: ad1b968e-9069-4977-a8ba-b12fe7885ebe
---
## Overview
This tag can save you from having to hardcode links to your [frontend routes](/routes) and gives you access to any inline data you added in your route rules too. These routes are defined in `config/statamic/routes.php`.

## Example

``` php
  'routes' => [
      'search' => [
          'template' => 'search',
          'blueprint' => 'page',
          'title' => 'Search for all the things!'
      ],
      'login' => [
          'template' => 'login',
          'title' => 'Account Login'
      ],
  ],
```

```
{{ routes }}
    <a href="{{ url }}">{{ title }}</a>
{{ /routes }}
```

``` output
<a href="/search">Search for all the things!</a>
<a href="/login">Account Login</a>
```

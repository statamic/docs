---
title: OAuth
overview: Generate OAuth login URLs.
parameters:
  -
    name: provider
    type: string|tagpart
    description: The provider to be used. You may either specify as a parameter or as a tagpart for shorthand. eg. `{{ oauth provider="github" }}` or `{{ oauth:github }}`
  -
    name: redirect
    type: string
    description: The URL to be taken to after authenticating. This will be appending onto the generated URL as a query parameter.
id: f7676fe0-abb3-4a05-8530-6d23a9b5130d
---
## Usage

Regular/verbose syntax. This can be useful if the provider needs to be a variable.

```
{{ oauth provider="github" }}
```

``` .language-output
/oauth/github
```

Shorthand:

```
{{ oauth:github }}
```

``` .language-output
/oauth/github
```

With a redirect parameter:

```
{{ oauth:github redirect="/account" }}
```

``` .language-output
/oauth/github?redirect=/account
```

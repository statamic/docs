---
title: OAuth
description: Generate OAuth login URLs.
intro: If you're using [OAuth](/oauth) to manage user authentication, you may find you need to generate login URLs at some point. Here's how you do it.
stage: 4
parameters:
  -
    name: provider
    type: string|tagpart
    description: |
      The provider to be used. You may either specify as a parameter or as a tagpart for shorthand: `{{ oauth provider="github" }}` or `{{ oauth:github }}`
  -
    name: redirect
    type: string
    description: The URL to be taken to after authenticating. This will be appending onto the generated URL as a query parameter.
id: f7676fe0-abb3-4a05-8530-6d23a9b5130d
---
## Examples

Here's the regular/parameter syntax in action, especially useful if the provider name comes from variable.

```
<a href="{{ oauth provider="github" }}">Sign In with Github</a>
```

```output
<a href="/oauth/github">Sign In with Github</a>
```

And the shorthand version.

```
<a href="{{ oauth:github }}">Sign In with Github</a>
```

``` output
<a href="/oauth/github">Sign In with Github</a>
```

And now with a redirect:

```
<a href="{{ oauth:github redirect="/account" }}>Sign In with Github</a>
```

``` output
<a href="/oauth/github?redirect=/account">Sign In with Github</a>
```

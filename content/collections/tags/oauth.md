---
title: OAuth
description: Generate OAuth login URLs, or loop through the available providers.
intro: If you're using [OAuth](/oauth) to manage user authentication, you may find you need to generate login URLs at some point. Here's how you do it.
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
variables:
  -
    name: name
    type: string
    description: 'The provider''s handle, e.g. `github`.'
  -
    name: label
    type: string
    description: 'The provider''s display label, e.g. `GitHub`.'
  -
    name: connected
    type: boolean
    description: 'Whether the current user has connected this provider to their account. `false` when nobody is logged in.'
  -
    name: url
    type: string
    description: 'The provider''s login URL. Doubles as the "connect" URL when the user is already logged in.'
related_entries:
  - 3dbb14fd-a762-4891-bce1-daf13b8c5981
id: f7676fe0-abb3-4a05-8530-6d23a9b5130d
---
## Generating login URLs

Here's the regular/parameter syntax in action, especially useful if the provider name comes from variable.

::tabs

::tab antlers
```antlers
<a href="{{ oauth provider="github" }}">Sign In with Github</a>
```
::tab blade
```blade
<a href="{{ Statamic::tag('oauth')->provider('github') }}">Sign In with Github</a>
```
::

```output
<a href="/oauth/github">Sign In with Github</a>
```

And the shorthand version.

::tabs

::tab antlers
```antlers
<a href="{{ oauth:github }}">Sign In with Github</a>
```
::tab blade
```blade
<a href="{{ Statamic::tag('oauth:github') }}">Sign In with Github</a>
```
::

```html
<a href="/oauth/github">Sign In with Github</a>
```

And now with a redirect:

::tabs

::tab antlers
```antlers
<a href="{{ oauth:github redirect="/account" }}">Sign In with Github</a>
```
::tab blade
```blade
<a href="{{ Statamic::tag('oauth:github')->redirect('/account') }}">Sign In with Github</a>
```
::

```html
<a href="/oauth/github?redirect=/account">Sign In with Github</a>
```

## Looping through providers

Use `{{ oauth }} ... {{ /oauth }}` as a tag pair to loop through the configured providers. This is useful for building your own [connected-accounts](/oauth#connecting-accounts) UI, since each provider tells you whether the current user has connected it.

Providers configured as [`stateless`](/oauth#providers) are excluded from the loop, since they can't be used for connecting accounts.

::tabs

::tab antlers
```antlers
<ul>
    {{ oauth }}
        <li>
            {{ if connected }}
                {{ oauth:disconnect_form :provider="name" }}
                    <button type="submit">Disconnect {{ label }}</button>
                {{ /oauth:disconnect_form }}
            {{ else }}
                <a href="{{ url }}">Connect {{ label }}</a>
            {{ /if }}
        </li>
    {{ /oauth }}
</ul>
```
::tab blade
```blade
<ul>
    <s:oauth>
        <li>
            @if ($connected)
                <s:oauth:disconnect_form :provider="$name">
                    <button type="submit">Disconnect {{ $label }}</button>
                </s:oauth:disconnect_form>
            @else
                <a href="{{ $url }}">Connect {{ $label }}</a>
            @endif
        </li>
    </s:oauth>
</ul>
```
::

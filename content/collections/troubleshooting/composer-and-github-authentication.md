---
id: cf1794da-3dd2-424d-9274-584c561e837b
blueprint: troubleshooting
title: 'Composer & GitHub Authentication'
intro: 'If you receive a Composer error similar to `Could not authenticate against github.com`, this usually means you are hitting API rate limits.'
template: page
categories:
  - development
  - devops
---
You'll most likely run into this issue when installing a new Statamic site or Starter Kit. It'll look something like this:

```cli
Could not authenticate against github.com
Error installing starter kit [statamic/multisimplicity].
```

Or maybe this:

```cli
- Installing statamic/cms (3.2.1)
Downloading: connection... Failed to download statamic/cms from dist: Could not authenticate against github.com`
Now trying to download from source
```

To get around this, you can [create a personal access token](https://github.com/settings/tokens/new) within a GitHub's user settings. For installing open source projects via Composer, GitHub doesn't need any scopes or permissions, just an authenticated user. This means you can leave every single box unchecked, unless using private repositories.

Once the personal access token is created, you can add the following to the project _before_ running the `composer` command again:

```cli
composer config github-oauth.github.com {your-personal-access-token-here}
```

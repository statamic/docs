---
id: 6067ad07-e86a-4095-9a8e-0df7fa161cc8
blueprint: troubleshooting
title: 'Composer: Classic GitHub Token Forbidden'
intro: 'If you receive a Composer error similar to `could not fetch` … `forbids access via a personal access token (classic)`, you need a fine-grained GitHub token instead.'
template: page
categories:
  - development
  - devops
---
You'll most likely run into this when installing or updating Statamic packages via Composer. It'll look something like this:

```cli
Could not fetch https://api.github.com/repos/statamic/statamic/zipball/341050105099ead5f0c0db39f5f7d2e7f3239012: `statamic` forbids access via a personal access token (classic). Please use a GitHub App, OAuth App, or a personal access token with fine-grained permissions.
```

This usually means Composer is using a **classic** personal access token. Classic tokens can grant access that cannot be fully vetted, so the `statamic` GitHub organization blocks them at the organization level.

Composer uses the token only to avoid GitHub rate limiting, not for any repository features. A token with no permissions is enough — it simply proves you have a GitHub account.

## Fix: use a fine-grained token

1. Check [Tokens (classic)](https://github.com/settings/tokens) — you probably already have a classic token configured for Composer.
2. [Create a fine-grained personal access token](https://github.com/settings/personal-access-tokens) instead.
3. Give it a name like “Composer”, set the expiration to **90 days**, and **don't pick any repositories or permissions** (so let it default to `Public repositories`). It should look something like this:

<figure>
    <img src="/img/tips/composer-fine-grained-github-token.png" alt="Fine-grained GitHub token with no repository access or permissions">
</figure>

<ol style="counter-reset: item 3;">
  <li>Paste the new token into your Composer <code>auth.json</code> where the existing classic token was:</li>
</ol>

```json
{
    "github-oauth": {
        "github.com": "github_pat_123"
    }
}
```

Then run your `composer` command again.

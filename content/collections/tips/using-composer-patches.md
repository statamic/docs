---
id: 3c2c6894-0b47-4281-b798-7fb91fc7c34c
blueprint: tips
title: 'Using Composer Patches'
intro: 'When a bug fix exists in a pull request but hasn''t been released yet, Composer patches let you apply it today instead of waiting.'
template: page
categories:
  - development
  - devops
---
## The problem

Sooner or later you'll hit a bug in an open source package — maybe Statamic itself, maybe an addon, maybe some random dependency five layers deep — that's _already fixed_ in an open pull request. The fix exists. It just hasn't been merged or released yet.

You could wait. Or you could apply the fix right now with a Composer patch and delete it when the release ships.

## Installing composer-patches

The [cweagans/composer-patches](https://github.com/cweagans/composer-patches) plugin applies patch files to your `vendor/` packages every time you run `composer install` or `composer update`.

```shell
composer require cweagans/composer-patches
```

Composer will ask if you want to trust and enable the plugin. Say yes, or add it yourself to the `allow-plugins` section of your `composer.json`:

```json
{
    "config": {
        "allow-plugins": {
            "cweagans/composer-patches": true
        }
    }
}
```

## Getting a patch to apply

The easiest way to get a patch is straight from a pull request on GitHub. Append `.diff` or `.patch` to any PR's URL and GitHub will serve up the raw diff. For example:

```
https://github.com/statamic/cms/pull/1234       <- the pull request
https://github.com/statamic/cms/pull/1234.diff  <- the diff
```

The same trick works for individual commits: `https://github.com/statamic/cms/commit/{sha}.diff`.

Download the file and save it in your project — a `patches/` directory in your project root is a nice convention — and commit it to your repo.

:::warning
You _can_ point a patch directly at the PR's `.diff` URL, but don't. The contents of that URL change whenever someone pushes another commit to the PR, which means your next deploy could pull in code you never reviewed. Download the file, commit it, and reference the local copy.
:::

## Configuring your patch

Inside the `extra` key of your `composer.json`, list your patches by package. The key is a description (write a useful one — future you will thank you), and the value is the path to the patch file:

```json
{
    "extra": {
        "patches": {
            "statamic/cms": {
                "Fix entries losing their minds in multi-site (PR #1234)": "patches/cms-pr-1234.diff"
            }
        }
    }
}
```

Now update the package you're patching:

```shell
composer update statamic/cms --with-dependencies
```

Composer will re-fetch the package and apply your patch to it. You'll see something like this in the output:

```cli
  - Applying patches for statamic/cms
    patches/cms-pr-1234.diff (Fix entries losing their minds in multi-site (PR #1234))
```

From here on out, every `composer install` and `composer update` will re-apply the patch automatically — locally, in CI, and on your server.

## Fail loudly

By default, if a patch fails to apply, Composer logs a message and _keeps going_. That's a great way to deploy a site that's silently missing a fix you're depending on. Make failures fatal instead:

```json
{
    "extra": {
        "composer-exit-on-patch-failure": true
    }
}
```

A patch usually fails because the package updated and the surrounding code changed — which often means the fix was merged and you can delete the patch. Speaking of which...

## Cleaning up

Once the PR is merged and released, update to the version containing the fix, then delete the patch file and its entry in `composer.json`. The patch has done its job.

## Patches that touch test files

If your patch came from a PR that includes changes to tests, it will probably fail — distributed Composer packages usually don't include test files, so there's nothing to patch. You have two options:

1. Open the `.diff` file in your editor and delete the hunks that touch `tests/`, leaving just the actual fix.
2. Tell Composer to install that package from source, so the full repo — tests and all — is present:

```json
{
    "config": {
        "preferred-install": {
            "statamic/cms": "source"
        }
    }
}
```

Editing the patch is usually the better move. Source installs clone the package's entire git repository, which is slower and heavier than the dist archive.

## What to commit

Commit your `patches/` directory, your `composer.json` changes, and `composer.lock`. If you're on composer-patches 2.x, the plugin also generates a `patches.lock.json` file — commit that too, same as you would `composer.lock`.

---

_Hat tip to [Rias Van der Veken](https://rias.be), whose article [Using composer patches](https://rias.be/blog/using-composer-patches) this guide is based on._

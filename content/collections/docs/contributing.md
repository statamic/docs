---
id: 55a99a3b-e40d-4033-9a70-823de8e4255f
blueprint: page
title: Contributing
overview: |
  This is a guideline for contributing to Statamic, its documentation, addons, and starter kits. All of these wonderful things are hosted here in the [Statamic organization](https://github.com/statamic) on GitHub. We welcome your feedback, proposed changes, and updates to these guidelines. We will always welcome thoughtful issues and consider pull requests.
---
✨Thank you for taking the time to consider a contribution!✨

## What you should know before contributing

### Statamic isn’t FOSS

Statamic is not "Free Open Source Software". It is **proprietary** open source software. The code is open, you can use it for free, but there are limitations to how you can modify or redistribute it. Everything in this and our other repos on Github — including community-contributed code — is the property of Statamic. Here are the limitations:

- You **cannot** redistribute or use Statamic as a dependency in another distributable project — open source or otherwise — without prior permission or licensing. You **can** use it in your **own** commercial or personal projects.
- You **cannot** alter code or behavior related to licensing, updating, version/edition checking, or anything else that would circumvent the enforcement of our Statamic Pro business model. We want to stay in business so we can support _you_ better.
- You **cannot** publicly maintain a long-term fork of Statamic. You **can** maintain a private one for your own needs, if you have them.

### How to get support

For official developer support (and you own an active license), please go to [statamic.com/support](https://statamic.com/support) and we will always do our best to reply in a timely manner. **Github issues are intended for reporting and resolving bugs.**

You can chat and collaborate with other developers in the community — [Discord](https://statamic.com/discord) and the [discussions area](https://github.com/statamic/cms/discussions) on GitHub are the best places to go. You will likely find many helpful folks who may be willing to help.

## How you can contribute

### Which repo?

Statamic is split into a few Github repositories. Here's a quick summary of each.

- [`statamic/cms`](https://github.com/statamic/cms) is the core package. It doesn't run by itself but is instead a dependency consumed by Laravel apps. **99% of the work goes on here.**
- [`statamic/statamic`](https://github.com/statamic/statamic) is the starter Laravel app used to build a new site. It's an empty shell.
- [`statamic/docs`](https://github.com/statamic/docs) is the Statamic documentation site that is currently running on [statamic.dev](https://statamic.dev).

### Bug reports

First things first. If the bug is security related refer to our [security disclosures](#security-disclosures) procedures instead of opening an issue.

Next, **please** (pretty pretty please) search through the [open issues](https://github.com/statamic/cms/issues) to see if it has already been opened.

If you _do_ find a similar issue, **upvote it** by adding a 👍 [reaction](https://github.com/blog/2119-add-reactions-to-pull-requests-issues-and-comments). If you have relevant information to add, do so in a comment. Please don't add a `+1` comment.

If no one has filed the issue yet, feel free to [submit a new one](https://github.com/statamic/cms/issues/new). Please include a clear description of the issue, follow along with the issue template, and provide as much relevant information as possible.

:::tip
If you are able to create a repo demonstrating an issue, we can fix it **5x faster** than if you share a code example, and **1000x faster** than if you say "it's broken plz fix it k thx byeeeeee" without even telling us the error message.
:::

### Feature requests

Feature requests should be created in the [statamic/ideas](https://github.com/statamic/ideas) repository. **Please** (pretty pretty please) search through the [open issues](https://github.com/statamic/cms/issues) to see if the feature request has already been opened.

If you _do_ find a similar request, **upvote it** by adding a 👍 [reaction](https://github.com/blog/2119-add-reactions-to-pull-requests-issues-and-comments). If you have relevant information to add, do so in a comment. Please don't add a `+1` comment.

### Security disclosures

If you discover a security vulnerability, please review our [security policy](https://github.com/statamic/cms/security/policy), then report the issue directly to us from [statamic.com/support](https://statamic.com/support). We will review and respond privately via email. We do not respond to cold "do you pay bounties?" emails.

### Documentation edits

Statamic's documentation lives in the [https://github.com/statamic/docs](https://github.com/statamic/docs) repository. Improvements or corrections to them can be submitted as a pull request. These usually get merged very quickly unless your grammar is bad.

### Core enhancements

If you would like to work on a new feature, consider opening an issue first in [the ideas repo](https://github.com/statamic/ideas) so we can discuss it before you spend time on it. While we appreciate community contributions, we do remain selective about what features make it into Statamic itself, so don’t take it the wrong way if we recommend that you pursue the idea as an addon instead.

If you're ready to start working on your feature, bug fix, or improvement, we have a [more in-depth guide to walk you through the whole thing](/contribution-guide).

### Compiled assets

If you are submitting a change that will affect a compiled file, such as most of the files in `resources/css` or `resources/js`, do not commit the compiled files. Due to their large size, they cannot realistically be reviewed by our team. This could be exploited as a way to inject malicious code into Statamic. In order to defensively prevent this, all compiled files will be generated and committed by the core Statamic team.

### Code style

We use [Laravel Pint](https://laravel.com/docs/master/pint#main-content) to enforce a consistent code style across the codebase. You can run it locally with `./vendor/bin/pint`.

### Control Panel translations

We welcome new translations and updates! Please follow [these instructions](/cp-translations#contributing-a-new-translation) on how to contribute to Statamic's translation files.

### Pull requests

Pull requests should clearly describe the problem and solution. Include the relevant issue number if there is one. If the pull request fixes a bug, it should include a new test case that demonstrates the issue, if possible.

Stay rad. If you're not already rad, tell us and we will make sure you become rad.

✨

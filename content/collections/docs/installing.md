---
title: How to Install Statamic
nav_title: Installation
breadcrumb_title: Install
intro: Because Statamic is a **self-hosted platform**, there are many different ways to get started. We recommend using whichever approach you're most comfortable with. If you've never set up a local dev environment before, we have a [guide that can help](/guides/local-dev-environment)!
template: installing
id: ab08f409-8bbe-4ede-b421-d05777d292f7
blueprint: page
video: https://youtu.be/zuKZQNUYSf8
content_width: max-w-4xl
hide_toc: true
---
## You can also install into an _existing_ Laravel app {#exising-laravel}



## Next Steps

Once you've installed Statamic, you're ready to start building! Check out the [Quick Start](/quick-start) page for a walkthrough on how to build a simple site, access the Control Panel, creating a user, and more.

:::tip
You can use Pro features while in development (like users, permissions revisions, REST API, and so on), by setting `'pro' => true` in `config/statamic/editions.php`.
:::

Want to jump right in? You can create a user by running `php please make:user`, and heading to `http://yoursite.com/cp`.

## Updating

Statamic is updated using Composer either directly on the command line or through the Control Panel.

### Command Line

From within your project, use Composer to update the Statamic CMS package:

``` shell
composer update statamic/cms --with-dependencies
```

You may prefer to run `composer update` to update _all_ of your dependencies listed in your composer.json file

### Control Panel

You may also update Statamic from within the Control Panel. Head to the "Updates" section and click update.

:::tip
Updating via the CP will lock that specific version of `statamic/cms` in your `composer.json`. If you want to update using the command line later, you'll need to update the version manually before running `composer update`.
:::

[users]: /users
[packagist]: https://packagist.org/

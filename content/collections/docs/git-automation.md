---
id: c095fb87-4c02-462c-9e6f-dfe0b6889248
blueprint: page
title: 'Git Automation'
intro: 'Statamic can automate your version control workflow with Git. It can automatically commit and push content as it''s changed, schedule commits, or allow users to commit and push changes from the control panel without having to understand how git works.'
pro: true
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1632512218
---
## Overview

Enabling Statamic's Git integration is like having Spock in your enterprise, listening for content changes with those large handsome ears. You won't find anyone more committed. 🖖

<figure>
    <img src="/img/git-utility.png" alt="Git utility allowing user to manually trigger commits from control panel">
</figure>

## Enabling

To enable in a specific environment, add the following to your `.env` file:

```env
STATAMIC_GIT_ENABLED=true
```

By default, content will be committed automatically as it's changed, but you can customize your git workflow using the provided [configuration options](#configuration).

## Configuration

Git workflow can be configured in your `config/statamic/git.php` file, or per environment in your `.env` file.

## Git User

By default, Statamic will attempt to use the authenticated user's name and email when committing changes. If you prefer to always use hardcoded git user info, you can disable this by setting `use_authenticated` to `false` in your [configuration](#configuration):

```php
'use_authenticated' => true,

'user' => [
    'name' => env('STATAMIC_GIT_USER_NAME', 'Spock'),
    'email' => env('STATAMIC_GIT_USER_EMAIL', 'spock@example.com'),
],
```

_Note: Depending on how you configure your commit workflow, an authenticated user may not always be available. In these cases, Statamic will fall back to the above configured user._

## Tracked Paths

You are free to define the tracked paths to be considered when staging and committing changes. Default stache and file locations are already set up for you, but feel free to modify these paths in your [configuration](#configuration) to suit your storage config.

```php
'paths' => [
    base_path('content'),
    base_path('users'),
    resource_path('blueprints'),
    resource_path('fieldsets'),
    resource_path('forms'),
    resource_path('users'),
    storage_path('forms'),
    public_path('assets'),
],
```

:::tip
You may also reference absolute paths to external repositories! If Statamic detects an external repository path, changes will be staged and committed relative to your external repository.
:::

## Committing Changes

By default, Statamic listens to various `Saved` and `Deleted` data events to determine when your content is changed, and will automatically commit your changes. If you prefer users to manually trigger commits using the Git utility interface, you may set this to `false` in your [configuration](#configuration):

```php
'automatic' => env('STATAMIC_GIT_AUTOMATIC', false),
```

Or in a specific environment's `.env` file:

```env
STATAMIC_GIT_AUTOMATIC=false
```

### From the command line

Manually trigger commits via the command line with the following command:

``` shell
php please git:commit
```

## Pushing Changes

Statamic can also `git push` your changes after committing. Enable this behavior in your [configuration](#configuration):

```php
'push' => env('STATAMIC_GIT_PUSH', true)
```

Or in a specific environment's `.env` file:

```env
STATAMIC_GIT_PUSH=true
```

### Remote setup

When pushing, Statamic assumes you have a [Git remote](https://git-scm.com/book/en/v2/Git-Basics-Working-with-Remotes) with an upstream branch set, and are authenticated to push to your remote [via SSH](https://docs.github.com/en/github/using-git/which-remote-url-should-i-use).

:::tip
If you use [Laravel Forge](https://forge.laravel.com/) or [Ploi](https://ploi.io/) to deploy your site, a git remote and upstream branch will automatically be configured for you.
:::

If a remote and upstream is not already configured for your deployment, you may need to set this up manually on your server. For example, the following commands could be run from your deployment folder to add an `origin` remote and track the `master` branch:

```shell
git init
git remote add origin git@github.com:your/remote-repository.git
git fetch
git branch --track master origin/master
git reset HEAD
```


## Queueing Commits

When automatic [committing](#committing-changes) is enabled, commits are automatically pushed onto a [queue](https://laravel.com/docs/queues) for processing. By default, your Statamic app is configured to use the `sync` queue driver, which will run the job immediately after your content is saved during the web request.

```env
QUEUE_CONNECTION=sync
```

### Queueing for performance

If you are experiencing slow-down when saving or deleting content in the control panel, we recommended configuring another queue driver so that commits can be run by a background process, which will help keep the experience fast for your users.

:::tip
A popular choice is to use a [Redis](https://laravel.com/docs/redis) store and [queue driver](https://laravel.com/docs/queues#driver-prerequisites), along with [Laravel Horizon](https://laravel.com/docs/horizon) for managing your Redis queues.
:::

_Note: When commits are run by a queue's background process, there will be no authenticated user. In this case, Statamic will use the hardcoded git user in your [configuration](#configuration)._

## Delaying Commits

When [queueing commits](#queueing-commits), you can also [configure](#configuration) a dispatch delay for your commits:

```php
'dispatch_delay' => env('STATAMIC_GIT_DISPATCH_DELAY', 10),
```

Or in a specific environment's `.env` file:

```env
STATAMIC_GIT_DISPATCH_DELAY=10
```

In this example, we queue a delayed commit to run 10 minutes after a user makes a content change. If at that time the repository status is clean, the commit will be cancelled. Please note that the default `sync` queue driver does not support this. Use another queue driver like `redis` instead.

:::tip
Since all tracked paths are committed at once, this can allow for more consolidated commits when you have multiple users making simultaneous content changes to your repository.
:::

_Note: When commits are run by a queue's background process, there will be no authenticated user. In this case, Statamic will use the hardcoded git user in your [configuration](#configuration)._

## Scheduling Commits

You can also [schedule](https://laravel.com/docs/scheduling) commits to run via cron job at regular intervals within your `app/Console/Kernel.php` file:

```php
protected function schedule(Schedule $schedule)
{
    $schedule
        ->command('statamic:git:commit')
        ->everyTenMinutes();
}
```

In this example, we schedule a commit to run 10 minutes after a user makes a content change. If at that time the repository status is clean, the commit will be cancelled.

### Scheduling for performance

Scheduling commits can be a great alternative to [queueing](#queueing-commits), for when you don't have a proper queue setup. If you choose to schedule commits, just be sure to [disable automatic commit functionality](#committing-changes) as well.

:::tip
Since all tracked paths are committed at once, this can allow for more consolidated commits when you have multiple users making simultaneous content changes to your repository.
:::

_Note: When commits are scheduled to run via cron, there will be no authenticated user. In this case, Statamic will use the hardcoded git user in your [configuration](#configuration)._

## Customizing Commits

To customize the commit messages themselves, modify the `commands` array in the [configuration](#configuration) file.

For example, you can append `[BOT]` to the commit message so that you can selectively disable automatic site deployments when a commit is [automatically pushed](#pushing-changes) back to your repository:

```php
'commands' => [
    'git add {{ paths }}',
    'git commit -m "{{ message }} [BOT]"',
],
```

In your deploy scripts on [Forge](https://forge.laravel.com), [Ploi](https://ploi.io), or [Cleavr](https://cleavr.io) you could then add the following:

### Forge

``` shell
if [[ $FORGE_DEPLOY_MESSAGE =~ "[BOT]" ]]; then
    echo "AUTO-COMMITTED ON PRODUCTION. NOTHING TO DEPLOY."
    exit 0
fi
```

### Ploi

``` shell
if [[ {COMMIT_MESSAGE} =~ "[BOT]" ]]; then
    echo "AUTO-COMMITTED ON PRODUCTION. NOTHING TO DEPLOY."
    exit 0
fi
```

### Cleavr

``` shell
if [[ "{{ commitMessage }}" =~ "[BOT]" ]]; then
    echo 'AUTO-COMMITTED ON PRODUCTION. NOTHING TO DEPLOY.'
    exit 1
fi
```

## Ignoring Events

When [automatically committing](#committing-changes), Statamic will listen on all `Saved` and `Deleted` events, as well as any events registered by installed addons. To ignore specific events, add them to the `ignored_events` array in the [configuration](#configuration) file.

For example, if you're [storing users in a database](/tips/storing-users-in-a-database), you may wish to ignore user-based events:

```php
'ignored_events' => [
    \Statamic\Events\Data\UserSaved::class,
    \Statamic\Events\Data\UserDeleted::class,
],
```

:::tip
When ignoring events, you may also wish to remove any related [tracked paths](#tracked-paths) from your configuration.
:::

## Addon Events

When building an addon that provides its own content saved events, you should register those events with our git listener in your addon service provider:

```php
\Statamic\Facades\Git::listen(PunSaved::class);
```

This will allow your end users to track addon-related content in their [tracked paths](#tracked-paths), if they decide to opt-in for automatic commit and push when saving.

### Providing a default commit message

You can also provide a default commit message by implementing the `ProvidesCommitMessage` interface with a `commitMessage()` method definition:

```php
<?php

namespace Punner\Events;

use Statamic\Contracts\Git\ProvidesCommitMessage;
use Statamic\Events\Event;

class PunSaved extends Event implements ProvidesCommitMessage
{
    public $item;

    public function __construct($item)
    {
        $this->item = $item;
    }

    public function commitMessage()
    {
        return __('Pun saved');
    }
}
```

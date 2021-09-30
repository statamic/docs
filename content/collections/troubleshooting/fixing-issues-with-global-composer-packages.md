---
id: 8e162978-b716-4c8b-a07c-a5ddefc703d5
title: 'Fixing issues with Global Composer packages'
intro: |-
  When [Composer](https://getcomposer.org) works, it's a fantastic and powerful tool. But what happens when it...doesn't? Here's how to fix one of the most common issues with global dependencies:

  **Your requirements could not be resolved to an installable set of packages.**
template: page
categories:
  - cli
  - troubleshooting
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1625836991
---
If you've just tried to install Statamic's installer (`composer global require statamic/cli
`) and encountered an error that includes the phrase "_Your requirements could not be resolved to an installable set of packages_", thankfully the fix is probably simple. We wish errors gave you a better idea what to do next, but here we are.

## Update Global Composer Dependencies

The most common reason for this issue is that your global Composer dependencies are out of date and whatever you're trying to install needs a newer version of package. You can update your global dependencies by running the following command, and then try whatever you were just doing one more time.

``` cli
composer global update
```

## Popping the Hood

If that doesn't resolve the issue, you may need to look at your list of global dependencies for clues. You may have a package that requires an older version of PHP or another dependency. This might take a little Googling , trial and error (remove a line and run `composer global update` and try again), or brute force, but will almost definitely result in finding the problem. Eventually. We're sorry it has come to this.

You can find where the global `composer.json` config file is by running the following command and looking at the `[home]` line.

``` cli
composer config --list --global
```

:::tip
If you're on MacOS, that file will be at `~/.composer/composer.json`
:::

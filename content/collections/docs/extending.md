---
title: Extending Statamic
intro: While Statamic contains countless features, you are free to add more, or modify existing ones.
stage: 1
id: caf2a160-de1c-11e9-aaef-0800200c9a66
---
## To addon, or not to addon?

In Statamic v2, practically every customization would need to be contained within an addon, even if you had no intention of distributing it.

Since Statamic v3 is a Laravel package, you are in control over your application code. You're free to add whatever extra code you like.

This makes the distinction much clearer: **If you want to reuse, distribute, or sell your features; you should make an addon.** Otherwise, you can just add things to your Laravel application.

## How to extend Statamic

Some features can simply be placed in the right spot and they'll be wired up automatically. For example, placing a [tag](/extending/tags) class inside `app/Tags` will make it available to your templates without any extra wiring.

Others could require some wiring, which would typically go in a service provider.

## How **not** to extend Statamic {#how-not-to-extend-statamic}

It should go without saying — but we'll say it anyway just in case...

Don't ever, for any reason, ever, no matter what, no matter where, or who, or who you are with, or where you are going or... or where you've been... ever, for any reason, whatsoever, edit the files inside `/vendor/statamic`. Or any other Composer package. Anything you do will get blown away and you'll lose those changes forever and ever amen.

You should instead build addons, extensions, and submit pull requests to [core](https://github.com/statamic/cms) (after checking with the team first if we'll accept them). Thanks! 

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

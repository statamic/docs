---
title: 'The Cascade'
intro: 'Statamic has the ability to set data on the global, collection, view, and entry levels. We call the way the data can be inherited and overridden "The Cascade™".'
template: page
blueprint: page
id: 3d5efc5c-17b1-480b-bb77-53faf3d9552c
---
## Overview

Content management systems do a lot of work for you. It's the main reason people use them. One of Statamic's "behind-the-scenes" conventions is the way we inject and override data in your [views](/views), based on what URL you're on.

## Global Data

On any given Statamic-managed URL (clarifying this point for anyone building out sections of their site with vanilla Laravel) there is a fair amount of data available in your view.

Every view will have access to [system variables](/variables#variables#system-variables) like `site:url`, `segment_1`, `current_url`, [global variables](/globals), and anything injected via [View Model](/view-models).

## Entry Data
Furthermore, each entry has its own unique URL. When you're on one of those unique URLs, all of an entry's data will be available in your view. If an entry is _missing_ data, intentionally or not), it will fall back to a series of defaults.

We call this fallback logic "the cascade", because the value of any given variable "cascades" down from the "top" until it finds where its defined. If a value doesn't exist in one place, it'll check the next place, then the next, and so on. If it doesn't find anything, the value is `null`.

## Priority Order

Here's the priority order in which the cascade will look for the value of any given variable.

1. Has it been set in a ViewModel?
2. If not, has it been set on the entry?
3. If not and this entry has been translated from another origin, is it set on the origin entry?
4. If not, is it set on the collection (via [inject](/collections#inject))?
5. If not, is it a global variable?
6. If not, is it a system variable?
7. Well okay then, `null` it is.

That's all there is to it.

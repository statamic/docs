---
title: 'Core Concepts'
intro: 'Statamic is opinionated software. Understanding its principals and whatnot will help fine-tune your intuition and help you understand how to take advantage of its efficiencies.'
id: 24a9c9d8-d607-4117-9806-738668c173cd
---
## Opinionated but Configurable

Statamic is an opinionated platform. We strive for smart defaults and patterns that help speed up workflow, enforce consistency, and make it easy to share code between projects.

Following these conventions will make switching between multiple sites trivial, eliminating the learning curve. You'll know right where everything is. This [is a link](#).

Sometimes these conventions don't fit, or you have your own way of doing things you're already perfectly happy with. That's fine. Our conventions can be configured, overridden, or often ignored. Our recommendation is simply this: **if you don't have a good reason, leave it alone.**

## Flat First

Statamic 3 has the ability to adapt to any data storage mechanism, from relational databases like MySQL and Postgres, to NoSQL solutions like MongoDB and Redis, and more.

However, these solutions all add <code>md:words</code> complexity and should only be used when necessary for scale.

Statamic's "default state" is to operate in flat file mode, which not only reduces complexity, but opens up a world of possibilities, like:

- **complete** end-to-end version control
- the ability to write and manage content right in your code editor
- the ability to copy and paste or share configurations between sites
- dead simple deployment and load balancing scenarios
- lots, lots more

As your site scales, you can choose to move from the flat file driver to the one that best suits your needs. Deferring this decision making process is a great way to prevent technical debt.

## Your Content, Your Schema

It's completely up to you how to organize your content. With nearly 40 different fieldtypes included, there are a lot of ways to break everything up.

If you like the "one big field" approach with all your content and markup in one chunk, we've got you covered. Or if you like to break everything up into small, discrete, optional fields, showing and hiding things as needed, you can do that too.

What fields are named, how they're organized, grouped, and arranged is all up to you. Your control panel can be as simple or robust as is needed to manage your site intuitively.

## Build Up, Not Rip Out

We ship with most areas of the site in a "blank slate" state. We find it's much easier to turn on the things you need, enable features you plan to use, and name things the way you want, than to have to spend precious time clicking about
the control panel disabling stuff you'll never end up needing.

If many of the sites you build share a common set of features, collections, taxonomies, and/or templates, save a copy of that state and use it as a site kickstarter. You'll be able to jump into new projects faster than anyone.

## A LEGO Brick Approach to Features

You **may** be used to content management systems and platforms that have a long list of explicit pre-built features, or plugins that provide these features, like photo galleries, hero images, and so on.

Statamic takes a slightly different angle when combined with our "Bring Your Own HTML" core approach, enables you to build almost anything, like a toolbox full of LEGO bricks.

Want to build a photo gallery? Add an Assets field that lets you select multiple images, and then loop through the selected images and render thumbnails on the fly with the Glide tag, and link to the full resolution image.

Image slider? Add an Assets field, select multiple image, and pass the list of images into any number of open source image slider components available on Github.

Hero Image? Add an Assets field and a text field, and render the text on top of the `background-image` of your choosing.

Hopefully you get the idea and see how you can solve almost any challenge with core fieldtypes and some HTML.

## Possible Without the Control Panel

You can do everything (and more) without ever logging into the Control Panel. Granted, the CP does tend to make some of the more complicated things easier (like creating relationships, discovering all possible options for a given setting, and so on), but we love efficiency and your editor is a great place to find it.
---
id: 24a9c9d8-d607-4117-9806-738668c173cd
blueprint: page
title: 'Core Concepts'
intro: 'Statamic is opinionated software. Understanding the principles we follow  and apply to our core concepts, features, and conventions will help train your intuition and understanding of how to take advantage of Statamic in its fullest. This is a fancy way of saying you will need to RTFM less if you understand this more.'
template: page
---
## Statamic is Opinionated But Configurable

Statamic is an opinionated platform. We strive for smart defaults and patterns to help speed up workflow, enforce consistency, and make it easy to share code between projects.

Following these conventions will make switching between multiple sites trivial, reducing learning curve. You'll know right where everything is.

Sometimes these conventions don't fit your project, or perhaps you have your own way of doing things you're already perfectly happy with. That's fine. Our conventions can usually be configured, overridden, or ignored.

> **But don't break convention unless you have a really, really good reason.** Like integrating with an existing Laravel app or when porting a site from another platform.

A good example of this is the decision on whether to use [Antlers](/antlers) as the template language over [Blade](https://laravel.com/docs/blade). Antlers is deeply integrated with Statamic and handles the responsibilities of both Blade _and_ Controllers, all in your template. In short, if you choose to not use Antlers, you'll have to do more work to fetch and prep content some other way.

## Flat Is First

Statamic 3 has the ability to adapt to any data storage mechanism, from relational databases like MySQL and Postgres, to NoSQL solutions like MongoDB and Redis, and more. This feature is called [Repositories](/extending/repositories).

However, these solutions **add complexity** and should only be used when necessary, most often for scaling for large amounts of data (tens of thousands of records) or high volume traffic.

Statamic operates in flat file mode by default, which reduces complexity compared to many other architectures, and opens up many possibilities, including:

- End-to-end **version control**.
- The ability to write and manage content, configs, and templates all **right in your code editor**.
- The ability to copy & paste or share anything between sites.
- **Ridiculously simple** deployment and load balancing scenarios.

As your site scales, you can choose to move from the flat file driver to one best suiting your needs. **Deferring this decision prevents premature optimization and technical debt.**

<figure>
    <img src="https://imgs.xkcd.com/comics/the_general_problem.png" alt="Premature Optimization comic by XKCD">
    <figcaption>Let's be honest. We all do it.</figcaption>
</figure>

## The Content Schema Is Up To You

It's completely up to you how to organize your content. We believe that forcing every site to use the same content model is nothing short of a crime. With nearly 40 different fieldtypes included, there are many ways to structure and manage your content.

If you like the "one big field" approach with all your content and markup in one chunk, we've got you covered. Or if you like to break everything up into small, discrete, optional fields, showing and hiding things as needed, you can do that too.

What fields are named and how they're organized, grouped, and arranged is all up to you. Your data can be as simple or nuanced as you need.

## You Bring Your Own HTML

Much in the same way Statamic doesn't enforce a uniform schema (like WordPress, for example), neither does it enforce a design, specific HTML, or any styles or CSS of its own. That's up to you (or a Starter Kit) to provide.

Every Statamic site &mdash; just like every fingerprint and person in the world &mdash; is unique. This is not a platform for the generic web. This is a tool used to build your dreams.

## Turn On Only What You Need

We ship with most areas of the site in a "blank slate" state. We find it's much easier to turn on the things you need, enable features you plan to use, and name things the way you want, than spend precious time clicking about the control panel disabling everything you'll never end up needing.

If many of the sites you build share a common set of features, collections, taxonomies, and/or templates, save a copy of that state as a [Starter Kit](/starter-kits) and make it your boilerplate to kickstart new projects.

## The LEGO Approach

You **may** be used to content management systems and platforms that have a long list of explicit pre-built features, or plugins that provide these features, like photo galleries, hero images, and so on.

Statamic takes a different approach, that when combined with our "Bring Your Own HTML" core approach, enables you to build _almost anything_, like a box full of LEGO bricks.

**Want to build a photo gallery?** Add an Assets field that lets you select multiple images, and then loop through the selected images and render thumbnails on the fly with the Glide tag, and link to the full resolution image.

**Need an image slider?** Add an Assets field, select multiple image, and pass the list of images into any number of open source image slider components available on Github.

**Got a Hero Image?** Use an Assets and text field and render the text on top of the `background-image` of your choosing.

Hopefully you get the idea and see how you can solve almost any challenge with core fieldtypes and some HTML.

## The Control Panel Can Be Optional

You should be able do everything (and more) without ever logging into the Control Panel. Granted, it _does_ tend to make some of the more complicated things easier (like creating relationships, discovering all possible options for a given setting, and so on), but we love efficiency and your editor is a great place to find it.

Project-wide find & replace is incredibly powerful.

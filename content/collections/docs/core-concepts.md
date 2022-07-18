---
id: 24a9c9d8-d607-4117-9806-738668c173cd
blueprint: page
title: 'Core Concepts'
intro: 'Statamic is opinionated software. Understanding the principles we follow and apply to the way we build features will help you learn Statamic faster.'
template: page
---
## Statamic is Opinionated But Configurable

Statamic is an opinionated platform. We like defaults to match the most common use cases. We implement patterns that help speed up your workflow, enforce consistency, and make it easy to share code between projects.

Following these conventions will make it easier to switch between different Statamic projects because you'll know right where everything is and what it's called.

Sometimes these conventions don't fit your project, or maybe you're perfectly happy with your own way of doing things. That's fine &mdash; our conventions can usually be configured, overridden, or ignored.

:::tip
**But don't break convention unless you have a really, really good reason.** Like integrating Statamic with an existing Laravel app or when porting a site from another platform.
:::

A good example of this is the decision on whether to use [Blade](/blade) as the template language over [Antlers](/antlers). Antlers is deeply integrated with Statamic and can handle the responsibilities of both Blade _and_ Controllers right in your template. If you choose to not use Antlers, you'll have to do more work to fetch and prep content some other way.

:::best-practice
Do your best to maintain a project README with anything you do to override Statamic's default behavior just in case you hand the site off to someone else.
:::


## Statamic is Flat First

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
    <figcaption>Let's be honest. We've all done this.</figcaption>
</figure>

## The Content Schema Is Up To You

It's completely up to you how to organize your content. You pick the field names, you pick how to organize entries into different collections. You pick what to name your taxonomies, what the URL patterns should be, and so on.

We believe that forcing every site to use the same content model is nothing short of a crime. With nearly 40 different built-in fieldtypes, there are many perfectly reasonable ways to structure and manage your content.

If you like the "one big field" approach with all your content and markup in one chunk, build your site around the [Bard](/fieldtypes/bard) fieldtype and add custom Set blocks with other fieldtypes to get fancy.

Or if you prefer to break everything up into small, discrete, optional fields, showing and hiding things as needed, you can do that too (you should check out [conditional fields](/conditional-fields)).

## You Bring the HTML

Statamic doesn't start with a design or HTML you're expected to use or hack around. It doesn't include any CSS or JavaScript either. All of that is up to you (or a [Starter Kit](/starter-kits)) to provide.

Every Statamic site &mdash; just like every fingerprint and person in the world &mdash; is unique. This is not a platform for the generic web. This is a tool used to build anything you can imagine.

Because of this, most Statamic projects need to involve a developer. It's not very "no-code" friendly to assemble. But once the site is built and all the collections and blueprints configured, just about anyone can handle maintaining the site.

## Keep it Simple

Statamic does its best to take a "start simple and add things as needed" approach to features and settings, in contrast to other platforms that take a "everything is included and rip out what you don't want" approach.

This means that Statamic doesn't do everything right out the box. We find it's much better in the long run to turn on the things you need, enable features you plan to use, and name things the way you want, than to spend precious time clicking about the control panel disabling everything you'll never end up needing, or explaining to a client why the button they clicked doesn't do what they expect.

:::tip
If many of the sites you build share a common set of features, collections, blueprints, and/or templates, consider turning them into a [Starter Kit](/starter-kits) and make it your boilerplate to kickstart new projects.
:::

## Statamic is a Box of Lego Bricks

You **may** be used to content management systems and platforms that have a long list of explicit pre-built features, or plugins that provide these features, like photo galleries, hero images, and so on.

Statamic takes a different approach, that when combined with our "Bring Your Own HTML" core approach, enables you to build _almost anything_, like a box full of LEGO bricks.

**Want to build a photo gallery?** Add an Assets field that lets you select multiple images, and then loop through the selected images and render thumbnails on the fly with the Glide tag, and link to the full resolution image.

**Need an image slider?** Add an Assets field, select multiple image, and pass the list of images into any number of open source image slider components available on Github.

**Got a Hero Image?** Use an Assets and text field and render the text on top of the `background-image` of your choosing.

Hopefully you get the idea and see how you can solve almost any challenge with core fieldtypes and some HTML.

## The Control Panel Can Be Optional

You should be able to do everything (and more) without ever logging into the Control Panel. Granted, it _does_ tend to make some of the more complicated things easier (like creating relationships, discovering all possible options for a given setting, and so on), but we love efficiency and your editor is a great place to find it.

Project-wide find & replace is incredibly powerful.

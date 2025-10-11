---
id: 550e7bf1-de6e-40ba-9b06-b32d9119e436
blueprint: page
title: 'Switching From WordPress to Statamic'
nav_title: 'WordPress to Statamic'
intro: |-
  Thinking about moving from WordPress to Statamic? You wouldn't be the first. If you’ve been in the WordPress world for a while, you’re pretty familiar with one of its biggest strengths — the massive plugin ecosystem. If you're evaluating Statamic against this catalogue you might think our community's few hundred addons aren't nearly enough.

  Hopefully this guide will open your eyes to a different approach to building sites. One that doesn't require so many addons and taps into a more flexible way of building bigger features out of smaller ones. And we'll show you Statamic's answers to WordPress plugins you're probably most familiar with.
---

## ACF and Custom Fields

Arguably one of the best ways to build modern content-driven WordPress sites — especially those with a proper separation of content and style — is with Advanced Custom Fields (ACF) or Pods Framework.

Instead of this custom field approach being an afterthought, Statamic was built from the ground up with this approach with 40 different [fieldtypes](/reference/fieldtypes) that you can organize into [blueprints](/blueprints) and reusable fieldsets.

<figure>
    <img src="/img/blueprints.png" alt="The Statamic blueprint configuration screen">
    <figcaption>A glimpse at configuring a blueprint.</figcaption>
</figure>

Your fields are organized into Blueprints, which support sections and tabs for better organization. You have control over field order and width, validation rules, and can even configure conditions that show and hide fields based on your content, making your authoring experience as streamlined and uncluttered as possible for your content team.

If you have groups of fields you want to use in multiple Blueprints, you can create a reusable Fieldset that can be imported into any Blueprint, saving you time duplicating configs.

It’s super intuitive to manage through the control panel. It feels like ACF, but it’s baked right into the core CMS.

## Gutenberg and block/page builders

If you've been working with a Gutenberg or Page Builder approach, take a look at the [Bard](/fieldtypes/bard) and [Replicator](/replicator) fieldtypes — they allow you to create blocks (we call them "sets") out of any _other_ native fieldtypes, giving you virtually unlimited ways to configure your content.

These can be used to create numerous components that can be combined as a "page builder" allowing your content team to create and rearrange pages without ever worrying about what it looks like.

<figure>
    <img src="/img/fieldtypes/screenshots/v4/bard-with-sets.png" width="597" alt="Bard Fieldtype UI">
    <figcaption>The Bard Fieldtype in action.</figcaption>
</figure>

### Block to set examples

Here is how you could create some common "blocks" with Bard and Replicator sets using our native fieldtypes.

#### Hero

- [Assets](/fieldtypes/assets) field for a background image
- [Color](/fieldtypes/color) field to control a background or overlay color
- [Text](/fieldtypes/text) field to edit the `<h1>` text
- [Group](/fieldtypes/group) field with a Text and [Link](/fieldtypes/link) field to create a call to action button with a destination URL

#### Slideshow

A single [Assets](/fieldtypes/assets) field is all you need, as Assets themselves can have their own custom fields for alt text, description, caption, credit, etc.

#### Blockquote

A [Markdown](/fieldtypes/markdown) or [Bard](/fieldtypes/bard) field to hold the quote, and a [Text](/fieldtypes/text) field for the author `<cite>`.

#### Newsletter signup

An empty set works, or a single [HTML](/fieldtypes/html) field letting you insert a display message in your editor saying "Newsletter shown here", and then on the frontend have it render whatever [partial](/tags/partial) you need for the form.

#### Video embed

A single [video](/fieldtypes/video) fieldtype to paste in the URL of a YouTube or Vimeo video would be enough, but you could add a [Select](/fieldtypes/select) or [Button Group](fieldtypes/button_group) field with some options to control the size of the embed (inline vs oversized, for example).

::: tip
These fields store **structured content**, but don't explicitly give control over your _layout_ because they don't write their own HTML. You always have full control of your markup, which in the end makes for a better long-term experience, allowing you to redesign sites without ever having to clean up or rewrite content again.
:::

## Themes

Statamic uses [Starter Kits](/starter-kits) instead of traditional themes. These kits go beyond just styling – they can include plugins, custom code, and entire workflows. 

You can [get Starter Kits from the Marketplace](https://statamic.com/starter-kits), where there are free and commercially available options. For example, the first-party [Cool Writings](https://statamic.com/starter-kits/statamic/cool-writings) starter kit is an excellent choice to use as the basis for a simple blog.

We've even made it easy for you to [create your own starter kit](/starter-kits/creating-a-starter-kit). So once you've migrated your WordPress site, why not submit it to the marketplace?

## SEO

Yoast SEO is probably the biggest go-to SEO plugin for the WordPress world. It's massive and does many things. But it's also pretty complicated and often overkill, especially for smaller sites.

In Statamic, you don’t really _need_ a big plugin to have good SEO. You can get a lot of mileage out of managing all your metadata using our native fields and templates, and then tap into one of the bigger reporting tools like [Moz Seo](https://moz.com/) or [Ahrefs](https://ahrefs.com) to get valuable insight about your site's content.

If you want to take it to the next level, you can check out our first-party addon — [SEO Pro](https://statamic.com/addons/statamic/seo-pro). It includes a number of useful features. It:

- Sets up all your meta data fields for you, including Open Graph and Twitter data, images, and cards.
- Provides a reporting tool to scan your site and make sure all your pages have meta titles, descriptions, and other important SEO factors
- Generates sitemaps automatically
- Manages Google and Bing site verifications
- Generates a [humans.txt](https://humanstxt.org/) file to show who's _behind_ your websites

But SEO Pro isn't the only option in the Statamic Ecosystem. You can explore some of the other popular addons:

- [Advanced SEO](https://statamic.com/addons/aerni/advanced-seo)
- [Aardvark SEO](https://statamic.com/addons/candour/aardvark-seo)
- [SEOtamic](https://statamic.com/addons/cnj/seotamic)
- [SEO Checker](https://statamic.com/addons/luckymedia/seochecker)


## E-Commerce

While there is no do-it-all-and-then-some solution like WooCommerce in the Statamic world, there are still quite a few options that provide a lot of flexibility depending on your specific needs.

[Simple Commerce](https://statamic.com/addons/duncanmcclean/simple-commerce) developed by a core team member, provides essential features like product catalogs, shopping carts, and order management. It can handle digital and physical products, tax calculations, and shipping.

The [Shopify addon](https://statamic.com/addons/rad-pack/shopify) helps you integrate with Shopify's powerful platform — controlling the frontend of your site with Statamic and leaving the heavy cart, checkout flow, and product management to Shopify.

[Donation Checkout](https://statamic.com/addons/ghijk/donation-checkout) lets you accept Stripe payments of arbitrary amounts via Stripe Checkout.

There are integrations for [Lemon Squeezy](https://statamic.com/addons/rias/lemon-squeezy) and [Snipcart](https://statamic.com/addons/aerni/snipcart) as well.

Additionally, Statamic benefits from Laravel's extensive ecosystem, which includes tools like [Laravel Cashier](https://laravel.com/docs/12.x/billing) for subscription billing, and integrations with payment processors such as Stripe and Paddle. This flexibility allows developers to create fully custom e-commerce solutions tailored to specific needs.

## Forms

In WordPress, forms are usually handled by plugins like Contact Form 7, WooForms, or WPForms.

Statamic has a built-in [forms feature](/forms) that enable you to manage form fields, collect submissions, provide reports on them on aggregate, and even display user submitted data on the frontend.

And if you need more customization, addons like [Flexible Forms](https://statamic.com/addons/addon-foundry/flexible-forms) or [Livewire Forms](https://statamic.com/addons/aerni/livewire-forms) can level it up further.


## Security

95.5% of the content-managed websites hacked are running WordPress ([source](https://sucuri.net/reports/2023-hacked-website-report/)). Also, last year there were almost 6000 vulnerabilities found in themes and plugins ([source](https://patchstack.com/whitepaper/state-of-wordpress-security-in-2024/)). It is the most targeted CMS on the market, which makes plugins like Wordfence, Patchstack, or WPScan critical to your security solution. Here are a few reasons Statamic is more secure than WordPress:

- Around 5% of website hacks are done through SQL Injection. Out of the box, Statamic doesn't use a database, thus eliminating most forms of automated attacks.
- Statamic's developer team maintains all of the fundamental features most websites need. You will not need 30 plugins by 30 authors on different update schedules. This is one of the reasons why WordPress is so vulnerable.
- Statamic is built on [Laravel](https://laravel.com), widely regarded as the most secure and well-maintained PHP framework today.

## Performance

WordPress is notoriously slow out of the box, which is generally alleviated by plugins like WP Rocket and Redis caching.

We've considered and optimized for performance in every area of Statamic. Built-in smart caching is often enough for most sites to fly <strong>right out of the gate</strong>, and for those more complex sites that have more heavy lifting or higher traffic — [static caching](/static-caching), Redis caching, or even [static site generation](https://github.com/statamic/ssg) are all native tools at your disposal.

## Spam protection

If you’re used to using Akismet to keep spam out of your forms, you can [continue doing so](https://statamic.com/addons/silentz/akismet).

## Redirection

Need to manage redirects? In WordPress, you’d likely use the Redirection plugin. In Statamic, there’s an addon for that — [Redirect](https://statamic.com/addons/rias/redirect). You can redirect legacy urls, manage 301 and 302 redirects right from the control panel without any performance impacts. Super simple.

## Backups

In WordPress, you might use UpdraftPlus to handle backups, but in Statamic — as long as you're running on flat files — git becomes your backup, version controlling all your changes to content, templates, and configs along the way.

If you’re using Statamic Pro, it can even automate your Git commits and pushes. No more worrying about backups, they’re just an invisible part of your workflow.

## Importing content

Statamic has a [native Importer](https://github.com/statamic/importer) with support for WordPress's XML or CSV export formats. It supports importing entries, taxonomy terms, and users, and can handle converting Gutenberg content to Bard sets. It even has hooks you can use to customize the import process at any step of the way.

## Everything else

- **Slider Revolution:** Build custom sliders with Statamic’s [Replicator field](/fieldtypes/replicator) and plug it into frontend libraries like [Slick](https://kenwheeler.github.io/slick/) or [Flickity](https://flickity.metafizzy.co/).
- **MonsterInsights:** You can drop Google Analytics right into Statamic or use the [Ginsights Analytics](https://statamic.com/addons/vijay-software/ginsights-analytics) addon if you want a more integrated feel.
- **WPML:** Statamic’s built-in [multi-site](/multi-site) feature helps you  manage different languages.
- **Mailchimp for WordPress:** Use the [Mailchimp](https://statamic.com/addons/rad-pack/mailchimp) addon to connect directly with your audience.
- **Smush, Imagify:** Statamic has you covered with [Glide](/tags/glide), an image manipulation tag that compresses and optimizes images on the fly.
- **Comments:** Check out [Meerkat](https://statamic.com/addons/stillat/meerkat-statamic-3).

## Glossary

When migrating from WordPress to Statamic, one of the initial challenges is adapting to new terminology. While both systems share many similar concepts, they often use different names for comparable features. Hopefully this table helps point you in the right direction.


| WordPress Term | Statamic Equivalent | Notes |
|---------------|-------------------|-------|
| Post/Page | Entry | Basic content unit in Statamic |
| Custom Post Type | Collection | Groups of similar entries |
| Category/Tag | Taxonomy | Both systems use taxonomies for classification |
| Template | Template/View | Antlers or Blade templates in Statamic |
| Theme | Starter Kit | Starter Kits are a starting place, but are not generally interchangeable |
| Plugin | Addon | Extends core functionality |
| Meta Fields | Fields/Blueprints | Statamic uses YAML for field definitions |
| Featured Image | Asset | Part of Statamic's Asset system |
| Menu | Navigation | We call menu structures "Navigations" |
| Custom Fields/ACF | Fieldtypes | Various content input types and controls |
| Gutenberg Block | Bard/Replicator | Rich content editing tools |
| Shortcode | Tag | Template tags for dynamic content |
| Media Library | Assets | Asset management system |
| User Role | User Role/Group | Similar permission systems |
| Options/Settings | Globals | Site-wide variables and settings |
| Post Status | Status | Published, Draft, etc. |
| Author | User | Content creators |
| wp-config.php | `.env` or `config/statamic/` | Site configuration |
| functions.php | ServiceProvider | For adding functionality |
| hooks/filters | Events/Listeners | For modifying core behavior |
| Child Theme | - | Statamic uses bespoke themes |
| Featured Image | Asset | Hero/main images |

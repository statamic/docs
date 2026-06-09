---
id: 20f0707b-619d-4a7a-b7dd-aea4122fa1db
blueprint: page
title: 'Content Modeling'
intro: 'Before you build pages, templates, or implement features, there’s one foundational question to answer: **what shape should your content take?**'
related_entries:
  - 54548616-fd6d-44a3-a379-bdf71c492c63
  - 2940c834-7062-47a1-957c-88a69e790cbb
  - 1e91dd54-c452-4e3b-8972-dba83c048d3d
  - 7202c698-942a-4dc0-b006-b982784efb03
nav_title: Overview
---
Content modeling is just the process of deciding how your content is structured — what fields it has, how different pieces relate to each other, and where flexibility actually matters. In Statamic, that plays out with blueprints, fields, globals, collections, and relationships.

A good content model makes everything easier:

- Editors understand what goes where
- Developers have more flexibility to pull the content you want into all the right places
- Designers don't have to be told "we can't do that"
- And future you doesn’t regret past you’s shortcuts

This guide walks through how to think about content first — separating structure from presentation, optimizing for changeability and flexibility, and building a site that doesn't revolve around _pages_, but well-structured content.

## The Separation of Content and Presentation

Content professionals have become accustomed to thinking about content and presentation together. They expect to see what the content will look like and often expect to change that appearance as well. 

Traditional WYSIWYG tools and visual builders reinforce this mindset. They blur the line between content and layout, and in doing so, let design decisions leak into the content itself.

But these are bandaids. 

An author shouldn't be making decisions about layout — that's the job of the designer and/or UX professional. An author should focused on the **clarity of content**, not enforcing (or deciding) style. The job of the CMS (Statamic in this case) is to take that content, manage it well, and give designers and developers the freedom to present it however they need — today or years from now.

When you separate content from presentation, you stop tying your data to a specific layout. You don’t have to rewrite everything when a design changes. You don’t have to migrate content just because a homepage gets redesigned. Your content is adaptable. You did the hard work once and now the rest of the work becomes easy.

This is where Statamic really shines, and it’s also why you won’t find an Elementor-style visual builder anywhere around here. Those tools are crutches — shortcuts at best, and long-term liabilities at worst. They tend to lock content into a moment in time and replace thoughtful design with convenience.

Alright. Soap box over. Let’s get practical.

## Start with Collections

First start by determining all of your different **"content types"**. These usually map directly to [collections](/collections). 

For example, if your site is going to have articles, news, case studies, and a handfull of on one-off pages, you'll probably end up with collections like:

- Articles
- News
- Case Studies
- Pages.

Each collection represents a distinct type of content with its own purpose, structure, and lifecycle.

As you do this, watch for content that feels reusable. If something shows up in multiple places, it may deserve its own collection.

For example, on a marketing site for a software product, you might reference specific “features” across articles, case studies, and landing pages. Instead of rewriting that content everywhere, you can model features as their own collection and pull them into other entries using [relationship fields](/relationships).

## Then Define Your Fields

Every collection uses one or more [blueprints](/blueprints). Blueprints define the fields that make up that content. If multiple blueprints need the same fields, group them into a [fieldset](/fieldset) and import it where needed.

When defining fields, think beyond “what do we need right now?” and more in terms of “how might this content be reused or rearranged later?”

If a piece of content could reasonably stand on its own — be styled differently, moved elsewhere, or displayed independently — it probably deserves its own field.

Consistency matters. Use clear, predictable naming conventions across your blueprints and fieldsets. Things like `body_content`, `hero_image`, `sidebar_callout`. Future you says thank you.

Small decisions like this add up. A clean, consistent content model is easier to understand, easier to extend, and far less likely to be “creatively worked around” by frustrated editors.

## Global Variables for everything else

Finally, there are [globals](/globals). 

If something lives in one place but is used across the site — like header content, footer links, social profiles, or site-wide calls to action — globals are the right tool for the job.

They keep shared content centralized, editable, and out of places where it doesn’t belong.

## What to Avoid

Most content modeling problems don’t show up on day one. They show up months later, when the site grows, the design changes, or someone asks, “Can we reuse this somewhere else?”

Here are some common traps to avoid.

### Modeling Pages Instead of Content

If your content model mirrors your page layouts, you’re probably heading for trouble.

Fields like `left_column_text`, `homepage_feature_1`, or `about_page_body` are a code smell. They bake presentation decisions directly into the content and make reuse painful or impossible. As soon as `left_column_text` ends up needing to be used on the right side somewhere, a fairy dies — and no amount of clapping can revive her.

Model what the content **is**, not where it happens to live today.

### Over-Modeling Everything

Not everything needs to be perfectly modeled.

If a piece of content is truly one-off, short-lived, or unlikely to be reused, don’t turn it into a dozen fields just because you can. Over-modeling can create friction and slow people down.

Model for clarity and flexibility — not theoretical perfection.

### Ignoring Future Change

The biggest mistake is assuming today’s structure is permanent.

Sites evolve. Designs change. Content gets reused in ways you didn’t anticipate. It gets pulled into mobile app or powers a customer-support ticketing app. A good content model leaves room for that without forcing a rewrite or migration.

If your model _only_ works for the site you’re building right now, it’s probably too brittle.
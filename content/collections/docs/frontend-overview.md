---
title: 'Frontend Overview'
intro: Frontend, backend, control panel, client-side, server-side, left-side, strong-side, front-side fakey 180...there's a lot of terminology flying around when referring to the various parts of a website. Let's clear 'em up.
nav_title: "Overview"
template: page
id: 84100772-18e4-4a22-8759-219b242a320c
blueprint: page
stage: 1
---
## Clarification

The **frontend** of a website is what users see and interact with in their browser. It includes everything from the text and images, to the various layouts and even RSS feeds your readers and visitors consume.

> It's highly likely this isn't new information – most people who read these docs are developers with front-end experience. Please keep reading though! There's good info in here.

When we refer to the frontend of a _Statamic_ site, we're talking about the templates and views, JavaScript and CSS files, media assets, and other resources used to render your final website.

The **backend** of a Statamic site is all of the PHP and Laravel code that you can customize and extend to add your own unique features and capabilities to your site.

Statamic's **Control Panel** sits _outside_ both the frontend and backend as a tool to publish and manage content, users, and assets.

## The Frontend is Yours

In today's tech-driven ecosystem there are countless ways to build a website. You could...

- Write a Single Page Application (SPA) with [Vue.js](https://vuejs.org) or [React](https://reactjs.org) to run your entire site without the need for page refreshes
- Use HTML and Statamic's [Antlers](/antlers) template language to build a dynamic site with smart caching
- Use [Webpack](https://webpack.js.org), [Laravel Mix][mix], or [Gulp](https://gulpjs.com) to compile your JavaScript and SCSS/LESS
- Go for the [JAMStack](https://jamstack.org) approach and run a statically generated site without server-side processing
- Build a standard Statamic site and deploy a static version to [Netlify](https://www.netlify.com)
- Go skateboarding and stay away from computers and their nerd owners
- <span class="font-display">Kick it old-school and write your own HTML, plain CSS, and vanilla JavaScript</span>

Just like the [honey badger](https://www.youtube.com/watch?v=4r7wHMg5Yjg), Statamic don't care. You can take any of these approaches or one of many others — including several that will be invented tomorrow and forgotten by autumn.

**It's up to you.** Write or generate HTML somehow and let Statamic get it to the browser.

## Path of Least Resistance

If you don't have a hard requirement, a strong preference, or just want our advice, we recommend writing your own HTML, use [Antlers](/antlers) in said HTML, use [TailwindCSS](https://tailwindcss.com) as your CSS framework, and let [Laravel Mix][mix] compile any JavaScript, SCSS/LESS, or PostCSS as necessary.

You'll be able to take advantage of all of our powerful, tightly coupled [tags](/tags) that do most of the heavy lifting — like fetching and displaying content from collections and taxonomies, manipulating, assets, and rendering variables.

## Request Lifecycle

Let's take a quick look at what happens during a typical Statamic frontend request:

1. User visits a URL.
2. Statamic sees if there's some data matching the URL (eg. an [entry](/collections) or [route](/routing#statamic-routes)).
3. [Variables](/variables) for that data item get compiled.
4. It loads the appropriate [view](/views) and passes in the variables.
5. Contents of the rendered view is sent back to the user's browser.

[mix]: https://laravel.com/docs/mix

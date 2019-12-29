---
title: 'Quick Start'
intro: "This is a step-by-step walkthrough on installing and building a simple Statamic 3 site. It is focused more on the fundamental building blocks and less on design and aethetics. In fact, it will be an ugly site. Just brace yourself ahead of time."
id: 1d1920fb-604c-4ac1-8c99-f0de44abc06b
---
## Overview

Much of the documentation is intended to be used as a reference sheet for various features, explaining how they work and what options and settings they provide. But not this guide. This is for glueing it all together, assuming you know very little about how Statamic works. We'll only make a couple of assumptions here before we get started.

1. You are comfortable working with HTML.
2. You have a local dev environment with [composer](https://getcomposer.org/) installed.
3. You can copy and paste a few commands into the command line.
4. You have more than 5 minutes to spare. Let's enjoy ourselves here.

## What we're building

We're going to build a simple personal website for a fictious young aspiring programmer named Kurt Logan. Kurt always has and always will live in the 1980s and is very excited at the prospect of having his very own place in <span class="uppercase font-bold tracking-widest text-green font-display">Cyberspace</span>.

## Install Statamic

The first step — as I hope you have guessed — is to install Statamic. Let's get a brand new empty project running, and then we'll do stuff to it until it looks like a website.

First, we're going to run a [`composer create-project`](https://getcomposer.org/doc/03-cli.md#create-project) command from the command line, which clones the [statamic/statamic repo](https://github.com/statamic/statamic) and then runs a series of scripts on it to automate steps you would otherwise need to perform manually if you cloned the repo directly.

You should run this command from your `~/Sites` directory if you're using a [Valet](https://laravel.com/docs/valet) or similar setup where each subdirectory maps to a `.test` local domain.

``` bash
composer create-project statamic/statamic cyberspace-place --prefer-dist --stability=dev
```

If everything worked as expected, you should be able to visit [http://cyberspace-place.test](http://cyberspace-place.test) and see the Statamic 3 welcome screen.

<figure>
    <img src="/img/quick-start/installed.png" alt="Statamic 3 Welcome Screen">
    <figcaption><a class="no-underline hover:text-pink-hot font-bold text-blue-darkest" href="https://www.youtube.com/watch?v=5pL6uUYdWbU">If do right, no can defense.</a></figcaption>
</figure>

Next, in your command line navigate into the new site (`cd cyberspace-place`) and open the directory in your code editor.

## Create your first user

Now we can create a new super user and get into the control panel so we can start to create some content to display on the frontend.

Run `php please make:user` from the command line inside your new project directory and follow the steps. Be sure to say `yes` when asked if the user should be a **super user** otherwise you'll just have to do it again. And again. And again until you finally say `yes`. What are you afraid of?

<figure>
    <img src="/img/quick-start/make-user.png" alt="Statamic 3 Make:User Command" width="453">
    <figcaption>We can customize user fields later — this is just fine for today.</figcaption>
</figure>

Now you can log in! Head to [http://cyberspace-place.test/cp](http://cyberspace-place.test/cp) and use your email address and password to be granted access to the secret world of Narnia.

<figure>
    <img src="/img/quick-start/login.png" alt="Statamic 3 Login Screen">
    <figcaption>If you see this screen at <code>/cp</code> you've just earned 200 XP!</figcaption>
</figure>

## Make a home page

Next, let's get some content of _our_ choosing to show on the homepage of the site. If you go to `Structures → Pages` in the control panel, you'll see an empty home page entry sitting and waiting for you. Click on the entry's title and you'll see the entry edit screen. Write anything you want in the `content` field and then click **Save & Publish**.

<figure>
    <img src="/img/quick-start/editing-home.png" alt="Editing the home page">
    <figcaption>Don't overthink it. Just type some aedgaeduhadfubugra</figcaption>
</figure>

Taking a note that the entry is using the `home` template, as can be seen in the `template` field. Let's edit this template so we can show the masterpiece of a manuscript you just composed.

In your code editor, open the file `resources/views/home.antlers.html`. This is the home template. The name of a template is the the filename up until the file extension. If the extension ends in `.antlers.html`, it will be parsed with Statamic's [Antlers](/antlers) template language.

> If a view file ends with `.blade.php` it will use Laravel's [Blade language](/template-engines). This same pattern applies for other template engines that could be installed and supported in the future.

Delete all the placeholder HTML from the template and replace it with the following markup:

```
<h1>{{ title }}</h1>
{{ content }}
```

Refresh the site in your browser and you should see your content in all of its glory. Each of those double curly tags is a **variable**. When on a URL that's loading content from an entry, all of the content fields are available to you with their corresponding variable name (also called a "handle"). We'll get into adding new fields in just a bit.

<figure>
    <img src="/img/quick-start/new-home.png" alt="Your new home page" width="424">
    <figcaption>What did you write? Was it a dad joke?</figcaption>
</figure>

You probably noticed that there is some _very_ basic styling going on. That's coming from the **layout**. Time to make that yours too. Open `resources/views/layout.antlers.html` and replace it with this:

```
<!doctype html>
<html>
<head>
    <title>{{ title }} | KURT LOGAN'S CYBERSPACE PLACE</title>
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-black text-white text-lg font-mono">
    <div class="container max-w-lg mx-auto py-16">
        {{ template_content }}
    </div>
</body>
</html>
```

Your layout file contains any markup you want present no matter what page you’re on, no matter where you go, how far you travel, or loudly you sing. It's the perfect place to put all your `<head>` and meta tags, main site nav, and footer bits.

You can think of layouts like picture frames for your website. Everything you want rendered into the _contents_ of the frame — things that may change from section to section and page to page — goes into template. Those template are rendered wherever you put that `{{ template_content }}` variable in your layout.

## TO BE CONTINUED...

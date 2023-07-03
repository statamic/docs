---
id: e947dc19-9a8a-44c2-911c-171d1f196c91
blueprint: page
title: 'Content Manager''s Guide to Statamic'
nav_title: 'Content Manager''s Guide'
breadcrumb_title: 'Content Manager''s Guide'
intro: |-
  So you've got yourself a brand new Statamic site, inherited an older one, or joined a team that's already using Statamic. Great! Welcome to the wonderful world of Statamic. Perhaps you're wondering what to do next, how to add a tracking code to a landing page, get technical support, or reset your password and get back into the Control Panel.

  You've come to the right place. We'll try to answer the most common end-user questions and topics people have when encountering Statamic for the first time.
---
## Four things you need to know.

### We can't get into your site.

This is important information, so please read this whole section. All Statamic sites are **self-hosted**. This means that each Statamic site is a unique _copy_ of the Statamic application, and is running on a server that you, your company, or web design/development agency owns or has access to.

And since your Statamic site is running on a server that isn't ours, it means we **do not have access to it**. We can't sign in to your control panel and reset a password for you, give a user more permissions or access, make changes to the site, read the code, or kick out annoying users with bad grammar.

It might seem like that's a big downside if you're running into a problem that you feel our support team should be able to fix from our floating cloud desks — and maybe in a few cases that might be true — but overall this is a very good thing for you and your organization. Nothing we can do can take your site away. **Your site is yours forever**.

Too many people have put their hard work and money building websites, blogs, and companies futures on platforms that end up getting shut down, bought out, or change their mind about who their audience should be — resulting in prices skyrocketing, or sites just disappearing forever with no way to get data out. Things change so fast in the tech world — your site **should not** be subject to these external (and often desperate) forces. Own your site. Own your content. Own your audience.

::: Did you know?
Servers are just computers that run websites and applications accessible to the internet. And **"the cloud"** is just another term for "a bunch of servers out there somewhere". They might as well be floating around in the sky as far as most people are concerned or care.
:::

### Every site is unique.

Each Statamic site starts like a bit of a blank slate. We take a "start simple and add things as needed" approach to features and settings, in contrast to other platforms that take a "everything is included and rip out what you don't want" approach.

This means that Statamic doesn't do everything automatically, and generally requires a developer to enable, configure, or hook up different features you might assume are part of every site. A few examples of this in practice: blog posts don't automatically have "tags" or "categories" — in fact there is no  "blog" by default, and there is no built-in "snippet manager" to paste analytics or tracking codes into.

Each of these things can be "built" in a matter of minutes (or even seconds) with Statamic's building-block approach to custom fields and features.

This might feel like backwards if you're used to working in a platform like WordPress or Drupal, but we have found (and our customers agree emphatically!) that it's much better in the long run to _turn on_ the things you need, enable features you plan to use, and name things _the way you want for clarity_, than to spend precious time clicking about the control panel disabling all the things you'll never need, or worse — just leaving behind features, buttons, or sections that simply don't do anything.

You may find that your site is missing the ability to edit something you consider to be fundamental in a content management system. It might frustrate you. You might feel stuck. But before reaching for WordPress to rebuild your whole site from scratch (please don't do that), just have a quick chat with whoever built your site, because...

### Statamic sites are _very_ easy to change.

**This is Statamic's secret power.** This is why developers use Statamic over the ubiquitous WordPress. **Do not be afraid** to ask the developer or team who built your Statamic site to make a change, make some bit of content editable, or add a new feature. It will most often it will be a very small amount of work.

<blockquote class="twitter-tweet"><p lang="en" dir="ltr">God, do I love working with <a href="https://twitter.com/statamic?ref_src=twsrc%5Etfw">@statamic</a>. It feels like implementing anything only takes a fraction of the time compared to other content management systems...</p>&mdash; Martin Keck (@sisyphos2dot0) <a href="https://twitter.com/sisyphos2dot0/status/1612761926626598913?ref_src=twsrc%5Etfw">January 10, 2023</a></blockquote> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>

### Every Statamic site needs a developer.

Because of these three facts, it's important to note that every Statamic needs — at least at one point or another — a web developer. Someone who can write some code and get it up on a server.

Statamic is pretty easy to learn for anyone who knows HTML and has run other PHP applications (like WordPress, for example) before. But if this isn't your skill set, it's okay. Just know that most people who build websites have the skills necessary to work on a Statamic site (assuming they're willing to read some of this documentation).

Once your site is set up and launched, it's possible you may not need another developer again, or at least for a long time. But, in order to run updates to make sure you're running the fastest and most secure version of Statamic, you'll need that developer every now and then to do that.

Statamic updates aren't a "click the button and wait" kind of process. There are too many potential problems with that approach to web software, and in order to protect you and your website from going down, all Statamic updates must be run from the command line — a level of access a regular user doesn't have.

## FAQs

### Where do I login to my Statamic site's Control Panel?

<mark>Most sites have their login screen set up on `example.com/cp`</mark> (where example.com is the URL of your website). This URL is customizable, and some people like to change it to `example.com/admin` or something else entirely for security purposes.

Someone with access to your site's Statamic Control Panel will need to create your account and invite you first. As part of that process you will _most likely_ have received an email with a link to activate your account. This link will get you to your Control Panel.

We say _most likely_ because these defaults can be changed. Instead of an email, they could have sent you a link into Slack or Teams, etc.

:::tip
Your [statamic.com](https://statamic.com) account (if you have one) has nothing to do with the login for your site's control panel. It's just used to buy licenses, addons, and request support. This is because [we can't get into your site](#we-cant-get-into-your-site).
:::

### How do I reset my password?

No worries, it happens to the best of us! Assuming you know your login URL (see [Where do I login to my Statamic site's Control Panel?](#where-do-i-login-to-my-statamic-sites-control-panel)), you should have a link to **Reset Your Password** right there on that screen.

<figure>
    <img src="/img/password-reset-link.png" width="423" alt="Statamic Password Reset Link">
    <figcaption>👆 See that Forgot password link?</figcaption>
</figure>

After clicking that link and entering your email address, you should receive an email with a link to reset your password and get back into the Control Panel.

If you don't receive that email, it's possible that whoever built your site (your developer) didn't set up email sending for your site and/or server. In this circumstance, you have three options.

1. Ask your developer to finish setting up your site properly and/or [reset your password manually](/tips/manually-resetting-a-user-password) for you. **This is the best option** because it prevents this problem from happening again.
2. Ask someone else with permissions to manage users in Control Panel to reset your password for you. They can do that by going to the Users section, then opening the dropdown next to your account and clicking "Copy Password Reset Link" and sending that to you in your preferred communication tool of choice.

3. Ask someone else with permissions to manage users in Control Panel to simply change your password for you. They can do that by going to the Users section, then clicking on your user account, and then the "Change Password" button next to your name, and following the form that pops up.

### What do I do if my site is broken?

There are a few reasons a site might "randomly" break, but in almost all of those cases you'll need to contact your developer to fix your site and bring it back online. They _should_ know to check the error logs to see what happened, but feel free to suggest that to them. Also mention the exact error code, if there is one, that you see when visiting your site. A 404 error is very different from a 501, for example.

We'll explain a few of the most common (though this kind of thing is anything but common) scenarios when this might happen.

#### DNS settings are wrong
It's possible that there's nothing wrong with your site, but rather with your DNS settings. DNS settings are usually managed with your Domain Registrar — the place you bought your .com, .co.uk, or other domain name. These settings tell browsers where to go when visiting your domain.

This is most likely the problem if your site is showing the _wrong_ site, wrong page, or displays an error that mentions DNS, redirects, or something similar.

If someone has recently been making changes to your DNS (maybe setting up a subdomain or changing email providers), it's possible they changed the wrong thing and your DNS is no longer pointing at your server properly.

If this happens, contact your developer or whoever manages your DNS to have them undo whatever mess they made.

#### Surprise server upgrade
It's possible your server had an upgrade that significantly changed the version of PHP or some other bit of software that your version of Statamic doesn't support. This is similar to when you upgrade a Mac or Windows computer — sometimes you need to upgrade your software to compatible with the latest versions of your operating system.

This is rare, but can happen with cheap "shared hosting" services, like GoDaddy, HostGator, BlueHost, and other similar companies that have crazy low prices. You get what you pay for with hosting.

If this happens, you'll need to have a developer update Statamic to the latest version, and if that doesn't fix it, open a support ticket with your host. And if that doesn't fix it, it might be time to get a better host.

#### Server ran out of storage
If your website has lots and lots of images (or really big images) and files, it's possible your server may have run out of storage space while Statamic was creating all thumbnails and any other image sizes needed to render your design.

If this happens, you'll need to have your developer clear out any image caches and upgrade the storage capacity of your server so it doesn't happen again.

Alternately, your developer can move your images to AWS (Amazon's file management service) or an equivalent, as it can be more cost effective than upgrading your server.

#### Bad code
Nobody's perfect. It's possible your developer had some custom code in your site that has a performance problem and uses up all your memory, thereby crashing the server — or something like that.

If this happens, you guessed it — talk to your developer. They'll figure it out. And if they don't, [get a better developer](https://statamic.com/partners).

### How do I find a new Statamic developer?
If a developer or agency is no longer available to work on your site, or you feel their quality of work is not up to your standards, it may be time to find a new Statamic developer.

If you start Googling "where to hire a Statamic developer" you _may_ not find a ton out there, at least when compared to WordPress developers, but let us assure you, there are lots of talented and professional Statamic folks out there.

The best place to find one is on our [Partners](https://statamic.com/partners) directory. There you can find a list of freelancers and agencies who have a proven track record of building Statamic sites and addons. Furthermore, the **Certified Partners** have gone through reference vetting and code reviews with our Core Team to make sure they're technically proficient and have good relationships with their clients. We highly recommend working with a Certified Partner.

If you'd like us to match you with a Partner, we'd be happy to do so. Head on over to our [Matchmaking Service](https://statamic.com/partners/matchmaking).

You could also post a job or project on [workwithstatamic.com](https://workwithstatamic.com), or jump into our live [Discord Chat](https://statamic.com/discord) and visit the `#jobs` channel to see who might be interested in helping you out.

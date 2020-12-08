---
title: Licensing
intro: 'Statamic 3 is available in two distinct flavors, but one splendid codebase. Statamic Solo is **free and open source** for personal and hobby use, while **Statamic Pro** is powerful commercial software designed for team use.'
blueprint: page
id: 56fadb93-b846-4867-ad73-4f721cc940c2
stage: 5
---
## Solo vs. Pro

Statamic is available in two flavors: **Solo** and **Pro**. You can read about what's included in each on our [blog](https://statamic.com/blog/everything-about-statamic-3).

When you install Statamic, it will be configured to use the free Solo edition. You're able to opt into Pro at any time in your `config/statamic/editions.php` file:

``` php
'pro' => true,
```

Once you've opted into Pro, many additional features will be available.

## Trying Pro Mode {#trial-mode}

You can use **Statamic Pro** locally without a license key for as long as you'd like. This is called **Trial Mode**.

While in trial mode you are also able to try out any [commercial addons](https://statamic.com/addons?statamic=3).

## Production

Once it’s time to launch your site on a public domain, there are a few things you need to do:

- [Create a Site](#sites) on statamic.com and enter the appropriate domain(s).
- Purchase any required licenses (e.g. Statamic 3 Pro and/or any paid addons) and attach them to your Site.
- Add your Site's license key to your Statamic config or environment file.

``` php
// config/statamic/system.php
'license_key' => 'your-site-license-key',
```

``` env
STATAMIC_LICENSE_KEY=your-site-license-key
```

> If you're using the free version of Statamic and you don't have any commercial addons installed, you don't need to create and link a site. But you can if you want! Being organized is a nice thing.

## Sites

In your [statamic.com account](https://statamic.com/account/sites), you can create "Sites" that are used to organize your licenses (and in the future may provide some other nice features).

Each Site has one unique license key that any and all commercial products are attached to and validated through. No more juggling a fist full of keys like a bunch of quarters at the arcade.

## License Validation

If you want to know about the legal terms you can [read those here](https://statamic.com/license). The rest of this article covers the more _technical_ aspects of the call-home features, domain restrictions, and so forth.

### Statamic needs to "phone home"

Statamic pings The Outpost (our validation web service) on a regular basis. The Outpost collects the license key, public domain info (domain name, IP address, etc), and PHP version so we can validate them against your account.

This happens once per hour, and only when logged into the control panel. Changing your license key setting will trigger an immediate ping to the The Outpost. Tampering with outgoing API call will cause Statamic to consider your license invalid. If that happens, you'll need to open a [support request][support] to reinstate your license.

## One License Per Site

Each license entitles you to run one production installation. You will need to specify the domains you plan to use from the "Sites" area of your Statamic Account. Domain are treated as wildcards so you can use subdomains for locales, testing, and other purposes.

If you attempt to use the site from a domain not listed in your Site settings, you will get a notification inside the Control Panel informing you thusly to make the necessary changes. You may change the domain associated with a license at any time on [statamic.com](https://statamic.com/account/sites).

## Public Domains
When Statamic calls home we use a series of rules to determine if the domain it’s running on is considered “public”.

If any of the following rules match, the domain is considered _not public_ (letting you stay in Trial Mode)

- Is it a single segment? eg. `localhost`
- Is it an IP address?
- Does it use a port other than `80` or `443`?
- Does it have a dev-related subdomain? `test.`, `testing.`, `sandbox.`,  `local.`, `dev.`, `stage.`, `staging.`, or `statamic.`
- Does it use a dev-related TLD? `.local`, `.localhost`, `.test`, `.invalid`, `.example`, or `.wip`

## Special Circumstances

[Contact us][support] if you have one and we'll see what we can do.

[support]: https://statamic.com/support

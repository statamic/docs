---
title: Licensing
intro: 'Statamic is available in two distinct flavors, but one splendid codebase. Statamic Core is **free and open source** and can be used for anything you wish, while **Statamic Pro** is powerful commercial software designed for team use.'
blueprint: page
id: 56fadb93-b846-4867-ad73-4f721cc940c2
---
## Core vs. Pro

Statamic Core carries a few limitations you'll need to upgrade to Pro to remove:

- One admin [user account](/users)
- One [content form](/forms)

Additionally, **Statamic Pro** also includes the following, exclusive features:

- [Roles & Permissions](/control-panel/users#permissions)
- [Revisions, Drafts, and Content History](/revisions)
- Headless mode via [REST API](/rest-api) and [GraphQL](/graphql)
- [Multi-site, multilingual, and multi-user-editing](/multi-site)
- [White Label customization](/white-labeling)
- [Git integration and automation](/git-automation)
- Developer Support

:::tip
You can use Statamic Pro for as long you'd like in development. We call this "Trial Mode".
:::

## Enabling Pro

When you install Statamic you will be asked if you want to enable **Pro**. If you decide skip it to start with Core, you can still opt into Pro at any time by running `php please pro:enable` via command line or updating your editions config file.

``` php
// config/statamic/editions.php
'pro' => true,
```

## Using Pro in Production

Once it’s time to launch your Pro site on a public domain, there are a few things you need to do:

- [Create a Site](#sites) on statamic.com and enter the appropriate domain(s).
- Purchase any required licenses (e.g. Statamic Pro and/or any paid addons) and attach them to your Site.
- Add your Site's license key to your environment file (preferred solution) or Statamic system config.

::tabs
::tab env
```env
STATAMIC_LICENSE_KEY=your-site-license-key
```
::tab config
```php
// config/statamic/system.php
'license_key' => 'your-site-license-key',
```
::

:::tip
If you're using the free version of Statamic and you don't have any commercial addons installed, you don't need to create and link a site. But you can if you want! Being organized is a nice thing.
:::

## Sites

In your [statamic.com account](https://statamic.com/account/sites), you can create "Sites" that are used to organize your licenses (and in the future may provide some other nice features).

Each Site has one unique license key that any and all commercial products are attached to and validated through. No more juggling a fist full of keys like a bunch of quarters at the arcade.

Each license entitles you to run one production installation. You will need to specify the domains you plan to use from the "Sites" area of your Statamic Account. Domains are treated as wildcards so you can use subdomains for locales, testing, and other purposes.

If you attempt to use the site from a domain not listed in your Site settings, you will get a notification inside the Control Panel informing you thusly to make the necessary changes. You may change the domain associated with a license at any time on [statamic.com](https://statamic.com/account/sites).

### Sites API

You can programmatically create sites using our [Sites API](/sites-api). This is most useful while using our [Platform subscription plan](https://statamic.com/pricing/platform).

## License validation

If you want to know about the legal terms you can [read those here](https://statamic.com/license). The rest of this article covers the more _technical_ aspects of the call-home features, domain restrictions, and so forth.

### Phoning Home

Statamic pings The Outpost (our validation web service) on a regular basis. The Outpost collects the license key, public domain info (domain name, IP address, etc), and PHP version so we can validate them against your account.

This happens once per hour, and only when logged into the control panel. Changing your license key setting will trigger an immediate ping to The Outpost. Tampering with outgoing API call will cause Statamic to consider your license invalid. If that happens, you'll need to open a [support request][support] to reinstate your license.

If you need to run Statamic in an environment without an internet connection, please [contact support](https://statamic.com/support).

### Public Domains

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

---
title: Licensing
intro: 'Statamic is **commercial software**. While you 100% own your license and can run Statamic forever, there are a few important terms and rules to cover.'
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1567571073
blueprint: page
id: 56fadb93-b846-4867-ad73-4f721cc940c2
stage: 1
---
## Free vs. Pro

Statamic is available in two flavors: **Free** and **Pro**. You can read about what's included in each on our [blog](https://statamic.com/blog/everything-about-statamic-3).

When you install Statamic, it will be configured to use the free version. You're able to opt into Pro at any time in your `config/statamic/editions.php` file:

``` php
'pro' => true
```

Once you've opted into Pro, additional features will be available.

## Trial Mode

You can use Statamic **Pro** locally without a license key for as long as you'd like. This is called Trial Mode.

As well as trying out Statamic Pro, you're able to try out any commercial addons.

You don't need to do anything to enable Trial Mode. If you're on a [non-public domain](#public-domains), and you've configured Statamic in
a way that would require a license, you'll see the Trial Mode banner in your Control Panel.

## Production

Once it’s time to launch your site on a public domain, there are a few things you need to do:

- [Create a Site](#sites) on statamic.com, and enter the appropriate domains.
- Purchase any required licenses and link them to your Site.
- Add your Site's license key to your Statamic config or environment file.

``` php
// config/statamic/system.php
'license_key' => 'your-site-license-key'
```

``` env
STATAMIC_LICENSE_KEY=your-site-license-key
```

> If you're using the free version of Statamic and you don't have any commercial addons installed, you don't need to create and link a site. But you can if you want!

## Sites

In your [statamic.com account](https://statamic.com/account/sites), you can create "Sites" that are used to organize your licenses (and in the future may provide some other nice features).

Each Site gets a license key which you enter into your Statamic config.

You can then link licenses to a Site, so you don't need to worry about juggling and entering a handful of license keys if you have a bunch of addons.

## License Validation

If you want to know about the legal terms you can read those here. The rest of this article covers the technical aspects of the call-home features, domain restrictions, and so forth.

### Statamic needs to "phone home"

Statamic will ping The Outpost (our validation web service) on a regular basis. The Outpost collects the license key and public domain info (domain name, IP address, etc) and PHP version so we can validate them against your account.

This happens just once an hour and only when logged into the control panel. Changing your license key setting will trigger an immediate ping to the The Outpost. Tampering with outgoing API call will cause Statamic to consider your license invalid. If that happens, you'll need to open a [support request][support] to reinstate your license.

## One License Per Site

A Statamic license entitles you to run one install on one domain and unlimited subdomains. You will need to specify the domain you plan to use from the "Sites" area of your Statamic Account. This domain will be treated as a wildcard so you can use subdomains for locales, testing, and other purposes.

If you attempt to use the site from another domain you will get a notification inside the Control Panel informing you thusly to make the necessary changes. You may change the domain associated with a license at any time on [statamic.com](https://statamic.com).

## Public Domains
When Statamic calls home we use a series of rules to determine if the domain it’s running on is considered “public”.

If any of the following rules match, the domain is considered _not public_ (letting you stay in Trial Mode)

- Is it a single segment? eg. `localhost`
- Is it an IP address?
- Does it use a port other than `80` or `443`?
- Does it have a dev-related subdomain? `test.`, `testing.`, `sandbox.`,  `local.`, `dev.`, `stage.`, or `staging.`
- Does it use a dev-related TLD? `.local`, `.localhost`, `.test`, `.invalid`, `.example`, `.wip`, or `.app`

## Special Circumstances

We understand that sometimes your domains can’t be set up to coincide with our rules exactly because of firewall or client needs, backwards compatibility, SEO, or the humidity level in Denver. We totally get it, and have a solution.

You can comma delimit domains in your licenses page, like so  `mysite.com, mystagingsite.com`. These will be reviewed periodically to ensure they’re not being abused to get around the One License One Website™ rule. But you wouldn’t do that to a little small business, would you?

[support]: https://statamic.com/support

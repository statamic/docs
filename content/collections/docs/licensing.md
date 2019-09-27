---
title: Licensing
intro: 'Statamic is **commercial software**. While you 100% own your license and can run Statamic forever, there are a few important terms and rules to cover.'
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1567571073
blueprint: page
id: 56fadb93-b846-4867-ad73-4f721cc940c2
stage: Drafting
---
## Trial Mode

You can use Statamic locally without a license key for as long as you'd like. This is called Trial Mode.

Once it’s time to launch the site on a public domain, you need to buy a license and add the key to the settings area of the Control Panel (or in `config/statamic/system.php`).

## License Validation

If you want to know about the legal terms you can read those here. The rest of this article covers the technical aspects of the call-home features, domain restrictions, and so forth.

### Statamic needs to "phone home"

Statamic will ping The Outpost (our validation web service) on a regular basis. The Outpost collects the license key and public domain info (domain name, IP address, etc) and PHP version so we can validate them against your account.

This happens just once an hour and only when logged into the control panel. Changing your license key setting will trigger an immediate ping to the The Outpost. Tampering with outgoing API call will cause Statamic to consider your license invalid. If that happens, you'll need to open a [support request][support] to reinstate your license.

## One License Per Site

A Statamic license entitles you to run one install on one domain and unlimited subdomains. You will need to specify the domain you plan to use from the license area of your Statamic Account. This domain will be treated as a wildcard so you can use subdomains for locales, testing, and other purposes.

If you attempt to use the site from another domain you will get a notification inside the Control Panel informing you that your key is being used on more than one site and be prompted to make the necessary changes. You may change the domain associated with a license at any time.

## Public Domains
When Statamic calls home we use a series of rules to determine if the domain it’s running on is considered “public”.

If any of the following rules match, the domain is considered _not public_(letting you stay in Trial Mode)

- Is it a single segment? eg. `localhost`
- Is it an IP address?
- Does it use a port other than `80` or `443`?
- Does it have a dev-related subdomain? `test.`, `testing.`, `sandbox.`,  `local.`, `stage.`, or `staging.`
- Does it use a dev-related TLD? `.local`, `.localhost`, `.test`, `.invalid`, `.example`, `.wip`, or `.app`

## Special Circumstances

We understand that sometimes your domains can’t be set up to coincide with our rules exactly because of firewall or client needs, backwards compatibility, SEO, or the humidity level in Denver. We totally get it, and have a solution.

You can comma delimit domains in your licenses page, like so  `mysite.com, mystagingsite.com`. These will be reviewed periodically to ensure they’re not being abused to get around the One License One Website™ rule. But you wouldn’t do that to a little small business, would you?

[support]: https://statamic.com/support

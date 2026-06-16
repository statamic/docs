---
id: 774b3b8f-a328-469f-ab87-04a41e290ddd
blueprint: page
title: 'Recommended Hosts'
intro: 'A user-curated list of web hosts that do (and don''t) play well with Statamic.'
---
## Our recommendation

We recommend using [Digital Ocean](https://m.do.co/c/6469827e2269) to host most small to medium Statamic sites. Their servers are fast, inexpensive, and we use them ourselves. _**Full disclosure:** that's an affiliate link but we wouldn't recommend them if it wasn't an excellent option._

Some developers choose to pair Digital Ocean with a tool like [Laravel Forge](/deploying/laravel-forge) or [Ploi](/deploying/ploi), which help you provision servers and handle deployments. However, if you're comfortable doing that yourself, then feel free!

## Community recommendations

The rest of this list is maintained by the community. It's a starting point, not an endorsement — your mileage may vary, and any host that meets the [server requirements](/getting-started/requirements) should run Statamic just fine.

Spot something out of date or have a host to add? Use the [feedback link at the bottom of this page](#got-feedback) to submit a pull request. No affiliate links, please.

### Hosts that play nice

These work well with Statamic out of the box.

- [AWS](https://aws.amazon.com/)
- [Azure](https://azure.microsoft.com/)
- [Cyon](https://www.cyon.ch/) - Switzerland
- [Digital Ocean](https://www.digitalocean.com/)
- [Digital Ocean App Platform](https://www.digitalocean.com/products/app-platform/)
- [Digital Pacific](https://www.digitalpacific.com.au/) - Sydney, Australia
- [Exigo](https://www.exigo.ch/) - Switzerland
- [fortrabbit](https://www.fortrabbit.com/) - US & EU
- [Google Cloud Platform](https://cloud.google.com/)
- [Hetzner Cloud](https://www.hetzner.com/cloud)
- [HostGator](https://www.hostgator.com/)
- [Internethelden](https://internethelden.io/) - Germany
- [Metanet](https://www.metanet.ch) - Switzerland
- [MyHost](https://myhost.nz/) - New Zealand & Australia
- [OVH](https://www.ovhcloud.com/) - France & Canada
- [Vultr](https://www.vultr.com/) - Worldwide

#### Paired with a deployment tool

Some developers pair a server provider with a tool like [Laravel Forge](/deploying/laravel-forge) or [Ploi](/deploying/ploi) to provision servers and handle deployments.

- [Laravel Forge](https://forge.laravel.com/) + [Digital Ocean](https://www.digitalocean.com), [Linode](https://www.linode.com), or [Hetzner Cloud](https://www.hetzner.com/cloud)
- [Ploi](https://ploi.io) + [Digital Ocean](https://www.digitalocean.com), [Linode](https://www.linode.com), or [Hetzner Cloud](https://www.hetzner.com/cloud)

### Hosts that don't play nice

You should probably avoid these. It doesn't mean it's impossible, but it'll likely require support tickets to enable PHP modules and meet the [server requirements](/getting-started/requirements).

- [Go Daddy](https://godaddy.com) - doesn't meet server requirements
- [NameCheap](https://namecheap.com)
- [Rackspace Cloud](https://www.rackspace.com/cloud/) - issues with out-of-sync file timestamps and permissions

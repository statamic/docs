---
title: Requirements
intro: Statamic is a modern PHP application built as a [Laravel](https://laravel.com) package, which carries with it the same [server requirements](https://laravel.com/docs/9.x/deployment#server-requirements) as Laravel itself. To manipulate images (resize, crop, etc), you will also need the GD Library or ImageMagick installed on your server.
template: page
id: 792644d2-8bd2-421d-a080-e0be7fca125c
blueprint: page
---
## Server Requirements

To run Statamic you'll need a server meeting the following requirements. These are standard defaults (at minimum) for most modern hosting platforms.

- PHP 8.1 or above
- BCMath PHP Extension
- Ctype PHP Extension
- Exif PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- GD Library or ImageMagick
- Composer

## Recommended Hosts

We recommend using [Digital Ocean][do] to host most small to medium Statamic sites. Their servers are fast, inexpensive, and we use them ourselves. _**Full disclosure:** that's an affiliate link but we wouldn't recommend them if it wasn't an excellent option._

:::tip
We have an install guide on [how to get Statamic running on a typical Digital Ocean droplet](/installing/digital-ocean)
:::

We also maintain a user-contributed [Github repo][hosts] full of other host recommendations.

## Development Environments

All of these requirements are satisfied by the [Laravel Homestead][homestead] virtual machine, which makes it a great local Laravel development environment. Virtual machines aren't for everybody though, so here are a couple of other options.

### MacOS: Laravel Valet

[Laravel Valet][valet] is a development environment for Mac minimalists. No Vagrant, No Apache, No Nginx, No need to manually edit hosts file. It simply maps all the subdirectories in a “web” directory (such as `~/Sites`) to `.test` or `.localhost` domains.

You can even share your sites publicly using local tunnels. We use it ourselves and it’s brilliant.

### Windows: WAMP

[Laragon][laragon] and [WAMP][wamp] are both good choice for those of the Windows persuasion. You may also want to checkout [Laravel Sail](https://laravel.com/docs/8.x/sail), which works well with Statamic or the [Valet for Windows port][valet-windows].



[do]: https://m.do.co/c/6469827e2269
[vultr]: https://www.vultr.com/?ref=7337126
[hosts]: https://github.com/statamic/hosts
[homestead]: https://laravel.com/docs/homestead
[valet]: https://laravel.com/docs/valet
[valet-windows]: https://github.com/cretueusebiu/valet-windows
[wamp]: http://www.wampserver.com/
[laragon]:https://laragon.org/

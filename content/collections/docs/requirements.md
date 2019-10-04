---
title: Requirements
intro: Statamic is a modern PHP application, built as a [Laravel](https://laravel.com) package and has the same server requirements as &mdash; you guessed it &mdash; Laravel itself. If you'd like to work with image assets, you'll also need an image transformation library like GD Library or ImageMagick.
template: page
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1568656760
id: 792644d2-8bd2-421d-a080-e0be7fca125c
blueprint: page
stage: 1
---
## Server Requirements

To run Statamic 3 you'll need a server that meets the following requirements. These are all pretty standard in most modern hosting platforms.

- PHP `>= 7.2.0`
- BCMath PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- GD Library or ImageMagick

## Recommended Hosts

We recommend using [Digital Ocean][do] to host most Statamic sites. Their droplets are fast, inexpensive, and we use them ourselves. _**Full disclosure:** that's an affiliate link but we wouldn't recommend them if they weren't the best._

We also maintain a user-contributed [Github repo][hosts] full of other host recommendations. Take a peek if Digital Ocean isn't right for you.

## Development Environments

All of these requirements are satisfied by the [Laravel Homestead][homestead] virtual machine, which makes it a great local Laravel development environment. Virtual machines aren't for everybody though, so here are a couple of other options.

### MacOS: Laravel Valet

[Laravel Valet][valet] is a development environment for Mac minimalists. No Vagrant, No Apache, No Nginx, No need to manually edit hosts file. It simply maps all the subdirectories in a “web” directory (such as `~/Sites`) to `.test` or `.localhost` domains.

You can even share your sites publicly using local tunnels. We use it ourselves and it’s brilliant.

### Windows: WAMP

We hear [WAMP][wamp] is a good choice for those of the Windows persuasion. We don’t use Windows ourselves so we can’t vouch for it personally, though.

[do]: https://m.do.co/c/6469827e2269
[hosts]: https://github.com/statamic/hosts
[homestead]: https://laravel.com/docs/6.x/homestead
[valet]: https://laravel.com/docs/valet
[wamp]: http://www.wampserver.com/

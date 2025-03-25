---
title: Requirements
intro: Statamic is a modern PHP application built as a [Laravel](https://laravel.com) package, which carries with it the same [server requirements](https://laravel.com/docs/12.x/deployment#server-requirements) as Laravel itself. To manipulate images (resize, crop, etc), you will also need the GD Library or ImageMagick installed on your server.
template: page
id: 792644d2-8bd2-421d-a080-e0be7fca125c
blueprint: page
---
## Server requirements

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

## Development environments

Depending on your operating system, we recommend the following development environments:

### macOS and Windows: Laravel Herd

[Laravel Herd](https://herd.laravel.com) is a blazing fast, native development environment for macOS and Windows. Herd includes `php`, `composer` and `npm` - *almost* everything you need to setup Statamic locally.

We've written [a guide](/installing/laravel-herd) on installing Herd and setting up your Statamic site.

### Linux

To develop locally with Statamic on Linux, you'll need to install `php`, `composer` and `npm`.

If you're using Ubuntu (or another variant of Debian), you may find our [Ubuntu guide](/installing/ubuntu) helpful.

## Recommended hosts

We recommend using [Digital Ocean](https://m.do.co/c/6469827e2269) to host most small to medium Statamic sites. Their servers are fast, inexpensive, and we use them ourselves. _**Full disclosure:** that's an affiliate link but we wouldn't recommend them if it wasn't an excellent option._

Some developers choose to pair Digital Ocean with a tool like [Laravel Forge](/deploying/laravel-forge) or [Ploi](/deploying/ploi), which help you provision servers and handle deployments. However, if you're comfortable doing that yourself, then feel free!

We also maintain a user-contributed [Github repo](https://github.com/statamic/hosts) full of other host recommendations.

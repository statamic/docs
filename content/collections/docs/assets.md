---
title: Assets
intro: >
 Assets are media and document files managed by Statamic. They can be images, videos, PDFs or even zip files and can have fields and content attached to them, just like entries.
template: page
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1568644449
id: 7277432d-bb25-458a-a3a2-a72976b44ad5
blueprint: page
---
## Overview

Assets are the media and document files that you've given Statamic access to. They usually live in folders on your server but can also exist on an [Amazon S3 bucket](https://aws.amazon.com/s3) or other file storage service.

Statamic will scan these files and cache basic meta information (like `width` and `height` for images) about them to speed up interactions and response times.

<figure>
    <img src="/img/assets.png" alt="Assets browser">
    <figcaption>The asset browser browsin' some assets.</figcaption>
</figure>

The Control Panel's asset browser gives you a great view on these files. You can file, sort, and search them, move and rename files, preview media files, and even

Assets are grouped into **containers**, each with its own settings, configurable permissions, and [blueprints](/blueprints). One container might be a local filesystem with upload, download, rename, and move permissions enabled, and another could be a read-only remote S3 bucket or stock image service. It's up to you.

## Asset Fields

_Examples and screenshot of Asset editor_.

## Entries

_How to use assets in your entries (Assets fieldtype)._

## Containers

_How to make and manage asset containers._

## Drivers

_Included drivers, link to how to make custom drivers_.

## Templating

_Examples and link to Assets tag._

## Image Manipulation

_Examples and link to Glide tag_.

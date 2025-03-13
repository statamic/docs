---
id: 61d9e659-10e4-4eed-94b0-c5e639493dfd
title: 'Storing Content in a Database'
intro: 'Statamic stores your content in "flat files" by default, however, as you scale, you might reach a point where a traditional database might work better. In this short article, we''l show you how to move your entries (& other content) into a database.'
template: page
categories:
  - development
  - database
  - laravel
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1622821277
related_entries:
    - 4238bce4-a94b-4d07-96fa-ea77c1d8e48d
---
## Overview

When you create a new Statamic site, it will ask if you want to store content in flat files or in a database. If you change your mind, maybe for performance or workflow reasons, it's really easy to switch.

## Moving content to the database
1. First things first, ensure your database is configured correctly. By default, Statamic sites are configured to use a SQLite database. However, [you're free to change this](https://laravel.com/docs/master/database#configuration) in your `.env`:
    ```
    DB_CONNECTION=sqlite
    # DB_HOST=127.0.0.1
    # DB_PORT=3306
    # DB_DATABASE=laravel
    # DB_USERNAME=root
    # DB_PASSWORD=
    ```
2. Run `php please install:eloquent-driver`. It'll install the [Eloquent Driver](https://github.com/statamic/eloquent-driver) addon, publish it's configuration file and prompt you to select the repositories you wish to move to the database.

    You might find it useful to keep "configuration" repositories as flat files, whilst storing the actual content in the database. For example: moving `entries` to the database but leaving `collections` flat-file.

3. And that's you done! Wasn't that easy?

## Change your mind?
If you change your mind about moving content to the database, you can always move it back. Just use one of the following commands to export your content back into flat-files:

- Assets: `php please eloquent:export-assets`
- Blueprints and Fieldsets: `php please eloquent:export-blueprints`
- Collections: `php please eloquent:export-collections`
- Entries: `php please eloquent:export-entries`
- Forms: `php please eloquent:export-forms`
- Globals: `php please eloquent:export-globals`
- Navs: `php please eloquent:export-navs`
- Revisions: `php please eloquent:export-revisions`
- Taxonomies: `php please eloquent:export-taxonomies`
- Sites: `php please eloquent:export-sites`

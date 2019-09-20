---
title: Configuration
intro: Statamic utilizes standard Laravel config files and `.env` variables for most application-level configuration settings.
template: page
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1568748076
blueprint: page
id: 10d236ff-a80b-4d88-afa8-fe882b0f37a2
---
## Overview

Statamic's main config files can be found in `config/statamic/`. They are PHP files, organized by area of responsibility.

``` files
├── config/statamic/
│   ├── amp.php
│   ├── api.php
│   ├── assets.php
│   ├── cp.php
│   ├── forms.php
│   ├── live_preview.php
│   ├── oauth.php
│   ├── protect.php
│   ├── revisions.php
│   ├── routes.php
│   ├── search.php
│   ├── sites.php
│   ├── stache.php
│   ├── static_caching.php
│   ├── system.php
│   ├── theming.php
│   └── users.php
```

## Environment Variables

It is often helpful to have different configuration values based on the environment where the application is running. For example, you may wish to enable debug mode on your local server but not your production server (a good idea indeed).

In a fresh Statamic installation you'll find an `.env.example` file in the root directory of your application. If you install Statamic via Composer, this file will automatically be renamed to .env. Otherwise, you should rename the file manually.

Your `.env` file **should not** be committed to version control because  each developer or server running your application could require a different environment configuration. Not only that, but it could be security risk in the event an intruder gains access to your version control repository, since any sensitive credentials would get exposed.

Learn more about [Environment Configuration](https://laravel.com/docs/6.x/configuration#environment-configuration) in the Laravel docs.

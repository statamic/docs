---
title: Search
intro: Help your visitors find what they're looking for with search. Use  configurable indexes to fine tune what fields are important, which aren't, and keep results relevant.
template: page
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1568644905
id: 420f083d-99be-4d54-9f81-3c09cb1f97b7
blueprint: page
---
## Overview

Statamic takes a driver-based approach to search. Statamic's native "local" driver requires no additional configuration while the Algolia driver uses the industry-leading search service via API. If you want to use a different platform, custom drivers are there for you.

## Local

The local driver requires no configuration. It uses JSON files to store indexes and will perform searches against them.

## Algolia

Create an account on their site, drop your API credentials into your `.env`, and install the composer dependency:

``` env
ALGOLIA_APP_ID=your-algolia-app-id
ALGOLIA_SECRET=your-algolia-admin-key
```

``` command-line
composer require algolia/algoliasearch-client-php
```

We recommend using a Javascript implementation to communicate directly with them for the frontend of your site, as this will be incredibly fast, and avoids using Statamic as a middleman. You don’t even need to worry about importing data. Statamic will handle that part when indexing.

Here’s a couple of links to get you started:

- [Free Algolia Signup](https://www.algolia.com/)
- [Algolia JavaScript docs](https://www.algolia.com/doc/api-client/getting-started/install/javascript/?language=javascript)
- [Algolia demos](https://community.algolia.com/instantsearch.js/v1/examples/)

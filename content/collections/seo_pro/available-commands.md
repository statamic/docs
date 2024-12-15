---
id: c7b6e4b0-15ac-4301-842f-61cabf36c1e7
blueprint: seo_pro
title: 'Available Commands'
intro: 'The following commands are available to assist with setup or managing entry link metadata, keywords, and embeddings.'
---
## `seo-pro:links-setup`

Asssists with configuring Content Linking features on a new installation. For more information, reading [reading the configuration steps](/seo-pro/content-linking-setup#using-the-seoprolinkssetup-command) within the [Setup & Config](/seo-pro/content-linking-setup) guide.

To run this command, run the following from the root of your project:

```bash
php please seo-pro:links-setup
```

## `seo-pro:analyze-content`

The `analyze-content` command may be used to crawl and generate the required records for each entry within your site.

To run this command, run the following from the root of your project:

```bash
php please seo-pro:analyze-content
```

This command has the same effect as running the following commands, in this order:

```bash
php please seo-pro:scan-links
php please seo-pro:generate-keywords
php please seo-pro:generate-embeddings
```

## `seo-pro:generate-embeddings`

The `generate-embeddings` command may be used to create records within the `seopro_entry_embeddings` database table. This command will call the configured embeddings API.

To create embeddings, run the following from the root of your project:

```bash
php please seo-pro:generate-embeddings
```

This command will *not* regenerate embeddings if the configuration has not changed, or if the entry's content has not changed.

## `seo-pro:generate-keywords`

The `generate-keywords` command may be used to generate records within the `seopro_entry_keywords` database table.

To generate entry keywords, run the following from the root of your project:

```bash
php please seo-pro:generate-keywords
```

This command will *not* regenerate keywords if the configuration has not changed, or if the entry's content has not changed.

## `seo-pro:scan-links`

The `scan-links` command may be used to generate records within the `seopro_entry_links` database table. This command will crawl all eligible entries within your sites and parse their content.

To run this command, run the following from the root of your project:

```bash
php please seo-pro:scan-links
```

This command will *not* regenerate keywords if the configuration has not changed, or if the entry's content has not changed.

## `seo-pro:sync-entry-links`

SEO Pro stores some entry metadata, such as the title and URI, within the `seopro_entry_links` database table for performance reasons. If you are making changes directly within flat-files, this metadata can become out of sync.

To sync entry metadata, run the following from the root of your project:

```bash
php please seo-pro:sync-entry-links
```
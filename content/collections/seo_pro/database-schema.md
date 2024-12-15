---
id: 8b9c92a8-5921-481a-b3ee-d80c673f08fd
blueprint: seo_pro
title: 'Database Schema'
intro: 'SEO Pro requires a database for the Content Linking features. This feature utilizes a number of tables in order to power these features.'
---
## `seopro_entry_links`

**Purpose**: Stores entry metadata, provides results for the Link Manager table.

**Eloquent model**: `Statamic\SeoPro\Models\EntryLink`

| Column | Datatype | Description |
|---|---|---|
| id | Auto-Incrementing Integer | Primary Key |
| entry_id | string | The associated entry's ID. |
| cached_title | string | The entry's title. |
| cached_uri | string | The entry's URI. |
| site | string | The associated site's handle. |
| collection | string | The associated site's handle. |
| content_hash | string | A cache key to prevent excessive content mapping regeneration. |
| analyzed_content | string | The HTML output that was analyzed to produce mappings and keywords. |
| content_mapping | JSON | A mapping of raw fieldtype data to output content. |
| external_link_count | integer | The number of detected external links. |
| internal_link_count | integer | The number of detected internal links. |
| inbound_internal_links | integer | The number of detected internal links originating from other entries. |
| external_links | JSON | A list of external link URLs. |
| internal_links | JSON | A list of internal link URLs. |
| normalized_external_links | JSON | A list of distinct external link URLs, without any fragments or identifiers. |
| normalized_internal_links | JSON | A list of distinct internal link URLs, without any fragments or identifiers. |
| ignored_entries | JSON | A list of entry IDs that will not be suggested to the entry. |
| ignored_phrases | JSON | A list of phrases or keywords that will not be suggested to the entry. |
| created_at | DateTime | The date/time the record was created. |
| updated_at | DateTime | The date/time the record was updated. |

The `content_hash` column is derived from the associated entry's content.

The primary way to create records in this table is by using the `Statamic\SeoPro\Linking\Links\LinkRepository::scanEntry` method.

## `seopro_entry_keywords`

**Purpose**: Stores generated entry keywords.

**Eloquent model**: `Statamic\SeoPro\Models\EntryKeyword`

| Column | Datatype | Description |
|---|---|---|
| id | Auto-Incrementing Integer | Primary Key |
| entry_id | string | The associated entry's ID. |
| site | string | The associated site's handle. |
| collection | string | The associated collection's handle. |
| blueprint | string | The associated blueprint's handle. |
| content_hash | string | A cache key to prevent re-generating entry keywords. |
| meta_keywords | JSON | Keywords extracted from the entry's URL and title. |
| content_keywords | JSON | Keywords extracted from the entry's content .|
| created_at | DateTime | The date/time the record was created. |
| updated_at | DateTime | The date/time the record was updated. |

The `content_hash` column is derived from the associated entry's content.

## `seopro_entry_embeddings`


**Purpose**: Stores generated AI embeddings for entries.

**Eloquent model**: `Statamic\SeoPro\Models\EntryEmbedding`

| Column | Datatype | Description |
|---|---|---|
| id | Auto-Incrementing Integer | Primary Key |
| entry_id | string | The associated entry's ID. |
| site | string | The associated site's handle. |
| collection | string | The associated collection's handle. |
| blueprint | string | The associated blueprint's handle. |
| content_hash | string | A cache key to help prevent re-generating entry embeddings. |
| configuration_hash | string | A cache key to help prevent re-generating entry embeddings. |
| embeddings | JSON | The numeric embedding array. |
| created_at | DateTime | The date/time the record was created. |
| updated_at | DateTime | The date/time the record was updated. |

The `content_hash` column is derived from the associated entry's content. The `configuration_hash` is a hashed composite key, which includes the following information:

* The `Statamic\SeoPro\Contracts\Content\Tokenizer` implementation used to generate embeddings
* The `statamic.seo-pro.linking.openai.token_limit` configuration value
* The `statamic.seo-pro.linking.openai.model` configuration value

## `seopro_global_automatic_links`

**Purpose**: Stores [Global Automatic Links](/seo-pro/global-automatic-links).

**Eloquent model**: `Statamic\SeoPro\Models\AutomaticLink`

| Column | Datatype | Description |
|---|---|---|
| id | Auto-Incrementing Integer | Primary Key |
| site | string | The associated site's handle. |
| is_active | bool | Indicates if the link is active. |
| link_text | string | The link's text. |
| entry_id | nullable string | The associated entry, if available. |
| link_target | string | The link's URL. |
| created_at | DateTime | The date/time the record was created. |
| updated_at | DateTime | The date/time the record was updated. |

## `seopro_site_link_settings`

**Purpose**: Stores custom [Content Linking site configuration](/seo-pro/site-configuration).

**Eloquent model**: `Statamic\SeoPro\Models\SiteLinkSetting`

| Column | Datatype | Description |
|---|---|---|
| id | Auto-Incrementing Integer | Primary Key |
| site | string | The site's handle. |
| keyword_threshold | float | The threshold to use when filtering keyword suggestions. |
| min_internal_links | int | The desired minimum number of internal links. |
| max_internal_links | int | The desired maximum number of internal links. |
| min_external_links | int | The desired maximum number of external links. |
| max_external_links | int | The desired maximum number of external links. |
| prevent_circular_links | bool | Indicates if SEO Pro should work to prevent circular link suggestions. |
| created_at | DateTime | The date/time the record was created. |
| updated_at | DateTime | The date/time the record was updated. |

## `seopro_collection_link_settings`

**Purpose**: Stores custom [Content Linking collection configuration](/seo-pro/collection-configuration).

**Eloquent model**: `Statamic\SeoPro\Models\CollectionLinkSetting`

| Column | Datatype | Description |
|---|---|---|
| id | Auto-Incrementing Integer | Primary Key |
| collection | string | The collection handle. |
| linking_enabled | bool | Indicates if Content Linking is enabled for the collection. |
| allow_linking_across_sites | bool | Indicates if entries within this collection will receive cross-site suggestions in multi-site setups. |
| allow_linking_to_all_collections | bool | Indicates if entries within this collection will receive suggestions from all other collections. If `false`, only entries from collections listed in `linkable_collections` will be used. |
| linkable_collections | JSON | A list of collections to receive entry suggestions from when `allow_linking_to_all_collections` is `false`. |
| created_at | DateTime | The date/time the record was created. |
| updated_at | DateTime | The date/time the record was updated. |
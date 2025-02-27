---
id: 44e6499b-8232-47ff-8853-3d2b2c82e565
blueprint: seo_pro
title: 'Content Linking Setup & Config'
nav_title: 'Setup & Config'
intro: |-
  SEO Pro can help uncover internal linking opportunities across your entries, as well as provide reporting on existing links within your content.

  SEO Pro scans the content of your site and uses artificial intelligence (AI) to create unique embeddings for each of your entries, enabling it to identify related content. Once related content has been found for any given entry, SEO Pro dives deeper, analyzing the content for matching keywords and phrases.

  The more related two entries are, and the more keywords and phrases that overlap, the stronger a suggested link opportunity is. You are in charge of accepting or rejecting all internal link suggestions.
---
Once SEO Pro has been installed, you can begin setting up Content Linking. Content Linking *requires* a database to function, even if the rest of your site is using flat-files.

The simplest way to get started is by using SQLite in your local environment, but you may wish to use another database engine. If you need help with setting up your database connection, consider reading through Laravel's documentation on this topic: [https://laravel.com/docs/database](https://laravel.com/docs/database).

:::tip
While SEO Pro content linking utilizes embeddings, a vector database engine is *not* required in order to use its features.
:::

Content linking also requires an OpenAI compatible embeddings API. You are responsible for API  costs incurred by the use of SEO Pro features. If your site contains a lot of content, you may wish to experiment with different collection and AI model configurations, as well as setup cost control systems within your preferred AI service provider.

The following information is required before continuing:

1. **OpenAI API Key**: An OpenAI API key that will be used to make API requests. If you are using alternate services, please consult their documentation on what may be required. For example, if you are using something like Ollama locally, you may use any value.
2. **OpenAI API Base URI**: If you plan to use the OpenAI API, the default value of "api.openai.com/v1" will be used. If using another service, you will need to locate the API base URI of that service before proceeding. If using Ollama locally, the API base URI might look something like `http://localhost:11434/v1`.
3. **OpenAI Embeddings Model Name**: The name of the model that should be used when generating embeddings for your content.

By default, when using the OpenAI API, SEO Pro will use the `text-embedding-3-small` model. You can find other available models at [https://platform.openai.com/docs/guides/embeddings/embedding-models](https://platform.openai.com/docs/guides/embeddings/embedding-models). You are encouraged to experiment with a subset of your content to determine the best model for your use-case.

If you *not* using the OpenAI API, you are still required to provide a valid model name. Consult the documentation for your preferred service or platform to learn how to configure or retrieve AI model names.

## Using the `seo-pro:links-setup` command


Verify you have completed the following or have access to the required information before continuing:

* A default database connection has been setup and configured *and* is ready to be used
* You have access to an OpenAI (or compatible) API Key
* The API base URI, if using an OpenAI alternative
* The AI embedding model name. This is required if you are *not* using the OpenAI API *or* if you already know you want to use a model other than `text-embedding-3-small` when using the OpenAI API

The simplest way to setup content linking is by running the following command from the root of your project:

```bash
php please seo-pro:links-setup
```


You will be prompted to verify your database setup and provide your API information.

The following is an example of what this process might look like when using the OpenAI API:

```text
> php please seo-pro:links-setup
Content Linking Setup

 Do you have a database connection configured? (yes/no) [no]:
 > yes

 Would you like to publish and run the content linking migrations? (yes/no) [yes]:
 > yes

      INFO  Publishing [seo-pro-migrations] assets.

  <<Migration Output Omitted>>

 Would you like to configure your OpenAI API access? (yes/no) [yes]:
 > yes

 Will you be using an alternative, OpenAI compatible API? (yes/no) [no]:
 > no

 Please enter the API key to make requests:
 > super-secret-api-key

 What AI model would you like to use? [text-embedding-3-small]:
 > text-embedding-3-small

 Would you like to enable content linking? (yes/no) [yes]:
 > yes
```

Alternatively, the process is a bit longer if you are using an OpenAI alternative. The following is example output of configuring SEO Pro content linking to use a local Ollama instance:

```text
> php please seo-pro:links-setup
Content Linking Setup

 Do you have a database connection configured? (yes/no) [no]:
 > yes

 Would you like to publish and run the content linking migrations? (yes/no) [yes]:
 > yes

   INFO  Publishing [seo-pro-migrations] assets.

  <<Migration Output Omitted>>

 Would you like to configure your OpenAI API access? (yes/no) [yes]:
 > yes

 Will you be using an alternative, OpenAI compatible API? (yes/no) [no]:
 > yes

 What is the base URL for the API you will be using?:
 > http://localhost:11434/v1

 Please enter the API key to make requests:
 > some-random-string

 What AI model would you like to use? [text-embedding-3-small]:
 > nomic-embed-text:latest

 Would you like to enable content linking? (yes/no) [yes]:
 > yes
```

## Manually updating the `.env` file


The following environment variables can be set to configure your site's OpenAI API access and model details:

```env
SEO_PRO_OPENAI_BASE_URI=<THE_API_BASE_URI>
SEO_PRO_OPENAI_API_KEY=<API_KEY>
SEO_PRO_OPENAI_MODEL=<MODEL_NAME>
SEO_PRO_LINKING_ENABLED=<true/false>
```

If you'd like to access any of these values within custom code, the following configuration keys may be used:

|.env Value | Configuration Key |
|---|---|
| SEO_PRO_OPENAI_BASE_URI | `statamic.seo-pro.linking.openai.base_uri` |
| SEO_PRO_OPENAI_API_KEY | `statamic.seo-pro.linking.openai.api_key`|
| SEO_PRO_OPENAI_MODEL | `statamic.seo-pro.linking.openai.model` |
| SEO_PRO_EMBEDDING_TOKEN_LIMIT | `statamic.seo-pro.linking.openai.token_limit` |
| SEO_PRO_LINKING_ENABLED | `statamic.seo-pro.linking.enabled` |

## SEO Pro Configuration file updates


If you'd like to manage content linking configuration via. the `config/statamic/seo-pro.php` configuration file, you may publish SEO Pro's configuration file by running the following command from the root of your project:

```bash
php artisan vendor:publish --tag="seo-pro-config"
```

### Updating an existing configuration file

If you are already using SEO Pro and have previously published the configuration file, you can update your existing configuration file with the following content.

```php
<?php

return [

    // Existing SEO Pro configuration.
    // Do not remove these values.
    // ...

    'jobs' => [
        'connection' => env('SEO_PRO_JOB_CONNECTION'),
        'queue' => env('SEO_PRO_JOB_QUEUE'),
    ],

    'linking' => [

        'enabled' => env('SEO_PRO_LINKING_ENABLED', false),

        'openai' => [
            'base_uri' => env('SEO_PRO_OPENAI_BASE_URI', 'api.openai.com/v1'),
            'api_key' => env('SEO_PRO_OPENAI_API_KEY'),
            'model' => env('SEO_PRO_OPENAI_MODEL', 'text-embedding-3-small'),
            'token_limit' => env('SEO_PRO_EMBEDDING_TOKEN_LIMIT', 8000),
        ],

        'keyword_threshold' => 65,

        'prevent_circular_links' => false,

        'internal_links' => [
            'min_desired' => 3,
            'max_desired' => 6,
        ],

        'external_links' => [
            'min_desired' => 0,
            'max_desired' => 3,
        ],

        'suggestions' => [
            'result_limit' => 10,
            'related_entry_limit' => 20,
        ],

        'rake' => [
            'phrase_min_length' => 0,
            'filter_numerics' => true,
        ],

        'drivers' => [
            'embeddings' => \Statamic\SeoPro\Linking\Embeddings\OpenAiEmbeddings::class,
            'keywords' => \Statamic\SeoPro\Linking\Keywords\Rake::class,
            'tokenizer' => \Statamic\SeoPro\Content\Tokenizer::class,
            'content' => \Statamic\SeoPro\Content\ContentRetriever::class,
            'link_scanner' => \Statamic\SeoPro\Linking\Links\LinkCrawler::class,
        ],

        'disabled_collections' => [
        ],

    ],
];
```

### Configuration option reference

There are many configuration options available, and some serve as defaults that can easily be re-used if you manage multiple Statamic sites.

#### `statamic.seo-pro.jobs.*`

Allows you to specify which queue, if any, should be used for SEO Pro jobs.

#### `statamic.seo-pro.linking.enabled`

Determines if Content Linking features are enabled. When set to `false`, the Link Manager and related features will *not* appear in the Control Panel.

#### `statamic.seo-pro.linking.openai.base_uri`

The base URI to use when making OpenAI embedding API requests.

#### `statamic.seo-pro.linking.openai.api_key`

The API key to use when making OpenAI embedding API requests.

#### `statamic.seo-pro.linking.openai.model`

The AI model to use to generate embeddings from entry content.

#### `statamic.seo-pro.linking.openai.token_limit`

Some AI models have a limit to how many tokens they can accept. Adjust this setting if you are using a model that has a lower token limit than the default of `8000`.

#### `statamic.seo-pro.linking.keyword_threshold`

A threshold value that can be used to filter suggested entries based on how relevant keyword and phrases are to the target entry.

A lower value will result in *more* suggestions, but may reduce the quality of the matches. Lower ranked matches may also not be able to be linked automatically as they may not share exact keyword or phrase matches.

This configuration value is a default for Sites, and can be modified by users within the Control Panel.

#### `statamic.seo-pro.linking.prevent_circular_links`

When enabled, SEO Pro will attempt to prevent circular link suggestions.

A circular link suggestion would occur if Entry B is suggested for Entry A, but Entry B already links to Entry A.

This configuration value is a default for Sites, and can be modified by users within the Control Panel.

#### `statamic.seo-pro.linking.internal_links.min_desired`

Specifies a minimum value for the desired number of internal links for any given entry.

This value is used by some indicators within the Control Panel, as well as by the [Global Automatic Links](/seo-pro/global-automatic-links) feature to help make decisions.

This configuration value is a default for Sites, and can be modified by users within the Control Panel.

#### `statamic.seo-pro.linking.internal_links.max_desired`

Specifies a maximum value for the desired number of internal links for any given entry.

This value is used by some indicators within the Control Panel, as well as by the [Global Automatic Links](/seo-pro/global-automatic-links) feature to help make decisions.

This configuration value is a default for Sites, and can be modified by users within the Control Panel.

#### `statamic.seo-pro.linking.external_links.min_desired`

Specifies a minimum value for the desired number of external links for any given entry.

This value is used by some indicators within the Control Panel, as well as by the [Global Automatic Links](/seo-pro/global-automatic-links) feature to help make decisions.

This configuration value is a default for Sites, and can be modified by users within the Control Panel.

#### `statamic.seo-pro.linking.external_links.max_desired`

Specifies a maximum value for the desired number of external links for any given entry.

This value is used by some indicators within the Control Panel, as well as by the [Global Automatic Links](/seo-pro/global-automatic-links) feature to help make decisions.

This configuration value is a default for Sites, and can be modified by users within the Control Panel.

#### `statamic.seo-pro.linking.suggestions.result_limit`

A hard limit on how many results should be returned when finding entries that share similar keywords or phrases. Adjust this value to find a balance between suggestions, relevancy, and performance.

The higher the value, the more suggestions that can be returned.

#### `statamic.seo-pro.linking.suggestions.related_entry_limit`

A hard limit on how many results should be returned when locating similar content based on embeddings. Adjust this value to find a balance between suggestions, relevancy, and performance.

The higher the value, the more suggestions that can be returned.

#### `statamic.seo-pro.linking.rake.phrase_min_length`

Specifies the minimum keyword/phrase length when generating entry keywords.

#### `statamic.seo-pro.linking.rake.filter_numerics`

Determines if numeric values should be filtered out of content when generating entry keywords.

#### `statamic.seo-pro.linking.disabled_collections`

A list of collections that should not have embeddings generated, or appear in link suggestions.
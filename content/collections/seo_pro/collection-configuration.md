---
id: 245b78ff-2860-473d-a700-8c1eaed30d39
blueprint: seo_pro
title: 'Collection Configuration'
intro: 'In addition to the [core Content Linking configuration](/seo-pro/content-linking-setup#seo-pro-configuration-file-updates), SEO Pro allows you to fine-tune linking behavior for each collection as well as decide which collections should not be analyzed.'
---
## Disabling Content Linking features for collections

Depending on how much content your site has, you may wish to disable Content Linking features on some collections for performance reasons or disable analysis on sensitive collections, such as products, orders, or other similar types of data.

There are two ways to disable collections: by updating the PHP configuration file and within the Control Panel.

### Disabling collections within the config file

To disable collections using the PHP configuration file, add the collection handles to the `linking.disabled_collections` value within the configuration file.

Collections disabled this way will *not* be used when generating embeddings and keywords, or when suggesting related content, even if someone somehow enables them through the Control Panel.

```php
<?php

return [

    // Other SEO Pro configuration.

    'linking' => [

        // Other linking configuration.

        'disabled_collections' => [
            'products',
            'orders',
            'feedback',
        ],

    ],
];
```


### Disabling collections within the Control Panel

The second method is through the Statamic Control Panel. From within the SEO Pro Link Manager, activate the dropdown in the upper right-hand corner of the screen to reveal additional options. From the options that appear, select "Collection Linking Behavior":

![Locating Collection Linking Behavior](/img/seo-pro/collection-linking-behavior.png)

From the list of available collections, activate the actions dropdown menu to the right of the collection to update and select "Edit Linking Behavior":

![Editing collection linking behavior](/img/seo-pro/edit-collection-linking-behavior.png)

On the panel that appears, adjust the "Linking Enabled" option to the desired value and click "Save":

![Collection Linking Enabled Setting](/img/seo-pro/collection-allow-linking-toggle.png)

## Restricting collection suggestions

Additionally, SEO Pro allows you to determine *which* collections should be considered when preparing link suggestions. For example, if a site contains a `blog`, `articles`, `pages`, and `knowledge_base` collection, you could configure the `blog` collection to only receive suggestions from the `blog` and `articles` collections, ignoring any other collection. Similarly, if you are using [Multi-site](/multi-site), you can disable suggestions across sites.

On the Collection Linking Behavior page, select the "Edit Linking Behavior" option from the actions menu next to the collection you'd like to update. On the stack panel that appears, you may adjust the following values:

* **Linking Enabled**: Determines if content linking is enabled for the collection.
* **Allow Cross-Site Suggestions**: Determines if SEO Pro should suggest link suggestions across sites when using Multi-site.
* **Allow Suggestions from All Collections**: When toggled to `false`, you will be able to select individual collections that will be used when retrieving suggested content or looking for linking opportunities.

![Restricting collection suggestions](/img/seo-pro/restricting-collection-suggestions.png)

Collection configuration changes made within the Control Panel are stored within the `seopro_collection_link_settings` database table.

## Resetting collection configuration

To reset a collection's configuration to its default values, select the "Reset Collection Settings" from the actions drop-down menu to the right of the desired collection:

![Resetting collection settings](/img/seo-pro/resetting-collection-settings.png)
---
id: c9fd20d2-ab81-44d7-95bc-dff9068daa06
blueprint: seo_pro
title: 'Site Configuration'
---
Site configuration changes may be done within Control Panel. To update a site's content linking configuration, users may navigate to the "Site Linking Behavior" page within the SEO Pro Link Manager:

![Site configuration](/img/seo-pro/site-config-link-manager.png)

## Available configuration options

All available sites will appear on the Site Linking Behavior page. To modify the available site settings, select "Edit Linking Behavior" from the actions menu to the right of the site to update. Once selected, the "Site Linking Behavior" panel will appear:

![Available site options](/img/seo-pro/available-site-options.png)


By default, sites will inherit the following values from the `config/statamic/seo-pro.php` configuration file *until* they are changed within the Control Panel:

* **Keyword Threshold**: A threshold value that can be used to filter suggested entries based on how relevant keyword and phrases are to the target entry. A lower value will result in *more* suggestions, but may reduce the quality of the matches. Lower ranked matches may also not be able to be linked automatically as they may not share exact keyword or phrase matches.
* **Prevent Circular Link Suggestions**: When enabled, SEO Pro will attempt to prevent circular link suggestions. A circular link suggestion would occur if Entry B is suggested for Entry A, but Entry B already links to Entry A.
* **Min. Internal Links**: Specifies a minimum value for the desired number of internal links for any given entry. This value is used by some indicators within the Control Panel, as well as by the [Global Automatic Links](/seo-pro/global-automatic-links) feature to help make decisions.
* **Max Internal Links**: Specifies a maximum value for the desired number of internal links for any given entry. This value is used by some indicators within the Control Panel, as well as by the [Global Automatic Links](/seo-pro/global-automatic-links) feature to help make decisions.
* **Min External Links**: Specifies a minimum value for the desired number of external links for any given entry. This value is used by some indicators within the Control Panel, as well as by the [Global Automatic Links](/seo-pro/global-automatic-links) feature to help make decisions.
* **Max External Links**: Specifies a maximum value for the desired number of external links for any given entry. This value is used by some indicators within the Control Panel, as well as by the [Global Automatic Links](/seo-pro/global-automatic-links) feature to help make decisions.

The following configuration values are managed *per-site*:

* **Ignored Phrases**: A list of keywords or phrases that will be added to the "stop word" list when extracting keywords and phrases from entries.

Site configuration is stored within the `seopro_site_link_settings` database table.

## Resetting site configuration

To reset a sites's configuration to its default values, select the "Reset Site Settings" from the actions drop-down menu to the right of the desired site:

![Resetting site settings](/img/seo-pro/resetting-site-configuration.png)
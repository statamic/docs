---
id: 46995713-fcbc-48ce-b579-e9c950241597
blueprint: seo_pro
title: 'Global Automatic Links'
intro: |-
  Global Automatic Links are an opt-in feature that allows SEO Pro to automatically insert links into your site's rendered output.

  ![Locating Global Automatic Links](/img/seo-pro/locating-automatic-links.png)
---
## Managing Automatic Links

Global Automatic Links may be created and managed within the Global Automatic Links dashboard.

![Global Automatic Link Fields](/img/seo-pro/global-automatic-link-fields.png)

Each global link contains the following information:

* **Link Text**: The text or phrase that will be used to match and insert the link.
* **Link Target**: The URL the link should direct visitors to.
* **Active Link**: Indicates if a link is currently active. Changing this setting will take effect on new, uncached, requests. Changing this setting *does not* currently invalidate existing pages.

## Updating site templates

To have SEO Pro automatically insert links into your site's output, you need to update your template's to use the `seo_pro:content` tag pair, with the `auto_link` parameter set to `true`:

::tabs

::tab antlers
```antlers
{{ seo_pro:content auto_link="true" }}
  <!-- The existing template content. -->
{{ /seo_pro:content }}
```
::tab blade
```blade
<s-seo_pro:content auto_link="true">
  <!-- The existing template content. -->
</s-seo_pro:content>
```
::

With that template change, whenever SEO Pro finds matching text within your site's output, it will work to automatically insert the corresponding link.

## How automatic links are inserted

SEO Pro will use the Global Automatic Link's "Link Text" value to search for matching text within the site's output; only matching text will be converted to a link.

SEO Pro will *not* create a link under the following conditions, even if the output contains matching text:

* The output already contains a link to the automatic link's URL,
* The number of existing links already exceeds the [site's max internal or external link count](/seo-pro/site-configuration#available-configuration-options)
* The matching text was found in an existing link, header, code block, or other ineligible element

## Customizing automatic links

SEO Pro uses templates when creating the link to insert into your site's output. You can override these templates by publishing the associated views with the following command:

```bash
 php artisan vendor:publish --tag=seo-pro-linking-views
```

After the command runs, you will find three new templates within your resources directory:

* `vendor/seo-pro/links/automatic.antlers.html`: Determines the format of Global Automatic Links
* `vendor/seo-pro/links/html.antlers.html`: Determines the format of links inserted into [Text](/fieldtypes/text) and [Textarea](/fieldtypes/textarea) fieldtypes
* `vendor/seo-pro/links/markdown.antlers.html`: Determines the format of links inserted into the [Markdown](/fieldtypes/markdown) fieldtypes

To customize Global Automatc Links, you may edit the `vendor/seo-pro/links/automatic.antlers.html` template.
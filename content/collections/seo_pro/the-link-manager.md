---
id: 17817a33-c361-48dc-90a1-a6ec3f1ec0d9
blueprint: seo_pro
title: 'The Link Manager'
---
The Link Manager provides a birds-eye view of all crawled entries, displaying their internal, external and inbound internal link counts:

![The Link Manager](/img/seo-pro/link-manager.png)

Clicking an entry's title will navigate to the entry's link management page, which contains the following information:

* **Link Suggestions**: Provides a listing of all link suggestions, with options to accept or reject the suggestion, or edit the entry, depending on the current user's permissions. 
* **Related Content**: Provides a listing of all related content, determined by comparing their embeddings. The entries listed here are ultimately what are used to produce the suggestions on the "Link Suggestions" page.
* **Internal Links**:  Provides a listing of all internal links present in the current entry's content.
* **External Links**: Provides a listing of all external links present in the current entry's content.
* **Inbound Internal Links**: Provides a listing of all entries that link to the current entry.

:::tip
Reporting metrics, such as the internal and external link counts, are only calculated using the information available within the `seopro_entry_links` database table. Ingesting data from external providers is not available at this time.
:::

## Link Suggestions

The Link Suggestions page provides a list of suggested internal links for the current entry:

![Link Suggestions](/img/seo-pro/link-suggestions.png)

Each link suggestion will contain the following:

* **Link Text**: The phrase from the current entry that is relevant to the keywords or phrases in common with the suggested entry. Any text highlighted in blue is the specific keyword or phrase that was common between the current entry and the suggested entry.
* **Can Auto Apply**: When true (or checked), this indicates that the suggestion engine may be able to insert the link within the content automatically, without needing manual content edits.
* **Relevancy Score**: A relative score to help gauge how relevant the suggested link is to the current entry. There is no specific range for this score, and the scores should be weighed relative to other suggestion's scores; higher is generally "more relevant".
* **Link Target**: The URI of the suggested entry.
* Suggestion Actions: Contains additional actions that can be taken for the suggestion. The following default actions are available, depending on user permissions:
  * **Edit Entry**: Navigates the user to the edit entry page for the current entry.
  * **Accept Suggestion**: Reveals an interactive link creation panel to accept the current link suggestion. Users may also click the "Link Text" column when "Can Auto Apply" is true.
  * **Ignore Suggestion**: Provides options to ignore the link suggestion.

### Accepting Link Suggestions

Clicking on the Link Text column, or selecting "Accept Suggestion" action within the suggestion's action drop-down menu will reveal the Link Suggestion editor:

![Link Suggestion Editor](/img/seo-pro/link-suggestion-url.png)

There are three main sections of the Link Suggestion editor:

1. **Field to Update**: The specific field that SEO Pro will update if the suggestion is saved.
2. **Link Target**: The URI (or entry) of the link to insert.
3. **Link Text**: Provides an interactive way to select which text from the entry should be converted to a link.

When adjusting the Link Text, a you may mouse over additional words. The editor will highlight the additional words; clicking the word under the mouse cursor will select all highlighted words add they will become part of the inserted link's text:

![Selecting more words for the link text](/img/seo-pro/link-editor-hover.png)

Hovering over words that are already part of the link's text will highlight all words up to the current word *red*. Clicking this word under the cursor will remove those words from the inserted link's text:

![Removing words from the link text](/img/seo-pro/hover-delete-text.png)

You can hold the "shift" key to invert the selection. This is useful to remove words from the beginning of the active phrase:

![Removing words from the beginning of the link text](/img/seo-pro/inverted-selection-shift.png)

Once you are happy with the link target and text, you may click "Save" to have SEO Pro automatically insert the link into the entry's content.

:::tip
There are times when SEO Pro will be unable to automatically insert the desired link into the current entry. This can be caused for a variety of reasons, most of which are attempting to insert into an existing link, or there is punctuation SEO Pro doesn't know how to safely manage. In these scenarios, you will be asked if you'd like to manually update the entry instead.
:::

### Ignoring Link Suggestions

Not all suggestions will be useful. Sometimes this is because a user might not want to link to that specific entry, or they would like a certain phrase or keyword to *not* be suggested. To ignore a suggestion, the you may select the "Ignore Suggestion" from the actions drop-down menu next to the suggestion:

![Ignore suggestion action](/img/seo-pro/ignore-suggestion-action.png)

Once the "Ignore Suggestion" action has been selected, the "Ignore Suggestion" modal will appear with multiple options:

![Ignore suggestion modal](/img/seo-pro/ignore-suggestion-modal.png)

When ignoring a suggestion, you will be prompted to select an action and a scope. These two options work together to make fine-tune future link suggestions.

Available actions and scopes:

* **Do not suggest this entry**: Prevents the entry from being suggested again
  * **Scope: "This entry"**: Prevents the entry from being suggested again for the currently active entry, but allows it to be suggested to *other* entries.
  * **Scope: "All entries in this site"**: Selecting this scope will update the suggested entries "Can Be Suggested" setting, preventing it from being suggested to *any* other entry.
* **Do not suggest this phrase**:
  * **Scope: "This entry"**: Prevents the suggested phrase from being suggested again to the current entry.
  * **Scope: "All entries in this site"**: Adds the suggested phrase to the site's "Ignored Phrases" list.

## Related Content

The "Related Content" page lists other entries that are determined to be related, based on each entry's embeddings. Eligible entries are determined based on the collection's linking settings, as well as the current entries. The maximum number of results returned is governed by the `statamic.seo-pro.linking.suggestions.related_entry_limit` configuration value.

![Related Content Page](/img/seo-pro/related-content-page.png)

This table largely serves as a way to see which entries will be used to create link suggestions on the "Link Suggestions" page.

### Ignoring Related Content

Similar to ignoring link suggestions, you may ignored related content. To ignore related content, users may select the "Not Related" option from the actions drop-down menu next to the listed entry.

Once the "Not Related" option has been selected, the "Ignore Related Content" modal will appear with additional options:

![Ignore Related Content Modal](/img/seo-pro/ignore-related-content-modal.png)

Users may select one of the following scopes when ignoring an entry:

* **This entry**:  Prevents the entry from being suggested again for the currently active entry, but allows it to be suggested to *other* entries.
* **All entries in this site**: Selecting this scope will update the suggested entries "Can Be Suggested" setting, preventing it from being suggested to *any* other entry.

## Internal and External Link Reports

These pages provide a simple list of internal or external links discovered within entry contents.

## Inbound Internal Links

This page provides a list of other entries that link to the current entry.
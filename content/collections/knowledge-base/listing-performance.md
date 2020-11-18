---
title: 'Troubleshooting: Entry Listing Performance'
intro: 'Entry listings in the control panel are feeling a bit sluggish?'
id: 711cf0a0-d392-4c7e-b2ff-93a2b82e1b81
---
By default, Statamic will paginate your entry listing results, as well as limit the visible columns to prevent the loading of extraneous data.

<figure>
    <img src="/img/knowledge-base/listing-performance-example.png" alt="Listing performance example">
</figure>

### Queries & Augmentation

Certain fieldtypes naturally load slower due to how they are being [augmented](/extending/augmentation) and how much data is being fetched.  Relationship fieldtypes can be particularily slow in the context of a listing, due to additional relationship queries on each displayed entry.  If these fields are [unlisted](/fields#common-settings) or have their visibility disabled in the column selector, Statamic will not fetch or augment this data.  For these reasons, it helps to be mindful about which fields you show by default within your listings.

### Pagination

You can also improve listing performance by limiting your `pagination_size` within `config/statamic/cp.php`.  Less data shown on the page ultimately means smaller queries and less augmentation.

### Search

If you find entry search is sluggish, it might be worth looking into creating a custom [search index](/search#indexes) for your collection.  Doing so can drastically improve search query performance.

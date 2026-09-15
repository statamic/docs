---
id: 5e16d45c-5fb5-43e3-b82f-c2f7bbc85264
blueprint: page
title: 'Organizing Collection Listings'
intro: 'Group and reorder the collections in the Control Panel.'
template: page
related_entries:
  - 7202c698-942a-4dc0-b006-b982784efb03
  - 452c268b-b885-4deb-8e46-1cc3ebc66e4f
  - 2ce74b48-d3cc-4b8a-a8d4-f514c0b1d6ff
  - 11434ba8-33f6-4229-b5d7-e4c9c3ea867e
---
## Overview

You can organize collections into named groups, and reorder both the groups and the collections within them.

The [collections listing page](/content-modeling/collections) is currently the only one that can be grouped and reordered.

<figure>
    <img src="/img/collections-listing-groups.webp" alt="The collections listing page split into Marketing, Store, and Other groups" class="u-hide-in-dark-mode">
    <img src="/img/collections-listing-groups-dark.webp" alt="The collections listing page split into Marketing, Store, and Other groups" class="u-hide-in-light-mode">
    <figcaption>The same collections as before, no longer in one long alphabetical run.</figcaption>
</figure>

## Accessing the organizer

You can access the organizer through the **Organize** button in the listing header, next to the list/grid toggle. It's also in the [command palette](/control-panel/command-palette)!

<figure>
    <img src="/img/organize-collections.webp" alt="The Organize Collections screen, showing two groups of collections with drag handles and an Add Group button" class="u-hide-in-dark-mode">
    <img src="/img/organize-collections-dark.webp" alt="The Organize Collections screen, showing two groups of collections with drag handles and an Add Group button" class="u-hide-in-light-mode">
    <figcaption>Sensibly organized collections. This sparks joy.</figcaption>
</figure>

## Organizing a listing

Each group gets its own panel. Collections you haven't sorted yet wait in the **Other** panel at the bottom, trying not to take it personally.

### Creating and deleting groups

**Add Group** adds a group to the bottom of the screen. The pencil icon in a group's header renames it, and the trash icon deletes it. Collections in a deleted group return to **Other**.

### Adding and removing collections

**Add Collection** opens a searchable picker of the collections not already in that group. A collection can only be in one group at a time.

To remove a collection, drag it to **Other** or click the trash icon on its row. Collections that no longer exist appear as **Unavailable**, so you can see what a group still references.

### Reordering

Drag the handle in a group's header to reorder the groups. Drag the handle on a collection's row to move it within a group, or into another one.

### Saving

Click **Save**, or hit <kbd>⌘</kbd> <kbd>S</kbd>.

### Resetting

**Reset Groups** in the organizer header deletes your saved groups, returning the listing to its default state.

## How grouped listings behave

Your listing keeps the order you saved, groups and collections alike. Sorting by a column header still works, though it sorts within each group rather than across the whole listing.

Each group gets its own select-all checkbox, while actions apply to selected rows across all of them.

Empty groups don't appear on the listing, only in the organizer. The grid view is grouped the same way.

## Permissions

Organizing requires the `manage preferences` [permission](/control-panel/permissions).

## Storage

Groups are saved in `resources/preferences.yaml`:

```yaml
resource_indexes:
  collections:
    groups:
      -
        id: V1StGXR8Z5
        title: Marketing
        items:
          - blog
          - case-studies
          - landing-pages
      -
        id: kJ4mZq2LxA
        title: Store
        items:
          - products
          - product-categories
```

Each group's `items` are collection handles. Group `id`s are generated for you, and only need to be unique within the listing.

Groups are site-wide, and not per-user or role.

## Storing groups somewhere else

To store groups elsewhere, point the `statamic.cp.resource_indexes.repository` config value at your own class:

```php
// config/statamic/cp.php

'resource_indexes' => [
    'repository' => \App\ResourceIndexes\DatabaseGroupRepository::class,
],
```

Your class needs to implement the `GroupRepository` contract:

```php
<?php

namespace App\ResourceIndexes;

use Statamic\Contracts\CP\ResourceIndex\GroupRepository;

class DatabaseGroupRepository implements GroupRepository
{
    public function find(string $resourceIndex): ?array
    {
        // Return the saved groups, or null if there aren't any.
    }

    public function save(string $resourceIndex, array $groups): void
    {
        // Save the groups.
    }

    public function delete(string $resourceIndex): void
    {
        // Delete the saved groups.
    }
}
```

Each group is an array with `id`, `title`, and `items` keys, like the YAML above.

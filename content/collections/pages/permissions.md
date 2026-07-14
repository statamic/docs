---
id: 11434ba8-33f6-4229-b5d7-e4c9c3ea867e
blueprint: page
title: Permissions
intro: 'Permissions are the individual abilities you tick when building a role — view entries, edit assets, manage users, and so on.'
template: page
pro: true
related_entries:
  - 5da3761e-cbf9-4faa-bc69-3cc0fab4ff29
  - 3c4e7a62-bd05-4f93-8f03-55cd6ceec6d4
  - 6b691e04-8f28-4eb2-8288-b61433883fe4
  - ff397ebf-4b53-4dbd-b81b-0dec839e0e5f
---
:::tip
Permissions get bundled into [Roles](/roles), which you assign to [users](/users) or [user groups](/user-groups). Developers registering new abilities in PHP should see [Custom Permissions](/control-panel/custom-permissions).
:::

## Overview

A permission is a single capability, identified by a string handle (e.g. `edit blog entries`). You don't assign permissions directly to users — you add them to a [role](/roles), then attach that role to users or groups.

Out of the box Statamic ships with the matrix below. Wildcard handles like `{collection}` or `{site}` expand once per matching item (one permission per collection, site, etc.).

## Statamic's native permissions {#native-permissions}

| Permission                                                | Handle                                       |
| --------------------------------------------------------- | -------------------------------------------- |
| Access the Control Panel                                  | `access cp`                                  |
| Configure Sites                                           | `configure sites`                            |
| Configure Fields                                          | `configure fields`                           |
| Configure Form Fields                                     | `configure form fields`                      |
| Manage Preferences                                        | `manage preferences`                         |
| Access site                                               | `access {site} site`                         |
| Create, edit, and delete collections                      | `configure collections`                      |
| View entries                                              | `view {collection} entries`                  |
| ↳  Edit entries                                           | `edit {collection} entries`                  |
| &nbsp;&nbsp;↳  Create entries                             | `create {collection} entries`                |
| &nbsp;&nbsp;↳  Delete entries                             | `delete {collection} entries`                |
| &nbsp;&nbsp;↳  Publish entries                            | `publish {collection} entries`               |
| &nbsp;&nbsp;↳  Reorder entries                            | `reorder {collection} entries`               |
| &nbsp;&nbsp;↳  Edit other author's entries                | `edit other authors {collection} entries`    |
| &nbsp;&nbsp;&nbsp;&nbsp;↳  Publish other author's entries | `publish other authors {collection} entries` |
| &nbsp;&nbsp;&nbsp;&nbsp;↳  Delete other author's entries  | `delete other authors {collection} entries`  |
| Create, edit, and delete navs                             | `configure navs`                             |
| ↳  View nav                                               | `view {nav} nav`                             |
| &nbsp;&nbsp;↳  Edit nav                                   | `edit {nav} nav`                             |
| Create, edit and delete global sets                       | `configure globals`                          |
| Edit global variables                                     | `edit {global} globals`                      |
| Create, edit and delete taxonomies                        | `configure taxonomies`                       |
| View terms                                                | `view {taxonomy} terms`                      |
| ↳ Edit terms                                              | `edit {taxonomy} terms`                      |
| &nbsp;&nbsp;↳  Create terms                               | `create {taxonomy} terms`                    |
| &nbsp;&nbsp;↳  Delete terms                               | `delete {taxonomy} terms`                    |
| Configure asset containers                                | `configure asset containers`                 |
| View asset container                                      | `view {container} assets`                    |
| ↳  Upload assets                                          | `upload {container} assets`                  |
| ↳  Edit folders                                           | `edit {container} folders`                   |
| ↳  Edit assets                                            | `edit {container} assets`                    |
| &nbsp;&nbsp;↳  Move assets                                | `move {container} assets`                    |
| &nbsp;&nbsp;↳  Rename assets                              | `rename {container} assets`                  |
| &nbsp;&nbsp;↳  Delete assets                              | `delete {container} assets`                  |
| View users                                                | `view users`                                 |
| ↳ Edit users                                              | `edit users`                                 |
| &nbsp;&nbsp;↳ Create users                                | `create users`                               |
| &nbsp;&nbsp;↳ Delete users                                | `delete users`                               |
| &nbsp;&nbsp;↳ Change passwords                            | `change passwords`                           |
| &nbsp;&nbsp;↳ Assign user groups                          | `assign user groups`                         |
| &nbsp;&nbsp;↳ Assign roles                                | `assign roles`                               |
| Edit user groups                                          | `edit user groups`                           |
| Edit roles                                                | `edit roles`                                 |
| Impersonate users                                         | `impersonate users`                          |
| View updates                                              | `view updates`                               |
| Configure forms                                           | `configure forms`                            |
| View form submissions                                     | `view {form} form submissions`               |
| &nbsp;&nbsp;↳ Delete form submissions                     | `delete {form} form submissions`             |
| Configure addons                                          | `configure addons`                           |
| Edit addon settings                                       | `edit {addon} settings`                      |
| Access utility                                            | `access {utility} utility`                   |
| Resolve Duplicate IDs                                     | `resolve duplicate ids`                      |
| View GraphQL                                              | `view graphql`                               |

Need something that isn't in this list? [Register a custom permission](/control-panel/custom-permissions).

## Author permissions

Author permissions are a little bit special. They determine the control users can have over their own entries or those created by other authors.

:::warning Important!
This feature only has any effect if your entry blueprint has an `author` field. If you don't already have an `author` field, this functionality is not available.
:::

## Site permissions

When using the [multi-site](/multi-site) feature, Statamic will check for appropriate site permissions in addition to whatever it's checking.

For example, when you try to edit a `blog` entry in the `french` site, Statamic will check if you have both the `edit blog entries` and `access french site` permissions.

## Super users

[Super users](/users#super-users) bypass the permission matrix entirely. They aren't granted each permission — they skip the checks. Use them sparingly.

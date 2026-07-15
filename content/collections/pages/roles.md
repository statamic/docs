---
id: 5da3761e-cbf9-4faa-bc69-3cc0fab4ff29
blueprint: page
title: Roles
intro: 'Roles are named bundles of permissions you assign to users and user groups — Editors, Authors, Clients, whatever fits your team.'
template: page
pro: true
related_entries:
  - 6b691e04-8f28-4eb2-8288-b61433883fe4
  - 3c4e7a62-bd05-4f93-8f03-55cd6ceec6d4
  - 11434ba8-33f6-4229-b5d7-e4c9c3ea867e
  - ff397ebf-4b53-4dbd-b81b-0dec839e0e5f
  - 55993382-c928-48d0-8559-c88b226d4657
---
:::tip
Need the list of built-in abilities? That's [Permissions](/permissions). Registering your own in PHP? See [Custom Permissions](/control-panel/custom-permissions).
:::

## Overview

A [user](/users) has no Control Panel abilities on their own. You grant access by assigning **roles**, and each role is a named set of [permissions](/permissions).

Think of it as a stack:

1. **Permissions** — individual abilities (`edit blog entries`, `access cp`, …)
2. **Roles** — packages of those abilities ("Editor", "Publisher")
3. **Users / [groups](/user-groups)** — who gets which roles

Roles are managed in the Control Panel under **Users → Roles**, and stored in `resources/users/roles.yaml`.

## Creating roles

Create and edit roles in the Control Panel, or by hand in YAML:

```yaml
# resources/users/roles.yaml
editor:
  title: Editor
  permissions:
    - access cp
    - view blog entries
    - edit blog entries
    - create blog entries
    - publish blog entries
```

Pick permissions from the [native list](/permissions#native-permissions), or from [custom ones](/control-panel/custom-permissions) you've registered.

## Assigning roles

Attach roles to individual [users](/users), or to a [user group](/user-groups) so every member inherits them.

On a user YAML file:

```yaml
roles:
  - editor
  - publisher
```

In the Control Panel: open the user (or group) and pick roles from the list. Prefer groups when you have more than a handful of people with the same access — assign the role once on the group instead of per user.

### In blueprints

Need a field that picks roles? Use the [User Roles](/fieldtypes/user-roles) fieldtype.

### On the frontend

Check the current user's roles with [`{{ user:is }}`](/tags/user-is), or list roles with [`{{ user:roles }}`](/tags/user-roles).

## Super users

[Super users](/users#super-users) bypass roles and permissions entirely. They can do everything — including create more super users. Keep that circle small.

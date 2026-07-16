---
id: 3c4e7a62-bd05-4f93-8f03-55cd6ceec6d4
blueprint: page
title: 'User Groups'
intro: 'User groups let you attach roles to a set of users at once — everyone in the group inherits those permissions.'
template: page
pro: true
related_entries:
  - 6b691e04-8f28-4eb2-8288-b61433883fe4
  - 5da3761e-cbf9-4faa-bc69-3cc0fab4ff29
  - 11434ba8-33f6-4229-b5d7-e4c9c3ea867e
---
:::tip
Groups are about _who_ shares access. For the ability bundles themselves, see [Roles](/roles). For the individual abilities inside those roles, see [Permissions](/permissions).
:::

## Overview

When more than a few people need the same access, don't assign [roles](/roles) to each [user](/users) one by one. Put them in a **user group**, attach the roles to the group once, and every member inherits them.

User groups are managed in the Control Panel under **Users → Groups**, and stored in `resources/users/groups.yaml`.

## Creating groups

Create and edit groups in the Control Panel, or by hand in YAML:

```yaml
# resources/users/groups.yaml
editors:
  title: Editors
  roles:
    - editor
```

Users can belong to multiple groups. Their effective roles are the union of roles assigned directly on the user and roles inherited through every group they're in.

## Assigning users to groups

In the Control Panel: open the user (or the group) and pick the relationship.

On a user YAML file:

```yaml
groups:
  - editors
```

Prefer groups over per-user role assignment whenever the same access pattern applies to a handful of people or more.

### In blueprints

Need a field that picks groups? Use the [User Groups](/fieldtypes/user-groups) fieldtype.

### On the frontend

Check whether the current user is in a group with [`{{ user:in }}`](/tags/user-in), or list groups with [`{{ user:groups }}`](/tags/user-groups).

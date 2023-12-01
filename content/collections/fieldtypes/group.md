---
id: 9780cee8-0732-40b5-bc71-ed846d0c290d
blueprint: fieldtype
title: Group
description: 'Group fields visually and scoped their own key in the data.'
overview: |
  Organize the data by visually grouping related fields and assigning a distinct key to each group for clearer data structuring.
screenshot: fieldtypes/screenshots/group.png
---
## Overview

A group fieldtype is a simple container that holds additional fields you would like grouped visually as well as under a parent key.

## Data Storage

In the screenshot above, the data structure for these fields will be as follows:

```yaml
location:
  address: 123 Main Street
  city: Schenectady
  zip: 12345
```


## Templating

All fields inside a Group will be scoped under their parent key like so:

```
{{ location:address }}, {{ location:city }}, {{ location:zip }}

<!-- Will output... -->
123 Main Street, Schenectady, 1234
```

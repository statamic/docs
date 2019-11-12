---
title: "Nav:Exists"
overview: Test whether a set of parameters will result in a page tree.
id: b0275e02-2a64-4233-a335-1da161f23216
---
It's useful for checking whether or not a certain tree should be displayed.
It uses the same parameters to the `nav` tag.

## Example

```
{{ nav:exists from="/foo" }}
   This will be displayed if the requested nav exists.
{{ /nav:exists }}
```

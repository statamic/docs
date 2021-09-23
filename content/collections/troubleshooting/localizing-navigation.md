---
id: 35c9cd07-f377-4fcb-b02c-72c1925e6fdf
title: 'Localizing Navigation'
template: page
categories:
  - localization
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1622821176
---
> You can use the `php please multisite` to automate converting from a single to a multisite installation.

## Defining Sites

To choose which sites the navigation will be available in, just make sure the file exists in the respective sites' directories as described below.

## Folder Structure

The folder structure will differ from the single site structure explained in the [navigation guide](/navigation). Now, navs should be organized into the respective sites.

The `tree` array will also be relocated into separate files organized into sites. The meta level information will remain in the existing YAML file.

``` files
content/navigation/
|-- nav.yaml
|-- site-one/
|   `-- nav.yaml
`-- site-two/
    `-- nav.yaml
```

<mark>A navigation will be considered unavailable for a particular site if a file doesn't exist in its subdirectory.</mark>

## Trees

The navigation file itself will continue to be responsible for defining things like its name, route, etc.

The "tree" defines the pages and their layout. The tree is what is localized to each site.

``` yaml
# nav.yaml
title: Nav
root: true
collections:
  - pages
  - articles
```

``` yaml
# site-one/nav.yaml
tree: [...]
```

``` yaml
# site-two/nav.yaml
tree: [...]
```

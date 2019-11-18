---
title: 'Localizing Structures'
id: 35c9cd07-f377-4fcb-b02c-72c1925e6fdf
---
> You can use the `php please multisite:migrate` to automate converting from a single to a multisite installation.

## Defining Sites

When using [multiple sites](/multi-site), you'll need to specify in the structure's YAML file which sites this structure can be used in.

``` yaml
# content/collections/blog.yaml
sites:
  - en
  - fr
```

## Folder Structure

The folder structure will differ from the single site structure explained in the [structures guide](/structures). Now, structures should be organized into the respective sites.

The `tree` and `root` values will also be relocated into separate files organized into sites. The meta level information will remain in the existing YAML file.

``` files
content/structures/
|-- nav.yaml
|-- site-one/
|   `-- nav.yaml
`-- site-two/
    `-- nav.yaml
```

<mark>A structure will be considered unavailable for a particular site if a file doesn't exist in its subdirectory.</mark>

## Trees

The structure file itself will continue to be responsible for defining things like its name, route, etc.

The "tree" defines the pages and their layout. The tree is what is localized to each site.

``` yaml
# nav.yaml
title: Nav
expects_root: true
collections:
  - pages
  - articles
sites:
  - site-one
  - site-two
```

``` yaml
# site-one/nav.yaml
root: id
tree: [...]
```

``` yaml
# site-two/nav.yaml
root: id
tree: [...]
```
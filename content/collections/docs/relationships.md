---
title: Relationships
template: page
intro: |
  Content is often related to other content and bits of data. For example, a blog post may have an author and 3 other recommended posts. A product may have a brand and a category. A hot dog may have a bun and some mustard.
id: 8ed04215-9f46-4000-bd67-c71b21b67d85
stage: 4
blueprint: page
---
## Overview

Statamic relationships are defined by storing the ID of one piece of content (an entry, term, or user for example) in a variable on another piece of content. Once linked in this simple but specific way, you can fetch and display the related content by using the variable in your templates.

## Fieldtypes

There are 4 primary fieldtypes that manage relationships. When you use these fieldtypes in your [blueprint](/blueprints), the relationships are automatically resolved on the front-end of your site and you can work directly with the data.

- [Assets](/fieldtypes/assets)
- [Entries](/fieldtypes/entries)
- [Taxonomy](/fieldtypes/taxonomy)
- [Users](/fieldtypes/users)


## Example

Let's use this example product entry to walk through displaying data from the three relationships: photo, author, and related products.

``` yaml
# /content/products/wayne-gretsky-pog-collection.md
title: Wayne Gretsky Pog Collection
price: 2495.00
template: products.show
id: 123-1234-12-4321
photo: products/gretsky-pogs-(2).jpg
author: abc-abcd-ab-dcba
related_products:
  - 789-7890-78-0987
  - abc-1234-bc-4eba
```

### Field Breakdown
- `id` is the unique identifier given to this particular entry
- `photo` is a reference to an asset image of the product (why didn't they clean up that filename?)
- `author` is the id of the user who created this entry
- `related_products` is an array of other product entry ids

### Templating

In this following template example you can see how easy it is to use the data from related entries, assets, and users. You don't need to write queries, request data filter results, or anything complicated. As long as you've used the appropriate [fieldtypes](#fieldtypes) in your [blueprint](/blueprints), the data will be ready and waiting for you to use in your view template.

```
// resources/views/products/show.antlers.html

<div class="product">
  <div class="flex justify-between">
    <h1>{{ title }}</h1>
    <h2 class="text-green">${{ price }}</h2>
  </div>
  <img src="{{ photo:url }}" alt="{{ alt }}">
  <p>Listed by: {{ author:name }}</p>
</div>

<div class="mt-8">
  <h3>Related Products</h3>
  <div class="flex flex-wrap -mx-2">
    {{ related_products }}
    <div class="w-1/2 p-4 border m-2">
      <div class="font-bold">{{ title }}</div>
      <div class="text-green">{{ price }}</div>
      <img src="{{ photo }}" alt="{{ alt }}">
    </div>
    {{ /related_products }}
  </div>
</div>
```

## Manual Fetching

If you _aren't_ using a relationship fieldtype but _do_ have an ID to fetch data from you can use the [get_content tag](/tags/get_content).

```
// You can hardcode the ID
{{ get_content from="123-1234-12-4321" }}
  <a href="{{ url }}">{{ title }}</a>
{{ /get_content }}

// Or pass the variable that holds it
{{ get_content :from="related_id" }}
  <a href="{{ url }}">{{ title }}</a>
{{ /get_content }}
```

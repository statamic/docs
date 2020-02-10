---
title: REST API
id: 2e0d2f8f-319d-4cce-bd90-16d6ad32ad37
---

## Filtering

You may filter results by using the `filter` query parameter.

``` url
/endpoint?filter[{field}:{condition}]={value}
```

You may use the [conditions](/conditions) available to the collection tag. eg. `contains`, `is`, etc. For example:

``` url
/endpoint?filter[title:contains]=awesome&filter[featured]=true
```

This would filter down the results to where the `title` value contains the string `"awesome"`, and the `featured` 
value is `true`. When you omit the condition, it defaults to `is`.



## Sorting

You may sort results by using the `sort` query parameter:

``` url
/endpoint?sort=field
```

You can sort in reverse by prefixing the field with a `-`:

``` url
/endpoint?sort=-field
```

You may sort by multiple fields by comma separating them. The reverse flag can be combined with any field:

``` url
/endpoint?sort=one,-two,three
```

## Selecting Fields

You may specify which top level fields should be included in the response.

```
/endpoint?fields=id,title,content
```

## Pagination

Results will be paginated into 25 items per page by default. You may specify the items per page and which page you are viewing with the `limit` and `page` parameters:

``` url
/endpoint?limit=10&page=1
```

The response will contain your `data`, `links` to easily get next/previous URLs, and `meta` information for more easily creating a paginator.

``` json
{
    "data": [
        {...},
        {...},
    ],
    "links": {
        "first": "/endpoint?limt=10&page=1",
        "last": "/endpoint?limt=10&page=3",
        "prev": null,
        "next": "/endpoint?limt=10&page=2",
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "to": 10,
        "total": 29,
        "per_page": 10,
        "path": "/endpoint",
    }
}
```

---

## Entries

`GET` `/api/collections/{collection}/entries`

Gets entries within a collection.

``` json
{
  "data": [
    {
      "title": "My First Day"
    }
  ],
  "links": {...},
  "meta": {...}
}
```

## Entry

`GET` `/api/collections/{collection}/entries/{id}`

Gets a single entry.

``` json
{
  "data": {
    "title": "My First Day"
  }
}
```


## Taxonomy Terms

`GET` `/api/taxonomies/{taxonomy}/terms`

Gets terms in a taxonomy.

``` json
{
  "data": [
    {
      "title": "Music",
    }
  ],
  "links": {...},
  "meta": {...}
}
```

## Taxonomy Term

`GET` `/api/taxonomies/{taxonomy}/terms/{slug}`

Gets a single taxonomy term.

``` json
{
  "data": {
    "title": "My First Day"
  }
}
```

## Globals

`GET` `/api/globals`

Gets all globals.

``` json
{
  "data": [
    {
      "handle": "global",
      "api_url": "http://example.com/api/globals/global",
      "foo": "bar",
    },
    {
      "handle": "another",
      "api_url": "http://example.com/api/globals/another",
      "baz": "qux",
    }
  ],
}
```

## Global

`GET` `/api/globals/{handle}`

Gets a single global set's variables.

``` json
{
  "data": {
    "handle": "global",
    "api_url": "http://example.com/api/globals/global",
    "foo": "bar",
  }
}
```

## Users

`GET` `/api/users`

Get users.

``` json
{
  "data": [
    {
      "id": "1",
      "email": "john@smith.com",
      "api_url": "http://example.com/api/users/1"
    }
  ],
  "links": {...},
  "meta": {...}
}
```

## User

`GET` `/api/users/{id}`

Get a single user.

``` json
{
  "data": {
    "id": "1",
    "email": "john@smith.com",
    "api_url": "http://example.com/api/users/1"
  }
}
```

## Assets

`GET` `/api/assets/{container}`

Get a container's asset data.

``` json
{
  "data": [
    {
      "id": "main::foo.jpg",
      "url": "/assets/foo.jpg",
      "api_url": "http://example.com/api/assets/main/foo.jpg"
    }
  ],
  "links": {...},
  "meta": {...}
}
```

## Asset

`GET` `/api/assets/{container}/{path}`

Get a single asset's data.

The `path` in the URL should be the relative path from the container's root.

``` json
{
  "data": {
    "id": "main::foo.jpg",
    "url": "/assets/foo.jpg",
    "api_url": "http://example.com/api/assets/main/foo.jpg"
  }
}
```

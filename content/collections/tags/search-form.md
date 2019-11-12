---
title: "Search:Form"
description: How to create a search form.
id: 1ab4aca4-1add-4b41-b40c-4f3e8170fd98
---
There's no special search form tag that you need to use. Simply create a form that performs a GET request to where your results will be listed.

```
<form action="/search-results" method="GET">
  <input type="text" name="q" />
  <button>Search</button>
</form>
```

Assuming that the `{{ search:results }}` tag is on `/search-results`, and that you searched for `majestic stags`, submitting this form will take you to `/search-results?q=majestic+stags`.

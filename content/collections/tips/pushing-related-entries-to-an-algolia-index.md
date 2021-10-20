---
id: 5fcf5a56-c120-4988-a4c7-0c5e942327b7
title: 'Pushing related entries to an Algolia index'
template: page
intro: 'It''s possible to transform the data from Statamic before it gets pushed to an Algolia index, but here''s some help on transforming the data to push related data into the index.'
categories:
  - development
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1622821214
---
Consider the following index in `config/statamic/search.php`:

```php
'videos' => [
    'driver' => 'algolia',
    'searchables' => 'collection:videos',
    'fields' => ['title', 'artwork', 'tags', 'description', 'id', 'author'],
],
```

Here we have 6 fields that we wish to be in our Algolia index. In this instance `author` is a related entry in another collection. If we were to update the index currently, all we'd see is the entry id from the related collection which isn't very helpful to our Algolia search results.

Enter `transformers` - "robots in disguise", I know you just sang that in your head!

If we update our index to include transformers:

```php
'videos' => [
    'driver' => 'algolia',
    'searchables' => 'collection:videos',
    'fields' => ['title', 'artwork', 'tags', 'description', 'id', 'author'],
    'transformers' => [
        'author' => function ($author) {
            $entry = Entry::find($author);
            return [
                'author_name' => "{$entry->author_first_name} {$entry->title}",
            ];
        }
    ]
],
```
We pass the entry id into a function, lookup the entry by its id, we can then push the author name - where our blueprint has `author_first_name` as a field of course.

Happy transforming.

_Contributed by Steven Grant_

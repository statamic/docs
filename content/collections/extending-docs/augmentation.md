---
title: Augmentation
intro: |
  Augmentation is a transformation step in Statamic 3’s data layer which establishes a connection between your front-end and the blueprints defining your content model.
id: af1de577-8f75-4623-a0a3-d4c4c49390aa
stage: 3
---

## What is Augmentation?

Augmentation lets Statamic convert one simple thing into a more complicated thing. If you're familiar with Laravel, you can think of it like a `toArray()` method converting
something into a different representation of itself. However, Augmentation does this in a more on-demand way to prevent extra overhead where possible.

There are two "augmentable" things: Field values, and objects.

### Field Values

A field defined in a Blueprint will have a fieldtype associated with it. The raw value of the field can be converted by its fieldtype.
This is packaged together inside a [Value](#value) object.

For example, an [entries fieldtype](/fieldtypes/entries) will save an array of IDs. Simple strings. The fieldtype will know how to convert those IDs into Entry objects.

### Objects

Classes like `Entry`, `Asset`, and `User` are [Augmentables](#augmentable), which means they're able to convert themselves to a bunch of usable values. Similar to the `toArray` method.

For example, a Statamic Asset may have a path and some alt text. However it also has the ability to check the file size, dimensions, timestamp, and so on.

## Where do items get augmented?

The two main areas where augmentation is leveraged is in Antlers templates, and the API.

### Antlers Templates

Antlers templates handle Augmentable and Value classes.

- When it encounters an [Augmentable](#augmentable) object, it will convert it to its [Augmented](#augmented) counterpart. (Which is filled with Value classes)
- When it encounters a [Value](#value) object, it will know when to augment it.

For example, when you visit an entry's URL, its values are provided to the template as Value objects.
None of the values have been augmented yet. It will only happen if/when the variable is used in the template.

### REST API

Similar to Antlers templates, when viewing an item via the API, you will see its augmented version.

For example, when viewing an Asset, you will get all the extras like filesize, dimensions, etc.

``` json
// /api/endpoint/asset/foo.jpg
{
    "path": "foo.jpg",
    "alt": "a thing",
    "width": 600,
    "height": 400
}
```

If you use the `fields` filtering feature of the API, only the corresponding items will be fetched.
Here, the width and height will never need to be evaluated at all.

``` json
// /api/endpoint/asset/foo.jpg?fields=path,alt
{
    "path": "foo.jpg",
    "alt": "a thing"
}
```


## Value

As mentioned earlier, the `Statamic\Field\Value` class wraps up field's raw value and the fieldtype that defines it. It will allow the [fieldtype](/extending/fieldtypes) to "augment" the value lazily, allowing the performance overhead to happen only when necessary.

An entries field will happily send around a lightweight array of ID strings. It will only try to convert those IDs to entries when it's the right time. No sense in performing unnecessary queries.

The `value` method is used to get the augmented value via the fieldtype. It'll be used under the hood when casting to a string or array. The `raw` method will get the un-augmented value.

``` php
$markdown = new Value('# Heading', 'content', $markdownFieldtype);
$markdown->value();   // '<h1>Heading</h1>'
(string) $markdown;   // '<h1>Heading</h1>'
$markdown->raw();     // '# Heading'
```

``` php
$posts = new Value(['1', '2'], 'posts', $entriesFieldtype);
$posts->value();   // [Entry(1), Entry(2)]
$posts->raw();     // ['1', '2']

foreach ($posts as $entry) {
    // Entry(1), Entry(2)
}
```

## Augmentable

An augmentable object lets Statamic know that it could potentially have more data available to it than at first glance.

For example, a Statamic Asset may have a path and some alt text. However it also has the ability to check the file size, dimensions, timestamp, and so on.
All of these things can be lazy-loadable too. You can imagine the wasted overhead involved in checking for all those things for them to never be used.

A class may be marked as "augmentable" by implementing the `Augmentable` interface.

``` php
use Statamic\Contracts\Data\Augmentable;

class Product implements Augmentable
{
    //
}
```

Rather than manually implementing all of `Augmentable`'s methods, we provide two traits, depending on how you plan to work.

For simple classes, you can use the `HasAugmentedData` trait.

``` php
use Statamic\Contracts\Data\Augmentable;
use Statamic\Data\HasAugmentedData;

class Product implements Augmentable
{
    use HasAugmentedData;

    public function augmentedArrayData()
    {
        return [
            'title' => $this->title,
            'price' => $this->price,
        ];
    }
}
```

However, since you're providing all the augmented values up front, you aren't really gaining anything. It's a nice way to start providing augmentable classes to templates, though.

For more advanced classes, you can use the `HasAugmentedInstance` trait, which lets you define an `Augmented` version of itself (more on that below).

``` php
use Statamic\Contracts\Data\Augmentable;
use Statamic\Data\HasAugmentedInstance;

class Product implements Augmentable
{
    use HasAugmentedInstance;

    public function newAugmentedInstance()
    {
        return new AugmentedProduct($this);
    }
}
```

### Augmentable Methods

| Method | Description |
|--------|-------------|
| `augmentedValue($key)` | Gets a single augmented value by the key. |
| `toAugmentedArray($keys = null)` | Gets an array of augmented values. You can specify which keys or leave it blank for all of them. |
| `toAugmentedCollection($keys = null)` | Same as toAugmentedArray, but you get a collection object. |
| `toShallowAugmentedArray()` | Gets an array of augmented values, but limited to a specific subset of them. See [shallow augmentation](#shallow-augmentation) |
| `toShallowAugmentedCollection()` | Same as toShallowAugmentedArray, but a collection object. |

The difference betwen the array and collection methods are that when casting to JSON, the collection will [shallow augment](#shallow-augmentation) nested values.

## Augmented

Your objects may have "Augmented" counterparts. These classes allow you define which values will be available once augmented.

Take this augmented product class as an example:

``` php
use Statamic\Data\AbstractAugmented;

class AugmentedProduct extends AbstractAugmented
{
    public function keys()
    {
        return [
            'title',
            'price',
            'perceived_price',
        ];
    }

    public function perceivedPrice()
    {
        return BigMacPrice::calculateFor(User::current(), $this->data->price());
    }
}
```

When Statamic tries to retrieve a value from this class, it will check in this order:

- A camelCased method defined on the class (requesting `perceived_price` will look for a `perceivedPrice` method)
- A camelCased method defined on the original class, and wrap it in a Value object.
- A value from the original class's data, and wrap it in a Value object.

You are required to provide a `keys` method, which lets Statamic know all of the potentially available values, used when it tries to retrieve "all" values.

``` php
$augmented->all(); 

// [
//     'title' => 'My Product',
//     'price' => 50,
//     'perceived_price' => 55,
// ]
```

Let's assume that the `perceivedPrice` method performs an intensive operation, like making an API request or a complex calculation. If we were to request a different value, we would be avoiding the overhead entirely.

``` php
$augmented->select(['title', 'price']);

// [
//     'title' => 'My Product',
//     'price' => 50,
// ]
```

As mentioned earlier, the REST API does exactly this. When you request specific fields on the URL, it will be selecting the corresponding augmented values under the hood:

``` php
// Request to /api/endpoint/something?fields=one,two
$augmented->select(['one', 'two']);
```

## Shallow Augmentation

To prevent potentially enormous or unnecessary amounts of deeply nested data being output in a number of places, we have the concept of shallow augmentation, which just displays a subset of the available augmented values. 

For example, in the REST API, if you were to request a entry, you'd see all of its fields, but they will only show a limited, single-depth subset of data.

``` yaml
id: 1
title: My Post
related_posts:
  - 1
  - 2
content: 'The post body content'
```

``` json
{
    "id": "1",
    "title": "My Post",
    "related_posts": [
        {
            "id": "1",
            "title": "My Post",
            "api_url": "/api/collections/posts/entries/1",
        },
        {
            "id": "2",
            "title": "Another Post",
            "api_url": "/api/collections/posts/entries/2",
        }
    ]
}
```

Notice that the `content` and `related_posts` fields do *not* appear in the nested list of entries. You get the basics (there are few more, but kept simple for this example) and enough to make an extra API request if you need it.

Also, as this particular example references itself, not only would it add a lot of extra data to the response, it would create an infinite loop!

We provide a sensible set of fields to include when shallow augmenting, but if you need to add more fields, you can [override](/extending/repositories#custom-data-classes) the `shallowAugmentedArrayKeys` method on the object.

``` php
class CustomEntry extends Entry
{
    protected function shallowAugmentedArrayKeys()
    {
        return ['id', 'title', 'field_i_must_have', 'api_url'];
    }
}
```

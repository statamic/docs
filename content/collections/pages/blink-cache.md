---
title: 'Blink Cache'
template: page
intro: 'The Blink Cache allows you to cache expensive operations for the life of a single request.'
stage: 1
id: 73010f4f-bb62-4feb-a6ff-88031f488db8
---
## Basic Usage

```php
use Statamic\Facades\Blink;

Blink::put('key', 'value');
$value = Blink::get('key'); // value
```

A more powerful method is `once`. It will run a function once and cache the value.

``` php
$expensiveFunction = function() {
   return rand();
});
$blink->once('random', $expensiveFunction); // returns random number
$blink->once('random', $expensiveFunction); // returns the same number
```

Under the hood, it uses [Spatie's Blink package](https://github.com/spatie/blink). You are able to use any of the methods mentioned there.

## Stores

The Blink cache is organized into different "stores", each of which are a separate Blink instances.

You can get your own Blink cache by using the `store` method which could be useful to prevent conflicts with other packages, or if you
plan to use the `flush` methods.

Once you have the instance, you can call the Blink methods on it.

```php
Blink::store('mystore')->put(...);
```

Without explicitly calling the `store` method, any methods will be targeting the "default" store shared across the application.


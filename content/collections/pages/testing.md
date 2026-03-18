---
id: 15db07e8-6e83-4b6e-89bb-d050b5d2c823
blueprint: page
title: Testing
template: page
nav_title: Testing
intro: "There's only one thing better than manual testing... automated testing. Addons are scaffolded with PHPUnit test suites out-of-the-box. Learn how to write & run tests."
---
When you create an addon with the `php please make:addon` command, Statamic will automatically scaffold the necessary files for a PHPUnit test suite:

``` files theme:serendipity-light
tests/
    ExampleTest.php
    TestCase.php
phpunit.xml
```

## The `TestCase`

The `TestCase` class extends Statamic's built-in `AddonTestCase` which is responsible for booting your addon's service provider, amongst other things. 

Under the hood, Statamic's `AddonTestCase` extends [Orchestra Testbench](https://github.com/orchestral/testbench)'s `TestCase` class. Testbench allows you to test against a *real* Laravel application.

If you need to change any config settings for your test suite, like enabling Statamic Pro or configuring the REST API, add a `resolveApplicationConfiguration` method to your `TestCase`:

```php
protected function resolveApplicationConfiguration($app)
{
    parent::resolveApplicationConfiguration($app);

    $app['config']->set('statamic.editions.pro', true);

    $app['config']->set('statamic.api.resources', [
        'collections' => true,
        'navs' => true,
        'taxonomies' => true,
        'assets' => true,
        'globals' => true,
        'forms' => true,
        'users' => true,
    ]);
}
```


## Writing Tests

All of your tests should extend your addon's `TestCase` class, like so:

```php
<?php

namespace Acme\Example\Tests;

use Acme\Example\Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_that_true_is_true(): void
    {
        $this->assertTrue(true);
    }
}
```

For more information on writing tests, please review the [Laravel Testing Documentation](https://laravel.com/docs/13.x/testing).

### The Stache

During tests, any Stache items (like entries, terms, global sets) will be saved inside your `tests/__fixtures__` directory.

However, most of the time, you'll probably want to blow away old content between test runs. To do this, you may add the `PreventsSavingStacheItemsToDisk` trait to your tests:

```php
use Statamic\Testing\Concerns\PreventsSavingStacheItemsToDisk; // [tl! focus]

class ExampleTest extends TestCase
{
	use PreventsSavingStacheItemsToDisk; // [tl! focus]

    // ...
}
```

### Update Scripts

To test an [update script](/addons/building-an-addon#update-scripts), import the `RunsUpdateScripts` trait and call `$this->runUpdateScript()` with your script class.

```php
use Statamic\Testing\Concerns\RunsUpdateScripts; // [tl! focus]

class ExampleTest extends TestCase
{
	use RunsUpdateScripts; // [tl! focus]

    #[Test]
    public function it_does_what_it_needs_to_do()
    {
        $this->runUpdateScript(YourUpdateScript::class); // [tl! focus]
    }
    
    // ...
}
```

:::warning
The `RunsUpdateScripts` trait is only available in Statamic v6.3.0 and above. You may need to bump your minimum supported version to use it.
:::

### Inertia.js

The Control Panel is powered by [Inertia.js](https://inertiajs.com), allowing Statamic to render pages as Vue components instead of traditional Blade views.

To assert an Inertia response, use the `->assertInertia()` macro:

```php
use Inertia\Testing\AssertableInertia as Assert;

$this
    ->get(cp_route('my-addon.index'))
    ->assertInertia(fn (Assert $page) => $page
        ->component('my-addon::Foo')
        ->has('message');
    );
```

For more details, see the [Inertia.js testing documentation](https://inertiajs.com/docs/v2/advanced/testing).

## Running Tests

Once you've written some tests, you can run them using `phpunit`:

```bash
./vendor/bin/phpunit
```

You may run a specific test by passing the `--filter` argument:

```bash
# Runs all tests in the CheckoutTest
./vendor/bin/phpunit --filter=CheckoutTest

# Runs the specific user_cant_checkout_without_payment test
./vendor/bin/phpunit --filter=user_cant_checkout_without_payment

# Runs all tests with checkout in their name.
./vendor/bin/phpunit --filter=checkout
```

### GitHub Actions

When you're using GitHub to store your addon's source code, you can take advantage of GitHub Actions so your addon's tests are run whenever you push to your repository or whenever a pull request is submitted.

Running tests on GitHub Actions (or any CI platform for that matter) saves you running the tests locally after every change and also means you can run your addon's tests against multiple PHP & Laravel versions.

For ease of use, here's an example GitHub Actions workflow:

```yaml
name: Test Suite

on:
  push:
  pull_request:

jobs:
  php_tests:
    strategy:
      matrix:
        php: [8.3, 8.4, 8.5]
        laravel: [12.*, 13.*]
        os: [ubuntu-latest]

    name: ${{ matrix.php }} - ${{ matrix.laravel }}
    
    runs-on: ${{ matrix.os }}

    steps:
      - name: Checkout code
        uses: actions/checkout@v1

      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: ${{ matrix.php }}
          extensions: dom, curl, libxml, mbstring, zip, pcntl, pdo, sqlite, pdo_sqlite, bcmath, soap, intl, gd, exif, iconv, imagick

      - name: Install dependencies
        run: |
          composer require "laravel/framework:${{ matrix.laravel }}" --no-interaction --no-update
          composer install --no-interaction

      - name: Run PHPUnit
        run: vendor/bin/phpunit
```
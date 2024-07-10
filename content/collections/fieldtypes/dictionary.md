---
title: Dictionary
description: Choose from options provided by dictionaries.
intro: Give your users a list of options to choose from. Similar to the Select field, but allows you to read options from YAML or JSON files, or even hit external APIs.
screenshot: fieldtypes/screenshots/dictionary.png
options:
  -
    name: dictionary
    type: array
    description: |
      Configure the dictionary to be used. You may also define any config values which should be passed along to the dictionary. The `dictionary` option accepts both string & array values:

      ```yaml
      # When it's a dictionary without any config fields...
      dictionary: countries

      # When it's a dictionary with config fields...
      dictionary:
        type: countries
        region: Europe
      ```

  -
    name: clearable
    type: boolean
    description: |
      Allow deselecting any chosen option and making null a possible value. Default: `false`.
  -
    name: placeholder
    type: string
    description: |
      Set the non-selectable placeholder text. Default: none.
  -
    name: default
    type: string
    description: |
      Set the default option key. Default: none.
  -
    name: multiple
    type: boolean
    description: >
      Allow multiple selections. Default: `false`.
  -
    name: searchable
    type: boolean
    description: >
      Enable search with suggestions by typing in the select box. Default: `true`.
id: 9b14b5b8-6a7a-4db2-8533-9c78faa0e054
---
## Overview
At a glance, the Dictionary fieldtype is similar to the [Select fieldtype](/fieldtypes/select). However, with the Dictionary fieldtype, options aren't manually defined in a field's config, but rather returned from a PHP class (called a "dictionary").

This can prove to be pretty powerful, since it means you can read options from YAML or JSON files, or even hit an external API. It also makes it easier to share common select options between projects.

## Built-in dictionaries
Statamic includes a few helpful dictionaries right out of the box:

* Countries
* Currencies
* Timezones

## Build your own dictionary
It's really easy to build your own dictionary, it only takes a few minutes:

1. Generate a dictionary class using `php please`:
   ```sh
    php please make:dictionary Provinces
    ```
    If you want to generate a dictionary for an addon, you should use the `--addon` parameter (`--addon=statamic/seo-pro`).

2. In your `app/Dictionaries` directory (or `src/Dictionaries` in the case of an addon), you'll see a new `Provinces` dictionary has been generated:

    ```php
    class Provinces extends Dictionary

        /**
         * Returns a key/value array of options.
         *
         * @param string|null $search
         * @return array
         */
        public function options(?string $search = null): array
        {
            return $this->getItems()
                ->when($search ?? false, function ($collection) use ($search) {
                    return $collection->filter(fn ($item) => str_contains($item['name'], $search));
                })
               ->mapWithKeys(fn ($item) => [$item['slug'] => $item['name']])
                ->all();
        }

       /**
         * Returns a single option.
         *
         * @param string $key
         * @return string|array
         */
        public function get(string $key): string|array
        {
            return $this->getItems()->firstWhere('slug', $key);
        }

        private function getItems(): Collection
        {
            return collect([
                ['name' => 'January', 'slug' => 'january'],
                ['name' => 'February', 'slug' => 'february'],
                ['name' => 'March', 'slug' => 'march'],
                // ...
            ]);
        }
    }
    ```

    * The `options` method should return a key/value array of all options.
      * The `$search` variable will be provided if the user is searching options. Feel free to search the options in whatever way works for you.
    * The `get` method should return a single option.
      * This will be made available when the dictionary field's options are augmented. You're free to return whatever you need here.
     * Optionally, you can also configure "config fields" for the dictionary which will be available in the dictionary's context:

    ```php
        protected function fieldItems()
        {
            return [
                'region' => [
                    'display' => __('Region'),
                    'instructions' => __('statamic::messages.dictionaries_countries_region_instructions'),
                    'type' => 'select',
                    'options' => $this->getCountries()->unique('region')->pluck('region', 'region')->filter()->all(),
                ],
            ];
        }

        public function get(string $key): string|array
        {
            $region = $this->context['region'];

            // ...
        }
    ```

## Data Storage
Dictionary fields will store the "key" of the chosen option or options.

For example, if a dictionary is returning these options:

```php
public function options(?string $search = null): array
{
    return [
        'jan' => 'January',
        'feb' => 'February',
        'mar' => 'March',
    ];
}
```

Your saved data will be:

``` yaml
select: jan
```

## Templating
Dictionary fields will return the "option data" returned by the dictionary's `get` method. The shape of this data differs between dictionaries, but often it'll be an array of data. You can use the [`{{ dump }}` tag](/tags/dump) to determine which variables a dictionary provides.

For example, using the built-in Countries dictionary, your template might look like this:

```yaml
past_vacations:
  - USA
  - AUS
  - CAN
  - DEU
  - GBR
```

```
<ul>
    {{ past_vacations }}
        <li>{{ emoji }} {{ name }}</li>
    {{ /past_vacations }}
</ul>
```

```html
<ul>
    <li>🇺🇸 United States</li>
    <li>🇦🇺 Australia</li>
    <li>🇨🇦 Canada</li>
    <li>🇩🇪 Germany</li>
    <li>🇬🇧 United Kingdom</li>
</ul>
```

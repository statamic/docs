<?php

namespace App\Search\Storybook;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Str;
use Statamic\Search\Searchables\Provider;

class StorybookSearchProvider extends Provider
{
    protected static $handle = 'storybook';

    protected static $referencePrefix = 'storybook';

    public function provide(): Collection|LazyCollection
    {
        return Http::get('https://ui.statamic.dev/index.json')
            ->collect('entries')
            ->filter(fn (array $story) => Str::endsWith($story['id'], ['--docs', '--default']))
            ->unique('title')
            ->map(fn (array $story) => StorybookSearchable::from($story))
            ->map->reference();
    }

    public function contains($searchable): bool
    {
        // TODO: Implement contains() method.
    }

    public function find(array $keys): Collection
    {
        $stories = Http::get('https://ui.statamic.dev/index.json')->collect('entries');

        return collect($keys)->map(fn (string $key) => StorybookSearchable::from($stories->get($key)));
    }
}
<?php

namespace App\Search\Storybook;

use Illuminate\Support\Str;
use Statamic\Contracts\Search\Searchable as SearchableContract;
use Statamic\Search\Searchable;

class StorybookSearchable implements SearchableContract
{
    use Searchable;

    protected string $id;
    protected string $title;

    public static function from(array $component)
    {
        $instance = new static();

        $instance->id = $component['id'];
        $instance->title = Str::after($component['title'], 'Components/');

        return $instance;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function getSearchValue(string $field)
    {
        if ($field === 'title' || $field === 'origin_title' || $field === 'search_title') {
            return $this->title();
        }

        if ($field === 'hierarchy_lvl0') {
            return "UI Components » {$this->title()}";
        }

        if ($field === 'url') {
            return $this->url();
        }

        return null;
    }

    public function url(): string
    {
        return "https://ui.statamic.dev/?path=/docs/{$this->id}";
    }

    public function reference(): string
    {
        return "storybook::{$this->id()}";
    }
}
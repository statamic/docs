<?php

namespace App\Search\Listeners;

use Illuminate\Support\Str;
use Stillat\DocumentationSearch\Events\SearchEntriesCreated;

class SearchEntriesCreatedListener
{
    protected array $escapeProperties = [
        'description',
        'intro',
        'content',
        'search_content',
    ];

    protected function getParentHeadings($headers, $target)
    {
        $hierarchy = [];
        $levels = [];

        $currentLevel = $target->level;

        for ($i = array_search($target, $headers) - 1; $i >= 0; $i--) {
            $header = $headers[$i];

            if ($header->level < $currentLevel) {
                $hierarchy[] = $header;
                $currentLevel = $header->level;
            }
        }

        foreach (array_reverse($hierarchy) as $level) {
            $levels[$level->level] = $level->text;
        }

        return $levels;
    }

    /**
     * Handle the event.
     */
    public function handle(SearchEntriesCreated $event): void
    {
        $collection = $event->entry->collection()->title;

        $headers = [];

        foreach ($event->sections as $section) {
            if ($section->fragment->headerDetails == null) {
                continue;
            }

            $headers[] = $section->fragment->headerDetails;
        }

        foreach ($event->sections as $section) {
            $data = $section->searchEntry->data();
            $category = $collection.' » '.$data['origin_title'];

            $parentHeadings = null;

            if (
                $section->fragment->headerDetails != null &&
                $section->fragment->headerDetails->level >= 3
            ) {
                $header = $section->fragment->headerDetails;

                $parentHeadings = $this->getParentHeadings(
                    $headers,
                    $header
                );
                $parentHeadings[$header->level] = $header->text;
            }

            if ($parentHeadings === null) {
                $parentHeadings = [];

                if ($data['search_title'] != null && $data['origin_title'] != $data['search_title']) {
                    $parentHeadings[1] = $data['search_title'];
                }
            }

            if (count($parentHeadings) > 2) {
                array_shift($parentHeadings);
            }

            $data['hierarchy_lvl0'] = $category;
            $data['hierarchy_lvl1'] = implode(' » ', $parentHeadings);

            if ($data['is_root']) {
                $data['content'] = strip_tags($event->entry->intro ?? $event->entry->description ?? $data['search_content']);
            } else {
                $data['content'] = $data['search_content'] ?? '';
            }

            $data['url'] = $data['search_url'];

            foreach ($this->escapeProperties as $property) {
                if (! $data->has($property)) {
                    continue;
                }

                $data[$property] = e($data[$property]);
            }

            // Clear this out to prevent "too much" from a specific page dominating the results.
            if (! $data['is_root']) {
                $data['origin_title'] = null;
            }

            $section->searchEntry->data($data);
        }
    }
}

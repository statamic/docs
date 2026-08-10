<?php

namespace App\Http\Controllers;

use App\Support\MarkdownUrl;
use Illuminate\Support\Facades\Cache;
use Statamic\Contracts\Entries\Entry as EntryContract;
use Statamic\Facades\Collection;
use Statamic\Facades\Entry;

class LlmsTxtController extends Controller
{
    /**
     * Reference collections, appended after the main docs tree. These hold the bulk of the
     * site — ~400 entries covering every tag, modifier, fieldtype and variable — and an agent
     * that can't see them here has no way to discover that `{{ collection }}` exists.
     */
    private const REFERENCE_COLLECTIONS = [
        'tags',
        'modifiers',
        'fieldtypes',
        'variables',
        'widgets',
        'tips',
        'troubleshooting',
        'resource_apis',
    ];

    public function __invoke()
    {
        $lines = Cache::rememberForever('llms.txt', fn () => $this->build());

        return response(implode("\n", $lines), 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
        ]);
    }

    private function build(): array
    {
        $docsVersion = config('docs.version');

        $lines = [
            '# Statamic Documentation',
            '',
            "> Statamic is a Laravel-powered CMS that stores content in flat files by default. This is the documentation for Statamic {$docsVersion}. Every page listed here is also available as Markdown — the `.md` URLs below return plain Markdown rather than HTML.",
            '',
        ];

        foreach ($this->guide() as $line) {
            $lines[] = $line;
        }

        foreach (self::REFERENCE_COLLECTIONS as $handle) {
            foreach ($this->referenceSection($handle) as $line) {
                $lines[] = $line;
            }
        }

        return $lines;
    }

    /**
     * The main docs, following the full depth of the page tree rather than just each
     * section's immediate children.
     */
    private function guide(): array
    {
        $tree = Collection::find('pages')->structure()->trees()->first()->tree();
        $lines = [];

        foreach ($tree as $section) {
            if (! $children = $section['children'] ?? []) {
                continue;
            }

            if (! $sectionEntry = Entry::find($section['entry'])) {
                continue;
            }

            $lines[] = '## '.$sectionEntry->value('title');

            // Sections lead with an "overview" child whose intro describes the whole section.
            $firstChild = Entry::find($children[0]['entry']);
            if ($firstChild && str_contains($firstChild->slug(), 'overview')) {
                if ($intro = $firstChild->value('intro')) {
                    $lines[] = '> '.$this->oneLine($intro);
                }
            }

            $lines[] = '';

            foreach ($this->flatten($children) as $entry) {
                $lines[] = $this->entryLine($entry);
            }

            $lines[] = '';
        }

        return $lines;
    }

    /**
     * Walk a tree branch to any depth, returning entries in reading order.
     */
    private function flatten(array $branch): array
    {
        $entries = [];

        foreach ($branch as $node) {
            $entry = Entry::find($node['entry'] ?? null);

            if ($entry && $entry->published()) {
                $entries[] = $entry;
            }

            foreach ($this->flatten($node['children'] ?? []) as $descendant) {
                $entries[] = $descendant;
            }
        }

        return $entries;
    }

    private function referenceSection(string $handle): array
    {
        if (! $collection = Collection::find($handle)) {
            return [];
        }

        // "Reference" disambiguates these from the guide sections above, several of which
        // share a name (the "Tags" guide explains tags; "Tags Reference" lists all 97).
        $lines = ['## '.$collection->title().' Reference', ''];

        $entries = $collection->queryEntries()
            ->where('published', true)
            ->orderBy('title', 'asc')
            ->get();

        foreach ($entries as $entry) {
            $lines[] = $this->entryLine($entry);
        }

        $lines[] = '';

        return $lines;
    }

    private function entryLine(EntryContract $entry): string
    {
        $url = $entry->url();

        // Some tree nodes link off-site (ui.statamic.dev, YouTube). Those have no Markdown
        // twin, so they're linked as-is.
        $href = MarkdownUrl::for($url) ?? $url;

        $line = '- ['.$entry->value('title').']('.$href.')';

        if ($description = $entry->value('meta_description')) {
            $line .= ': '.$this->oneLine($description);
        }

        return $line;
    }

    private function oneLine(string $text): string
    {
        return trim(preg_replace('/\s+/', ' ', $text) ?? $text);
    }
}

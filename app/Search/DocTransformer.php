<?php

namespace App\Search;

use Illuminate\Support\Str;
use Stillat\DocumentationSearch\Contracts\DocumentTransformer;
use Stillat\DocumentationSearch\Document\DocumentFragment;

class DocTransformer implements DocumentTransformer
{
    private function normalizeConent($value)
    {
        return str($value)
            ->lower()
            ->explode(' ')
            ->map(fn ($word) => Str::singular($word))
            ->join(' ');
    }

    public function handle(DocumentFragment $fragment, $entry): void
    {
        $fragment->additionalContextData[] = $this->normalizeConent($entry->title);

        // Add some extra details to "additional_context"
        if (Str::containsAll($fragment->content, ['clear', 'cache'])) {
            $fragment->additionalContextData[] = 'delete cache';
        }

        if (Str::contains($fragment->content, 'JS Drivers')) {
            $fragment->additionalContextData[] = 'javascript drivers';
        }
    }
}

<?php

namespace App\Search;

use Illuminate\Support\Str;
use Stillat\DocumentationSearch\Contracts\DocumentTransformer;
use Stillat\DocumentationSearch\Document\DocumentFragment;

class DocTransformer implements DocumentTransformer
{
    public function handle(DocumentFragment $fragment, $entry): void
    {
        // Add some extra details to the "additional_context".
        if (Str::containsAll($fragment->content, ['clear', 'cache'])) {
            $fragment->additionalContextData[] = 'delete cache';
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Statamic\Facades\Collection;
use Statamic\Facades\Entry;

class LlmsTxtController extends Controller
{
    public function __invoke()
    {
        $lines = Cache::rememberForever("llms.txt", function () {
            $tree = Collection::find('pages')->structure()->trees()->first()->tree();
            $lines = ['# Statamic Documentation', ''];

            foreach ($tree as $section) {
                $children = $section['children'] ?? [];

                if (! $children) {
                    continue;
                }

                $sectionEntry = Entry::find($section['entry']);
                $lines[] = '## '.$sectionEntry->value('title');

                $firstChild = Entry::find($children[0]['entry']);
                if ($firstChild && str_contains($firstChild->slug(), 'overview')) {
                    if ($intro = $firstChild->value('intro')) {
                        $lines[] = '> '.str_replace("\n", ' ', $intro);
                    }
                }

                $lines[] = '';

                foreach ($children as $child) {
                    $entry = Entry::find($child['entry']);
                    if (! $entry) {
                        continue;
                    }

                    $url = $entry->url();
                    if (! $url) {
                        continue;
                    }

                    $title = $entry->value('title');
                    $isExternal = str_starts_with($url, 'http');
                    $href = $isExternal ? $url : url($url).'.md';
                    $line = '- ['.$title.']('.$href.')';

                    if ($intro = $entry->value('intro')) {
                        $line .= ': '.str_replace("\n", ' ', $intro);
                    }

                    $lines[] = $line;
                }

                $lines[] = '';
            }

            return $lines;
        });

        return response(implode("\n", $lines), 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
        ]);
    }
}

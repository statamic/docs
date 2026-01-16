<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Statamic\Exceptions\NotFoundHttpException;
use Statamic\Facades\Data;

class DocsMarkdownController extends Controller
{
    public function __invoke(string $uri)
    {
        $markdown = Cache::rememberForever("markdown.$uri", function () use ($uri) {
            $entry = Data::findByUri('/'.$uri);

            throw_unless($entry, new NotFoundHttpException);

            return collect([
                '# '.$entry->value('title'),
                $entry->value('intro'),
                $entry->value('content'),
            ])->filter()->implode("\n\n");
        });

        return response($markdown, 200, [
            'Content-Type' => 'text/markdown; charset=UTF-8',
        ]);
    }
}

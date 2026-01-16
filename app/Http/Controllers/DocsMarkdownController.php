<?php

namespace App\Http\Controllers;

use Statamic\Exceptions\NotFoundHttpException;
use Statamic\Facades\Data;

class DocsMarkdownController extends Controller
{
    public function __invoke(string $uri)
    {
        $entry = Data::findByUri('/'.$uri);

        throw_unless($entry, new NotFoundHttpException);

        $markdown = collect([
            '# '.$entry->value('title'),
            $entry->value('intro'),
            $entry->value('content'),
        ])->filter()->implode("\n\n");

        return response($markdown, 200, [
            'Content-Type' => 'text/markdown; charset=UTF-8',
        ]);
    }
}

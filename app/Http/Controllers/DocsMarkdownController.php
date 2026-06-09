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

        $markdown = $this->appendMdExtensionToInternalLinks($markdown);

        return response($markdown, 200, [
            'Content-Type' => 'text/markdown; charset=UTF-8',
        ]);
    }

    private function appendMdExtensionToInternalLinks(string $markdown): string
    {
        return preg_replace_callback(
            '/(?<!!)\[([^\]]+)\]\(([^)]+)\)/',
            function ($matches) {
                $text = $matches[1];
                $url = $matches[2];

                if ($this->shouldAppendMdExtension($url)) {
                    $url .= '.md';
                }

                return "[$text]($url)";
            },
            $markdown
        );
    }

    private function shouldAppendMdExtension(string $url): bool
    {
        if (preg_match('/^https?:\/\//', $url)) {
            return false;
        }

        if (preg_match('/\.[a-z0-9]{2,4}$/i', $url)) {
            return false;
        }

        return true;
    }
}

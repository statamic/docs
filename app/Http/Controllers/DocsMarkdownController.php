<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Statamic\Exceptions\NotFoundHttpException;
use Statamic\Facades\Data;

class DocsMarkdownController extends Controller
{
    public function __invoke(string $uri = '')
    {
        $uri = $this->normalizeUri($uri);

        $markdown = Cache::rememberForever("markdown.$uri", function () use ($uri) {
            $entry = Data::findByUri($uri);

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

    /**
     * `/index.md` is the conventional Markdown twin of the home page — agents guess it, and
     * appending `.md` to the root URL isn't possible. Everything else maps straight across.
     */
    private function normalizeUri(string $uri): string
    {
        $uri = trim($uri, '/');

        return ($uri === '' || $uri === 'index') ? '/' : '/'.$uri;
    }

    /**
     * Point internal links at their Markdown twins, so an agent following links from one
     * `.md` page stays in Markdown instead of falling back into HTML.
     */
    private function appendMdExtensionToInternalLinks(string $markdown): string
    {
        return preg_replace_callback(
            '/(?<!!)\[([^\]]+)\]\(([^)]+)\)/',
            function ($matches) {
                [, $text, $url] = $matches;

                return "[$text]({$this->markdownUrl($url)})";
            },
            $markdown
        );
    }

    private function markdownUrl(string $url): string
    {
        // Split the fragment/query off first: the extension belongs on the path, so
        // "/tags/collection#parameters" has to become "/tags/collection.md#parameters".
        $path = preg_split('/(?=[#?])/', $url, 2);
        $suffix = $path[1] ?? '';
        $path = $path[0];

        return $this->shouldAppendMdExtension($path) ? $path.'.md'.$suffix : $url;
    }

    private function shouldAppendMdExtension(string $path): bool
    {
        // Empty path means the link was a bare fragment like "#overview".
        if ($path === '') {
            return false;
        }

        // Absolute URLs, protocol-relative URLs, and non-HTTP schemes (mailto:, tel:).
        if (preg_match('/^([a-z][a-z0-9+.-]*:|\/\/)/i', $path)) {
            return false;
        }

        // Already points at a file.
        if (preg_match('/\.[a-z0-9]{2,4}$/i', $path)) {
            return false;
        }

        return true;
    }
}

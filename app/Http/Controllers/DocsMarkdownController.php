<?php

namespace App\Http\Controllers;

use App\Support\MarkdownUrl;
use Illuminate\Http\Request;
use Illuminate\Routing\RedirectController;
use Illuminate\Routing\Router;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Cache;
use Statamic\Exceptions\NotFoundHttpException;
use Statamic\Facades\Data;

class DocsMarkdownController extends Controller
{
    public function __invoke(string $uri = '')
    {
        $uri = $this->normalizeUri($uri);
        $entry = Data::findByUri($uri);

        if (! $entry) {
            return $this->redirectLegacyUri($uri);
        }

        $markdown = Cache::rememberForever("markdown.$uri", function () use ($entry) {
            return collect([
                '# '.$entry->value('title'),
                $entry->value('intro'),
                $entry->value('content'),
            ])->filter()->implode("\n\n");
        });

        $markdown = $this->appendMdExtensionToInternalLinks($markdown);

        $response = response($markdown, 200, [
            'Content-Type' => 'text/markdown; charset=UTF-8',
        ]);

        $response->headers->set('Link', implode(', ', [
            sprintf('<%s>; rel="canonical"; type="text/html"', url($entry->url())),
            sprintf('<%s>; rel="describedby"; type="text/plain"', url('/llms.txt')),
        ]), false);

        return $response;
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
     * Mirror the redirects used by the HTML docs, but keep internal destinations in
     * Markdown. This makes legacy links such as `/users.md` redirect to the canonical
     * `/control-panel/users.md` instead of returning a 404.
     */
    private function redirectLegacyUri(string $uri)
    {
        $request = Request::create($uri, 'GET');
        $route = app(Router::class)->getRoutes()->match($request);

        if (ltrim($route->getActionName(), '\\') !== RedirectController::class) {
            throw new NotFoundHttpException;
        }

        $request->setRouteResolver(fn () => $route);

        $redirect = app(RedirectController::class)(
            $request,
            app(UrlGenerator::class),
        );

        $destination = $redirect->getTargetUrl();
        $destination = MarkdownUrl::for($destination) ?? $destination;

        return redirect()->away($destination, $redirect->getStatusCode());
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

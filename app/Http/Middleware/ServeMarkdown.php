<?php

namespace App\Http\Middleware;

use App\Http\Controllers\DocsMarkdownController;
use App\Support\MarkdownUrl;
use Closure;
use Illuminate\Http\Request;
use Statamic\Facades\Data;
use Symfony\Component\HttpFoundation\AcceptHeader;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class ServeMarkdown
{
    public function __construct(private DocsMarkdownController $markdown) {}

    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->isMethod('GET') && ! $request->isMethod('HEAD')) {
            return $next($request);
        }

        $uri = '/'.trim($request->path(), '/');

        if ($uri === '/') {
            $uri = '';
        }

        $entry = Data::findByUri($uri === '' ? '/' : $uri);

        if (! $entry) {
            return $this->handlePotentialDocsRedirect($request, $next($request));
        }

        $prefersMarkdown = $this->prefersMarkdown($request);

        $response = $prefersMarkdown
            ? ($this->markdown)($uri)
            : $next($request);

        if (! $prefersMarkdown) {
            $response->headers->set('Link', implode(', ', [
                sprintf('<%s>; rel="alternate"; type="text/markdown"', MarkdownUrl::for($entry->url())),
                sprintf('<%s>; rel="describedby"; type="text/plain"', url('/llms.txt')),
            ]), false);
        }

        $response->setVary('Accept', false);

        if ($request->isMethod('HEAD')) {
            $response->setContent('');
        }

        return $response;
    }

    /**
     * When a legacy HTML URL redirects to a documentation entry, point clients that asked
     * for Markdown directly at the destination's Markdown twin. This does not rely on a
     * particular HTTP client retaining its Accept header while following the redirect.
     */
    private function handlePotentialDocsRedirect(Request $request, Response $response): Response
    {
        if (! $response instanceof RedirectResponse) {
            return $response;
        }

        $destination = $response->getTargetUrl();
        $path = parse_url($destination, PHP_URL_PATH);

        if (! is_string($path) || ! Data::findByUri($path)) {
            return $response;
        }

        $response->setVary('Accept', false);

        if ($this->prefersMarkdown($request)) {
            $response->setTargetUrl(MarkdownUrl::for($destination) ?? $destination);
        }

        return $response;
    }

    private function prefersMarkdown(Request $request): bool
    {
        $accept = strtolower((string) $request->header('Accept'));
        $header = AcceptHeader::fromString($accept);

        // A wildcard Accept header should continue to receive the normal HTML response.
        // Negotiate Markdown only when the client explicitly asks for it and prefers it.
        if (! $header->has('text/markdown')) {
            return false;
        }

        $markdown = $header->get('text/markdown');

        return $markdown->getQuality() > 0
            && $request->prefers(['text/markdown', 'text/html']) === 'text/markdown';
    }
}

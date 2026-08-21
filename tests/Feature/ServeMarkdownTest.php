<?php

namespace Tests\Feature;

use App\Http\Middleware\ServeMarkdown;
use Illuminate\Http\Request;
use Tests\TestCase;

class ServeMarkdownTest extends TestCase
{
    public function test_wildcard_accept_returns_html(): void
    {
        $response = $this->get('/control-panel/users', [
            'Accept' => '*/*',
        ]);

        $response->assertOk();
        $response->assertHeader('Content-Type', 'text/html; charset=utf-8');
        $this->assertStringContainsString('<!doctype html>', strtolower($response->getContent()));
    }

    public function test_explicit_markdown_accept_returns_markdown(): void
    {
        $response = $this->get('/control-panel/users', [
            'Accept' => 'text/markdown',
        ]);

        $response->assertOk();
        $response->assertHeader('Content-Type', 'text/markdown; charset=UTF-8');
        $this->assertStringStartsWith('# Users', $response->getContent());
    }

    public function test_browser_accept_returns_html(): void
    {
        $response = $this->get('/control-panel/users', [
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        ]);

        $response->assertOk();
        $response->assertHeader('Content-Type', 'text/html; charset=utf-8');
    }

    public function test_html_pages_include_markdown_alternate_link_header(): void
    {
        $response = $this->get('/control-panel/users', [
            'Accept' => 'text/html',
        ]);

        $response->assertOk();
        $response->assertHeader('Vary', 'Accept');
        $this->assertStringContainsString('rel="alternate"; type="text/markdown"', $response->headers->get('Link'));
    }

    public function test_cached_headers_are_not_duplicated(): void
    {
        $request = Request::create('/control-panel/users', server: [
            'HTTP_ACCEPT' => 'text/html',
        ]);

        $response = app(ServeMarkdown::class)->handle($request, fn () => response('cached', headers: [
            'Link' => '<https://example.com/stale>; rel="alternate"',
            'Vary' => 'Accept',
        ]));

        $link = $response->headers->get('Link');

        $this->assertStringNotContainsString('example.com/stale', $link);
        $this->assertSame(1, substr_count($link, 'rel="alternate"'));
        $this->assertSame(1, substr_count($link, 'rel="describedby"'));
        $this->assertSame(['Accept'], $response->getVary());
    }

    public function test_legacy_url_with_markdown_accept_redirects_to_markdown_twin(): void
    {
        $response = $this->get('/users', [
            'Accept' => 'text/markdown',
        ]);

        $response->assertRedirect();
        $this->assertStringEndsWith('/control-panel/users.md', $response->headers->get('Location'));
    }

    public function test_index_md_serves_home_page(): void
    {
        $response = $this->get('/index.md');

        $response->assertOk();
        $response->assertHeader('Content-Type', 'text/markdown; charset=UTF-8');
        $response->assertHeaderMissing('Set-Cookie');
        $this->assertStringStartsWith('# Home', $response->getContent());
    }
}

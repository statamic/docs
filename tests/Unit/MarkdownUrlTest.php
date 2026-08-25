<?php

namespace Tests\Unit;

use App\Support\MarkdownUrl;
use Tests\TestCase;

class MarkdownUrlTest extends TestCase
{
    public function test_maps_docs_path_to_markdown_twin(): void
    {
        $this->assertSame(
            url('/tags/collection.md'),
            MarkdownUrl::for('/tags/collection')
        );
    }

    public function test_preserves_fragment_and_query(): void
    {
        $this->assertSame(
            url('/tags/collection.md#parameters'),
            MarkdownUrl::for('/tags/collection#parameters')
        );

        $this->assertSame(
            url('/tags/collection.md?foo=bar'),
            MarkdownUrl::for('/tags/collection?foo=bar')
        );
    }

    public function test_home_page_uses_index_md(): void
    {
        $this->assertSame(
            url('/index.md'),
            MarkdownUrl::for('/')
        );
    }

    public function test_returns_null_for_external_urls(): void
    {
        $this->assertNull(MarkdownUrl::for('https://example.com/docs'));
        $this->assertNull(MarkdownUrl::for('mailto:hello@example.com'));
    }

}

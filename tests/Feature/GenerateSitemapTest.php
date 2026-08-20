<?php

namespace Tests\Feature;

use DOMDocument;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Tests\TestCase;

class GenerateSitemapTest extends TestCase
{
    private string $temporaryPublicPath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->temporaryPublicPath = storage_path('framework/testing/public-'.Str::uuid());

        File::ensureDirectoryExists($this->temporaryPublicPath);

        $this->app->usePublicPath($this->temporaryPublicPath);
    }

    protected function tearDown(): void
    {
        File::deleteDirectory($this->temporaryPublicPath);

        parent::tearDown();
    }

    public function test_it_generates_a_valid_public_sitemap(): void
    {
        $this->artisan('sitemap:generate')
            ->expectsOutput('Generated public/sitemap.xml')
            ->assertSuccessful();

        $path = public_path('sitemap.xml');

        $this->assertFileExists($path);

        $document = new DOMDocument;

        $this->assertTrue($document->load($path));
        $this->assertSame('urlset', $document->documentElement->localName);
        $this->assertSame('http://www.sitemaps.org/schemas/sitemap/0.9', $document->documentElement->namespaceURI);
        $this->assertGreaterThan(0, $document->getElementsByTagName('url')->length);
    }
}

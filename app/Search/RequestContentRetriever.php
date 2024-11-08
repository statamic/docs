<?php

namespace App\Search;

use DOMDocument;
use Illuminate\Http\Request;
use Statamic\Contracts\Entries\Entry;
use Statamic\Facades\Cascade;
use Stillat\DocumentationSearch\Contracts\ContentRetriever;

class RequestContentRetriever implements ContentRetriever
{
    public function getContent(Entry $entry): string
    {
        $originalRequest = app('request');
        $request = tap(Request::capture(), function ($request) {
            app()->instance('request', $request);
            Cascade::withRequest($request);
        });

        $content = '';

        try {
            $content = $entry->toResponse($request)->getContent();
        } finally {
            app()->instance('request', $originalRequest);
        }

        return $this->extractArticleContent($content);
    }

    protected function extractArticleContent(string $content): string
    {
        $dom = new DOMDocument;

        libxml_use_internal_errors(true);
        $dom->loadHTML($content);
        libxml_clear_errors();

        $articles = $dom->getElementsByTagName('article');

        $result = '';

        foreach ($articles as $article) {
            $result .= $dom->saveHTML($article);
        }

        return $result;
    }
}

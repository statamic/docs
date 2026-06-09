<?php

use App\Http\Controllers\LlmsTxtController;
use App\Http\Controllers\DocsMarkdownController;
use Statamic\Facades\Entry;

Route::get('llms.txt', LlmsTxtController::class);
Route::get('{any}.md', DocsMarkdownController::class)->where('any', '.*');

Route::statamic('search-results', 'search', ['hide_sidebar' => true]);
Route::statamic('sitemap.xml', 'sitemap', ['content_type' => 'xml', 'layout' => 'sitemap']);

Route::get('versions.json', fn () => config('docs.versions'));

Route::get('/from/{id?}', function ($id = null) {
    if (! $id) {
        return redirect()->to('/');
    }

    $entry = Entry::find($id);

    if (! $entry) {
        return redirect()->to('/');
    }

    return redirect()->to($entry->url());
});

require __DIR__.'/redirects.php';

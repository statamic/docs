<?php

use Statamic\Facades\Entry;

Route::statamic('search-results', 'search', ['hide_sidebar' => true]);
Route::statamic('sitemap.xml', 'sitemap', ['content_type' => 'xml', 'layout' => 'sitemap']);

// Redirects
Route::permanentRedirect('collections-and-entries', 'collections');
Route::permanentRedirect('template-engines', 'blade-templates');
Route::permanentRedirect('entries', 'collections#entries');
Route::permanentRedirect('git-itegration', 'git-automation');
Route::permanentRedirect('installation', 'installing');
Route::permanentRedirect('blade-templates', 'blade');
Route::permanentRedirect('fieldtypes/partial', '/blueprints#importing-fieldsets');
Route::permanentRedirect('cascade', 'data-inheritance');
Route::permanentRedirect('using-front-end-frameworks', 'javascript-frameworks');
// Route::permanentRedirect('extending/queries', 'content-queries');

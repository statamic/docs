<?php

Route::statamic('search-results', 'search', ['hide_sidebar' => true]);
Route::statamic('sitemap.xml', 'sitemap', ['content_type' => 'xml', 'layout' => 'sitemap']);

// Redirects

Route::permanentRedirect('collections-and-entries', 'collections');
Route::permanentRedirect('template-engines', 'blade-templates');
Route::permanentRedirect('entries', 'collections#entries');
Route::permanentRedirect('git-integration', 'git-automation');
Route::permanentRedirect('installation', 'installing');
Route::permanentRedirect('blade-templates', 'blade');
Route::permanentRedirect('fieldtypes/partial', '/blueprints#importing-fieldsets');
Route::permanentRedirect('cascade', 'data-inheritance');
Route::permanentRedirect('content-api', 'rest-api');
Route::permanentRedirect('using-front-end-frameworks', 'javascript-frameworks');
Route::permanentRedirect('/content-queries/{slug}', '/repositories/{slug}');
Route::permanentRedirect('repositories', 'content-queries');
Route::permanentRedirect('new-antlers-parser', 'antlers');
Route::permanentRedirect('/tips/storing-entries-in-a-database', '/tips/building-your-own-entries-repository');
// Route::permanentRedirect('extending/queries', 'content-queries');

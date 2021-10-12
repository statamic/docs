<?php

Route::statamic('search-results', 'search', ['hide_sidebar' => true]);
Route::statamic('sitemap.xml', 'sitemap', ['content_type' => 'xml', 'layout' => 'sitemap']);
Route::permanentRedirect('collections-and-entries', 'collections');
Route::permanentRedirect('template-engines', 'blade-templates');
Route::permanentRedirect('entries', 'collections#entries');
Route::permanentRedirect('git-itegration', 'git-automation');
Route::permanentRedirect('installation', 'installing');
Route::permanentRedirect('blade-templates', 'blade');

Route::redirect('fieldtypes/partial', '/blueprints#importing-fieldsets');
Route::permanentRedirect('cascade', 'data-inheritance');
Route::permanentRedirect('using-front-end-frameworks', 'javascript-frameworks');

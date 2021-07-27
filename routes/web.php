<?php

Route::statamic('/', 'home', ['load' => '/documentation']);

Route::statamic('search-results', 'search', ['hide_sidebar' => true]);
Route::redirect('screencasts', '/screencasts/installation');
Route::permanentRedirect('collections-and-entries', 'collections');
Route::permanentRedirect('entries', 'collections#entries');
Route::permanentRedirect('installation', 'installing');

Route::redirect('fieldtypes/partial', '/blueprints#importing-fieldsets');

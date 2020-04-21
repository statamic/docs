<?php

Route::statamic('/', 'home', ['load' => '/documentation']);

Route::statamic('search-results', 'search');
Route::statamic('screencasts', 'screencasts');
Route::statamic('knowledge-base', 'knowledge-base.index');
Route::permanentRedirect('collections-and-entries', 'collections');

Route::redirect('fieldtypes/partial', '/blueprints#importing-fieldsets');

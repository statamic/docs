<?php

Route::statamic('search-results', 'search');
Route::statamic('screencasts', 'screencasts');
Route::statamic('knowledge-base', 'knowledge-base.index');

Route::permanentRedirect('entries', 'collections-and-entries');
Route::permanentRedirect('collections', 'collections-and-entries');

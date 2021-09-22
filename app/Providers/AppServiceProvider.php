<?php

namespace App\Providers;

use App\Markdown\Hint\HintExtension;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
// use App\Http\View\Composers\SideNavComposer;
use Statamic\Facades\Markdown;
use Torchlight\Commonmark\TorchlightExtension;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // View::composer('partials.side-nav', SideNavComposer::class);

        Markdown::addExtensions(function () {
            return [new HintExtension, new TorchlightExtension];
        });
    }

    /**
    * Register any application services.
    *
    * @return void
    */
    public function register()
    {
        //
    }
}

<?php

namespace App\Providers;

use App\Markdown\Hint\HintExtension;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Statamic\Facades\Markdown;
use Torchlight\Commonmark\TorchlightExtension;
use League\CommonMark\Extension\Attributes\AttributesExtension;

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
            return [new HintExtension, new AttributesExtension];
        });

        if (config('torchlight.token')) {
            Markdown::addExtensions(function () {
                return [new TorchlightExtension];
            });
        }
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

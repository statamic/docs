<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
// use App\Http\View\Composers\SideNavComposer;
use Statamic\Facades\Markdown;
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
            return [new AttributesExtension];
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

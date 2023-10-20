<?php

namespace App\Providers;

use Statamic\Facades\Markdown;
use App\Markdown\Hint\HintExtension;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use League\CommonMark\MarkdownConverter;
use App\Http\View\Composers\SideNavComposer;
use Torchlight\Commonmark\V2\TorchlightExtension;
use League\CommonMark\Extension\Attributes\AttributesExtension;
use League\CommonMark\Extension\DescriptionList\DescriptionListExtension;



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
            return [new DescriptionListExtension, new HintExtension, new AttributesExtension];
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

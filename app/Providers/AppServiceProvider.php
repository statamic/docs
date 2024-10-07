<?php

namespace App\Providers;

use App\Markdown\Hint\HintExtension;
use Illuminate\Support\ServiceProvider;
use League\CommonMark\Extension\Attributes\AttributesExtension;
use League\CommonMark\Extension\DescriptionList\DescriptionListExtension;
use Statamic\Facades\Markdown;
use Torchlight\Commonmark\V2\TorchlightExtension;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Markdown::addExtensions(function () {
            return [new DescriptionListExtension(), new HintExtension(), new AttributesExtension()];
        });

        if (config('torchlight.token')) {
            Markdown::addExtensions(function () {
                return [new TorchlightExtension()];
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

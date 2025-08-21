<?php

namespace App\Providers;

use App\Http\View\Composers\SideNavComposer;
use App\Markdown\Hint\HintExtension;
use App\Markdown\Tabs\TabbedCodeBlockExtension;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use League\CommonMark\Extension\Attributes\AttributesExtension;
use League\CommonMark\Extension\DescriptionList\DescriptionListExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use Statamic\Facades\Markdown;
use Torchlight\Engine\CommonMark\Extension as TorchlightExtension;
use Torchlight\Engine\Options as TorchlightOptions;

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
            return [new DescriptionListExtension, new HintExtension, new TabbedCodeBlockExtension, new AttributesExtension, new HeadingPermalinkExtension];
        });

        if (! app()->runningConsoleCommand('search:update')) {
            TorchlightOptions::setDefaultOptionsBuilder(fn() => TorchlightOptions::fromArray(config('torchlight.options')));

            $extension = new TorchlightExtension(config('torchlight.theme'));
            $extension
                ->renderer()
                ->setDefaultGrammar(config('torchlight.options.defaultLanguage'));

            Markdown::addExtension(fn () => $extension);
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

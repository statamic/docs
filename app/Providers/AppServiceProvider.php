<?php

namespace App\Providers;

use App\Markdown\Hint\HintExtension;
use App\Markdown\Tabs\TabbedCodeBlockExtension;
use App\Search\Listeners\SearchEntriesCreatedListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use League\CommonMark\Extension\Attributes\AttributesExtension;
use League\CommonMark\Extension\DescriptionList\DescriptionListExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use Statamic\Facades\Markdown;
use Statamic\Http\View\Composers\JavascriptComposer;
use Statamic\Statamic;
use Stillat\DocumentationSearch\Events\SearchEntriesCreated;
use Torchlight\Engine\CommonMark\Extension as TorchlightExtension;
use Torchlight\Engine\Options as TorchlightOptions;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Markdown::addExtensions(function () {
            return [new DescriptionListExtension, new HintExtension, new TabbedCodeBlockExtension, new AttributesExtension, new HeadingPermalinkExtension];
        });

        if (! app()->runningConsoleCommand('search:update')) {
            TorchlightOptions::setDefaultOptionsBuilder(fn () => TorchlightOptions::fromArray(config('torchlight.options')));

            $extension = new TorchlightExtension(config('torchlight.theme'));
            $extension
                ->renderer()
                ->setDefaultGrammar(config('torchlight.options.defaultLanguage'));

            Markdown::addExtension(fn () => $extension);
        }

        // Converts <ui-component /> to <ui-component></ui-component>
        Blade::prepareStringsForCompilationUsing(function ($template) {
            return str_contains($template, '<ui-')
                ? preg_replace_callback('/<(ui-[a-zA-Z0-9_-]+)([^>]*)\/>/',
                    fn($match) => "<{$match[1]}{$match[2]}></{$match[1]}>", $template)
                : $template;
        });

        Event::listen(SearchEntriesCreated::class, SearchEntriesCreatedListener::class);
    }
}

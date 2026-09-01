<?php

namespace App\Providers;

use App\Markdown\Hint\HintExtension;
use App\Markdown\Mermaid\MermaidExtension;
use App\Markdown\StripEnvTrailingNewlines;
use App\Markdown\Tabs\TabbedCodeBlockExtension;
use App\Search\Listeners\SearchEntriesCreatedListener;
use App\Search\Storybook\StorybookSearchProvider;
use App\Support\Description;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use League\CommonMark\Extension\Attributes\AttributesExtension;
use League\CommonMark\Extension\DescriptionList\DescriptionListExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use Statamic\Facades\Collection;
use Statamic\Facades\Markdown;
use Stillat\DocumentationSearch\Events\SearchEntriesCreated;
use Torchlight\Engine\CommonMark\Extension as TorchlightExtension;
use Torchlight\Engine\Options as TorchlightOptions;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Markdown::addExtensions(function () {
            return [new DescriptionListExtension, new HintExtension, new TabbedCodeBlockExtension, new AttributesExtension, new HeadingPermalinkExtension, new MermaidExtension];
        });

        if (! app()->runningConsoleCommand('search:update')) {
            TorchlightOptions::setDefaultOptionsBuilder(fn () => TorchlightOptions::fromArray(config('torchlight.options')));

            $extension = new TorchlightExtension(
                config('torchlight.theme'),
                true,
                ['env' => new StripEnvTrailingNewlines],
            );
            $extension
                ->renderer()
                ->setDefaultGrammar(config('torchlight.options.defaultLanguage'));

            Markdown::addExtension(fn () => $extension);
        }

        Event::listen(SearchEntriesCreated::class, SearchEntriesCreatedListener::class);

        $this->registerComputedValues();

        StorybookSearchProvider::register();
    }

    /**
     * A value every collection needs but no blueprint defines. Registering it as a computed
     * value means one implementation serves Antlers templates ({{ meta_description }}) and
     * PHP alike ($entry->value('meta_description')).
     */
    private function registerComputedValues(): void
    {
        $collections = [
            'pages', 'tags', 'modifiers', 'fieldtypes', 'variables',
            'widgets', 'tips', 'troubleshooting', 'resource_apis',
        ];

        Collection::computed($collections, 'meta_description', fn ($entry) => Description::for($entry));
    }
}

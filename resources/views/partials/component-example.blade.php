<div class="ui-component-example mb-6">
    <div class="border border-gray-200 rounded-xl rounded-b-none px-6 py-8 font-sans leading-normal text-gray-900 dark:text-white">
        {!! Blade::render($code) !!}
    </div>
    <div class="rounded-2xl rounded-t-none">{!! Statamic\Facades\Markdown::parse('```html'.PHP_EOL.$code.PHP_EOL.'```') !!}</div>
</div>

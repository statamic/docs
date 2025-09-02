{{-- <pre><x-torchlight-code>{{ $slot }}</x-torchlight-code></pre> --}}

{{-- {!! Illuminate\Support\Facades\Vite::getFacadeRoot()
    ->useHotFile('')
    ->withEntryPoints(['resources/js/app.js'])
    ->useBuildDirectory('/../vendor/statamic/cms/resources/dist/build')
    ->toHtml()
!!} --}}

{!! Statamic\Facades\Markdown::parse('```html'.PHP_EOL.$slot.PHP_EOL.'```') !!}
{!! $slot !!}

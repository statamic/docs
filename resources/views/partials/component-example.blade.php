{!! Statamic\Facades\Markdown::parse('```html'.PHP_EOL.$code.PHP_EOL.'```') !!}

<div class="border px-12 py-6 flex justify-center mb-[var(--spacing-m)]">
    {!! $code !!}
</div>

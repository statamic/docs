<div class="ui-component-example mb-6">
    <div class="border border-gray-200 rounded-xl rounded-b-none px-6 py-8">
        <iframe
            class="m-auto flex items-center justify-center space-x-4"
            src="{{ $url }}"
            id="component-iframe-{{ md5($url) }}"
        ></iframe>
    </div>
    <div class="rounded-2xl rounded-t-none">{!! Statamic\Facades\Markdown::parse('```html'.PHP_EOL.$code.PHP_EOL.'```') !!}</div>
</div>

<script>
    // Auto-resize iframe height to fit content
    window.addEventListener('message', function(event) {
        if (event.origin !== window.location.origin) {
            return; // Ignore messages from different origins
        }
        if (event.data && event.data.type === 'setHeight' && event.data.height && event.data.iframeId === 'component-iframe-{{ md5($url) }}') {
            var iframe = document.getElementById('component-iframe-{{ md5($url) }}');
            if (iframe) {
                console.log('Resizing iframe', event.data.iframeId, 'to height:', event.data.height);
                iframe.style.height = event.data.height + 'px';
            }
        }
    });
</script>

{!! Statamic\Facades\Markdown::parse('```html'.PHP_EOL.$code.PHP_EOL.'```') !!}

<iframe
    src="{{ $url }}" class="border border-gray-300 rounded-lg mb-[var(--spacing-m)]"
    id="component-iframe-{{ md5($url) }}"
></iframe>

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

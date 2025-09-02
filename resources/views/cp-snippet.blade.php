<html>
<head>
{{ Statamic::cpViteScripts() }}
<style>
:root {
    {{ \Statamic\CP\Color::cssVariables() }}
}
</style>
</head>
<body>
<div id="statamic" class="p-6 flex justify-center">
{!! $snippet !!}
</div>
<script>
    var StatamicConfig = {!! json_encode(Statamic::jsonVariables(request())) !!};
</script>

{{-- Deferred to allow Vite modules to load first --}}
<script
    src="data:text/javascript;base64,{{ base64_encode('Statamic.config(StatamicConfig); Statamic.start()') }}"
    defer
></script>
<script>
    // When the page is ready use postMessage to send the height of the content to the parent
    document.addEventListener('DOMContentLoaded', function() {
        // Wait a bit for content to fully render
        setTimeout(function() {
            var content = document.getElementById('statamic');
            var height = content ? content.offsetHeight : 200;
            console.log('Sending height to parent:', height, 'for iframe:', '{{ $id }}');
            window.parent.postMessage({ type: 'setHeight', height: height, iframeId: '{{ $id }}' }, window.location.origin);
        }, 1000);
    });
</script>
</body>
</html>

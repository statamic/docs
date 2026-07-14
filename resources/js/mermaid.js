const diagrams = document.querySelectorAll('pre.mermaid');

if (diagrams.length) {
    const { default: mermaid } = await import('mermaid');

    const sources = new Map();

    diagrams.forEach((el) => sources.set(el, el.textContent));

    const theme = () => document.documentElement.classList.contains('dark') ? 'dark' : 'default';

    let renderCount = 0;

    const render = () => {
        mermaid.initialize({ startOnLoad: false, theme: theme() });

        renderCount++;

        sources.forEach((source, el) => {
            const id = `mermaid-diagram-${renderCount}-${Math.random().toString(36).slice(2)}`;

            mermaid.render(id, source).then(({ svg }) => {
                el.innerHTML = svg;
            }).catch((err) => {
                console.error(err);
            });
        });
    };

    render();

    new MutationObserver(render).observe(document.documentElement, {
        attributes: true,
        attributeFilter: ['class'],
    });
}

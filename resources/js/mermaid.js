const diagrams = document.querySelectorAll('pre.mermaid');

if (diagrams.length) {
    const { default: mermaid } = await import('mermaid');

    const sources = new Map();

    diagrams.forEach((el) => sources.set(el, el.textContent));

    const isDark = () => document.documentElement.classList.contains('dark');

    const theme = () => (isDark() ? 'dark' : 'default');

    // Shared node styles — use `class SomeNode ok` / `class SomeNode nope` in diagrams.
    const classDefs = () => isDark()
        ? `
classDef ok fill:#14532D,stroke:#4ADE80,color:#DCFCE7
classDef nope fill:#4C0519,stroke:#FB7185,color:#FFE4E6
`
        : `
classDef ok fill:#E8F8EF,stroke:#1F9D55,color:#14532D
classDef nope fill:#FDE8EC,stroke:#D6455D,color:#4C0519
`;

    let renderCount = 0;

    const render = () => {
        mermaid.initialize({ startOnLoad: false, theme: theme() });

        renderCount++;

        sources.forEach((source, el) => {
            const id = `mermaid-diagram-${renderCount}-${Math.random().toString(36).slice(2)}`;
            const diagram = `${source.trimEnd()}\n${classDefs()}`;

            mermaid.render(id, diagram).then(({ svg }) => {
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

import "meilisearch-docsearch/css";
import { docsearch } from "meilisearch-docsearch";

// This is smart enough to filter out cmd or ctrl based on OS.
// Precedence also allows `/` to be used, but isn't shown.
let hotKeys = [
    "cmd+k",
    "ctrl+k",
    "/",
];

docsearch({
    container: "#docsearch",
    host: "https://search.statamic.dev",
    apiKey: "a8b8f82076221f9595dceca971be29c36cbccd772de5dbdb7f43dfac41557f95",
    indexUid: `docs-${import.meta.env.VITE_STATAMIC_DOCS_VERSION}`,
    hotKeys: hotKeys,
});

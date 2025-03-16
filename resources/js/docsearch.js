import "meilisearch-docsearch/css";
import { docsearch } from "meilisearch-docsearch";

docsearch({
    container: "#docsearch",
    host: "https://search.statamic.dev",
    apiKey: "a8b8f82076221f9595dceca971be29c36cbccd772de5dbdb7f43dfac41557f95",
    indexUid: "default",
    hotKeys: ['ctrl+k', '/']
});
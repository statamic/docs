import "meilisearch-docsearch/css";
import { docsearch } from "meilisearch-docsearch";

// This is smart enough to filter out cmd or ctrl based on OS.
// Precedence also allows `/` to be used, but isn't shown.
let hotKeys = [
    "cmd+k",
    "ctrl+k",
    "/",
];

// Set flag when docsearch button is clicked
document.addEventListener('click', (e) => {
    if (e.target.closest('#docsearch button')) {
        console.log('Setting scrollNextPage from button click');
        sessionStorage.setItem('scrollNextPage', 'true');
    }
});

docsearch({
    container: "#docsearch",
    host: "https://search.statamic.dev",
    apiKey: "a8b8f82076221f9595dceca971be29c36cbccd772de5dbdb7f43dfac41557f95",
    indexUid: "default",
    hotKeys: hotKeys,
    onOpen: () => {
        console.log('Setting scrollNextPage from onOpen');
        sessionStorage.setItem('scrollNextPage', 'true');
    }
});

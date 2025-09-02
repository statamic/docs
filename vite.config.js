import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        tailwindcss(),
        laravel({
            input: [
                // CSS
                "resources/css/style.css",
                // JS
                "resources/js/site.js",
            ],
        }),
    ],
    publicDir: "public",
    server: {
        fs: {
            allow: [".."],
        },
    },
    css: {
        devSourcemap: true,
    },
});

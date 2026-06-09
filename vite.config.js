import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    plugins: [
        tailwindcss(),
        laravel({
            input: [
                "resources/css/style.css",
                "resources/js/site.js",
            ],
        }),
        vue(),
    ],
    server: {
        fs: {
            allow: [".."],
        },
    },
    css: {
        devSourcemap: true,
    },
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
            '@': path.resolve(__dirname, 'vendor/statamic/cms/resources/js')
        },
    }
});

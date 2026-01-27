import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from 'tailwindcss';
import autoprefixer from 'autoprefixer';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', // Your main CSS file
                'resources/js/app.js',
                'node_modules/summernote/dist/summernote-lite.min.css',
                'node_modules/summernote/dist/summernote-lite.min.js'
            ],
            refresh: true,
        }),
    ],
    css: {
        postcss: {
            plugins: [
                tailwindcss(),
                autoprefixer(),
            ],
        },
    },
    build: {
        rollupOptions: {
            output: {
                assetFileNames: (assetInfo) => {
                    if (assetInfo.name === 'app.css') {
                        return 'assets/css/main.css'; // Always use this name (will overwrite existing)
                    }
                    return 'assets/[name]-[hash][extname]'; // Default for other assets
                },
                entryFileNames: 'assets/js/[name]-[hash].js',
            },
        },
    },
});
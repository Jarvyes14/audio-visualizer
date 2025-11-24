import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            buildDirectory: 'build',   // ← carpeta relativa a public/
            manifest: 'manifest.json', // ← nombre del archivo
        }),
    ],
    build: {
        manifest: true,           // ← genera manifest.json
        outDir: 'public/build',   // ← ya lo tenías
    },
});

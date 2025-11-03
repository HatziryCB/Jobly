import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { resolve } from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    build: {
        manifest: true,
        outDir: 'public/build',
        emptyOutDir: true,
        rollupOptions: {
            input: [
                resolve(__dirname, 'resources/css/app.css'),
                resolve(__dirname, 'resources/js/app.js'),
            ],
            output: {
                entryFileNames: 'assets/[name].js',
                chunkFileNames: 'assets/[name].js',
                assetFileNames: 'assets/[name].[ext]',

                dir: 'public/build',
            },
        },
    },
    server: {
        host: '127.0.0.1',
        port: 5173,
        strictPort: true,
        cors: true,
    }

});

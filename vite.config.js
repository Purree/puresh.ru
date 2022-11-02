import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel([
            'resources/sass/app.scss',
            'resources/js/app.js',
            'resources/js/home/canvas.js',
            'resources/js/notes/wheelzoom.js',
        ]),
    ],
    resolve: {
        extensions: ['.mjs', '.js', '.ts', '.jsx', '.tsx', '.json'],
        alias: {
            '@': '/resources/js',
            '@@': '/resources/sass',
            '~': '/node_modules/',
        }
    }
});
